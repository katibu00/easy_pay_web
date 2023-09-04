<ul class="metismenu" id="menu">
    <li>
        <a href="{{ route('home.admin') }}">
            <div class="parent-icon"><i class="bx bx-home-circle"></i>
            </div>
            <div class="menu-title">Home</div>
        </a>
    </li>
    <li>
        <a href="javascript:;" class="has-arrow">
            <div class="parent-icon"><i class='bx bx-cart'></i>
            </div>
            <div class="menu-title">Products</div>
        </a>
        <ul>
            <li> <a href="{{ route('products.index') }}"><i class="bx bx-right-arrow-alt"></i>All Product</a></li>
            <li> <a href="{{ route('products.create') }}"><i class="bx bx-right-arrow-alt"></i>New Product</a></li>
        </ul>
    </li>
    <li>
        <a href="javascript:;" class="has-arrow">
            <div class="parent-icon"><i class='bx bx-cookie'></i>
            </div>
            <div class="menu-title">Combos</div>
        </a>
        <ul>
            <li> <a href="{{ route('combos.index') }}"><i class="bx bx-right-arrow-alt"></i>All Combos</a></li>
            <li> <a href="{{ route('combos.create') }}"><i class="bx bx-right-arrow-alt"></i>New Combo</a></li>
        </ul>
    </li>
 
    {{-- <li class="menu-label">UI Elements</li> --}}


</ul>