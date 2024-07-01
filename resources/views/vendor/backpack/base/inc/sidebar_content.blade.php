<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
{{-- <li class='nav-item'><a class='nav-link' href='{{ backpack_url('tag') }}'><i class='nav-icon la la-tag'></i> Tags</a></li> --}}
{{-- <li class='nav-item'><a class='nav-link' href='{{ backpack_url('article') }}'><i class='nav-icon la la-book'></i> Articles</a></li> --}}

{{-- <li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-motorcycle"></i> Products</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('maxi') }}"><i class="nav-icon la la-tachometer-alt"></i> <span>Maxi</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('sport') }}"><i class="nav-icon la la-tachometer-alt"></i> <span>Sport</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('classy') }}"><i class="nav-icon la la-tachometer-alt"></i> <span>Classy</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('matic') }}"><i class="nav-icon la la-tachometer-alt"></i> <span>Matic</span></a></li>
    </ul>
</li> --}}

@if(backpack_user()->hasRole('admin'))
<!-- Users, Roles, Permissions -->
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-users"></i> Authentication</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-user"></i> <span>Users</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i class="nav-icon la la-id-badge"></i> <span>Roles</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}"><i class="nav-icon la la-key"></i> <span>Permissions</span></a></li>
    </ul>
</li>
@endif

<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-motorcycle"></i> Products</a>
    <ul class="nav-dropdown-items">
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('category') }}'><i class=''></i> Categories</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('group') }}'><i class=''></i> Groups</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('variant') }}'><i class=''></i> Variants</a></li>
    </ul>
</li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('banner') }}'><i class='nav-icon las la-images'></i>Home Banners</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('promo') }}'><i class='nav-icon las la-scroll'></i> Promo</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('contact') }}'><i class='nav-icon las la-paperclip'></i> Pesan & Kritik</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('dealer') }}'><i class='nav-icon las la-industry'></i> Dealer</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('review') }}'><i class='nav-icon la la-question'></i> Reviews</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('group-product-spec') }}"><i class="nav-icon las la-wrench"></i> Group product specs</a></li>