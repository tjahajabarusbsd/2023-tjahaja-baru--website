@php
    // /products menampilkan MAXi, jadi MAXi dianggap aktif di sana
    $current = request()->is('products')
        ? 'maxi'
        : (request()->is('products/category/*')
            ? request()->segment(3)
            : null);
@endphp

@foreach (config('product_categories') as $slug => $cat)
    @php $isCurrent = $slug === $current; @endphp
    <div @class(['product-icon-box', 'active' => $isCurrent])>
        <a href="/products/category/{{ $slug }}" @if ($isCurrent) aria-current="page" @endif>
            <img src="{{ url("images/products/icons/{$slug}_i.png") }}" alt="" class="icon">
            <p class="text">{{ $cat['name'] }}</p>
        </a>
    </div>
@endforeach

<div class="product-icon-box compare-menu">
    <a href="/compare_product">Compare Product</a>
</div>
