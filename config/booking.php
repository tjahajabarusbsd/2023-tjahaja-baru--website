<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Batas Waktu Pembatalan Booking Servis
    |--------------------------------------------------------------------------
    |
    | User hanya boleh membatalkan booking servisnya sendiri sampai N jam
    | sebelum jam servis. Setelah batas ini lewat, pembatalan lewat aplikasi
    | ditutup dan user diarahkan menghubungi dealer.
    |
    | Nilai ini juga menjadi acuan teks aturan di aplikasi mobile.
    |
    */

    'cancel_cutoff_hours' => (int) env('BOOKING_CANCEL_CUTOFF_HOURS', 2),

];
