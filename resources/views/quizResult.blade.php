<!-- quizResult.blade.php -->

@foreach ($groups as $group)
    <div class="grid-content">
        <a class="product-link" href="/product/{{ $group->uri }}">
            <div class="box-img">
                <img src="{{ url($group->image) }}" alt="" class="product-unit-image">
            </div>
            <div class="box-text">
                <p class="caption">OTR Sumatera Barat, Mulai Dari</p>
                <p class="product-price">{{ $group->price }}</p>
                <img class="tombol-biru" src="{{ url('/images/tombol1.png')}}" alt="">
            </div>
        </a>
    </div>
@endforeach
