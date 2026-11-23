@php
    $token = $entry->checkin_token ?? null;
@endphp

@if (! $token)
    <p class="text-muted mb-0">Token QR belum tersedia untuk event ini.</p>
@else
    <div class="d-flex align-items-start">
        <img
            src="{{ backpack_url('event/' . $entry->getKey() . '/qr') }}"
            alt="QR Check-in {{ $entry->name }}"
            style="width: 180px; height: 180px; border: 1px solid #e4e4e4; border-radius: 8px;"
        >
        <div class="ml-3">
            <div class="text-muted small mb-1">Isi QR</div>
            <code class="d-block mb-2">{{ $token }}</code>
            <a href="{{ backpack_url('event/' . $entry->getKey() . '/qr') }}?download=1" class="btn btn-sm btn-primary">
                <i class="la la-download"></i> Download SVG
            </a>
            <div class="text-muted small mt-2">
                Cetak QR ini dan tempel di lokasi event. QR hanya bisa dipakai selama check-in aktif
                dan dalam rentang tanggal check-in.
            </div>
        </div>
    </div>
@endif
