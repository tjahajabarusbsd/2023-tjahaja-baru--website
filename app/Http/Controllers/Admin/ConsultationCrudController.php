<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ConsultationRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Backpack\CRUD\app\Library\Widget;

/**
 * Class ConsultationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ConsultationCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Consultation::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/consultation');
        CRUD::setEntityNameStrings('consultation', 'consultations');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // Ambil filter bulan dan tahun dari request
        $month = request()->get('month', now()->month); // Default ke bulan saat ini
        $year = request()->get('year', now()->year);   // Default ke tahun saat ini

        // Hitung jumlah konsultasi berdasarkan filter
        $totalConsultations = \App\Models\Consultation::when($month, function ($query, $month) {
            return $query->whereMonth('created_at', $month);
        })
            ->when($year, function ($query, $year) {
                return $query->whereYear('created_at', $year);
            })
            ->count();

        $targetConsultation = 1000;
        $progress = ($totalConsultations / $targetConsultation) * 100;

        Widget::add()
            ->to('before_content')
            ->type('div')
            ->class('row col-md-12')
            ->content([
                [
                    'type' => 'progress',
                    'class' => 'card text-white bg-primary mb-2',
                    'value' => number_format($totalConsultations, 0, ',', '.'),
                    'description' => 'Total konsultasi bulan ini.',
                    'progress' => $progress,
                    'hint' => ($targetConsultation - $totalConsultations) . ' more until next milestone.',
                ]
            ]);

        $currentMonth = now()->month; // Bulan saat ini
        $currentYear = now()->year;   // Tahun saat ini

        // Tambahkan filter bulan dan tahun
        $this->crud->addFilter([
            'type' => 'dropdown',
            'name' => 'month',
            'label' => 'Bulan'
        ], [
            '1' => 'Januari',
            '2' => 'Februari',
            '3' => 'Maret',
            '4' => 'April',
            '5' => 'Mei',
            '6' => 'Juni',
            '7' => 'Juli',
            '8' => 'Agustus',
            '9' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ], function ($value) {
            $this->crud->addClause('whereMonth', 'created_at', $value);
        });

        $this->crud->addFilter([
            'type' => 'dropdown',
            'name' => 'year',
            'label' => 'Tahun'
        ], function () {
            // Generate tahun secara dinamis (misal dari 5 tahun terakhir)
            $years = [];
            for ($i = 0; $i < 5; $i++) {
                $years[date('Y') - $i] = date('Y') - $i;
            }
            return $years;
        }, function ($value) {
            $this->crud->addClause('whereYear', 'created_at', $value);
        });

        // Tetapkan filter default untuk bulan dan tahun saat ini
        if (!request()->has('month') && !request()->has('year')) {
            CRUD::addClause('whereMonth', 'created_at', $currentMonth);
            CRUD::addClause('whereYear', 'created_at', $currentYear);
        }

        CRUD::column('sales_code');
        CRUD::addColumn([
            'name' => 'sales_name',
            'label' => 'Sales Name',
            'type' => 'closure',
            'function' => function ($entry) {
                $salesCode = $entry->sales_code;
                $staff = \App\Models\Staff::where('code', $salesCode)->first();
                return $staff ? $staff->name : "Habib";
            },
        ]);
        CRUD::addColumn([
            'name' => 'division',
            'label' => 'Division',
            'type' => 'closure',
            'function' => function ($entry) {
                $salesCode = $entry->sales_code;
                $staff = \App\Models\Staff::where('code', $salesCode)->first();
                return $staff ? $staff->division : "CRO";
            },
        ]);
        CRUD::column('name')->label('Nama Konsumen')->type('text');
        CRUD::column('nohp')->label('No HP')->type('text');
        CRUD::column('product');
        CRUD::column('cara_bayar');
        CRUD::column('dp');
        CRUD::column('tenor');
        CRUD::column('utm_campaign');
        CRUD::addColumn([
            'name' => 'status',
            'label' => 'Status',
            'type' => 'closure',
            'function' => function ($entry) {
                // Cek apakah status sudah ada di cache
                $cacheKey = 'status_' . $entry->nohp;
                $status = Cache::get($cacheKey);
                // Ambil bulan dan tahun dari created_at
                $year = date('Y', strtotime($entry->created_at));  // Ambil tahun (YYYY)
                $month = date('m', strtotime($entry->created_at)); // Ambil bulan (MM)
    
                if (!$status) {
                    try {
                        $urlSalesStatus = env('GET_URL_SALES_STATUS');
                        $apiUrl = $urlSalesStatus . "?nohp=" . urlencode($entry->nohp) . '&year=' . urlencode($year) . '&month=' . urlencode($month);
                        $response = Http::withoutVerifying()->get($apiUrl);

                        // Mendapatkan data response JSON dari API
                        $data = json_decode($response->getBody(), true);

                        if (isset($data['rows'][0])) {
                            $row = $data['rows'][0];
                            $a = $row['a_pr_id'] ?? null;
                            $b = $row['b_id_prospek'] ?? null;
                            $c = $row['c_sales_id'] ?? null;

                            if ($a !== null && $b === null && $c === null) {
                                $status = 'Prospek';
                            } elseif ($a !== null && $b !== null && $c === null) {
                                $status = 'SPK';
                            } elseif ($a !== null && $b !== null && $c !== null) {
                                $status = 'STU';
                            } else {
                                $status = null;
                            }
                        } else {
                            $status = null; // Tidak ada hasil
                        }

                        // Simpan status di cache selama 60 menit
                        Cache::put($cacheKey, $status, 60); // Caching selama 60 menit
                    } catch (\Exception $e) {
                        $status = 'Error fetching status';
                    }
                }

                return $status;
            },
        ]);
        CRUD::column('created_at')->type('datetime')->format('M/DD/YYYY HH:mm:ss');
        // CRUD::column('updated_at');
        CRUD::enableExportButtons();

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ConsultationRequest::class);

        CRUD::field('name');
        CRUD::field('nohp');
        CRUD::field('product');
        CRUD::field('url');
        CRUD::field('sales_code');
        CRUD::field('utm_campaign');
        CRUD::field('cara_bayar');
        CRUD::field('dp');
        CRUD::field('tenor');

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}