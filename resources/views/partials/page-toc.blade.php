<nav class="page-toc" aria-label="Daftar isi halaman">
    {{-- garis-garis kecil (rail) --}}
    <ul class="page-toc__rail" aria-hidden="true">
        @foreach ($items as $id => $label)
            <li data-toc-tick="{{ $id }}"></li>
        @endforeach
    </ul>

    {{-- panel yang muncul saat hover --}}
    <div class="page-toc__panel">
        <p class="page-toc__title">Contents</p>
        <ul>
            @foreach ($items as $id => $label)
                <li>
                    <a href="#{{ $id }}" class="page-toc__link" data-toc-link="{{ $id }}">{{ $label }}</a>
                </li>
            @endforeach
        </ul>
    </div>
</nav>