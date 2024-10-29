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
        <a href="{{ route('categories.index') }}">
            <div class="parent-icon"><i class="bx bx-category"></i>
            </div>
            <div class="menu-title">Categories</div>
        </a>
    </li>

    <li>
        <a href="javascript:;" class="has-arrow">
            <div class="parent-icon"><i class='bx bx-user'></i>
            </div>
            <div class="menu-title">Users</div>
        </a>
        <ul>
            {{-- <li> <a href="{{ route('regular.index') }}"><i class="bx bx-right-arrow-alt"></i>Regular</a></li> --}}
            <li> <a href="{{ route('admins.index') }}"><i class="bx bx-right-arrow-alt"></i>Admins</a></li>
        </ul>
    </li>
 


</ul>