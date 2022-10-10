<nav
    class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow container-xxl">
    <div class="navbar-container d-flex content">
        <ul class="nav navbar-nav align-items-center ml-auto">
            <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-style"><i class="ficon"
                        data-feather="moon"></i></a></li>
            <li class="nav-item dropdown dropdown-user">
                <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="javascript:void(0);"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="user-nav d-sm-flex d-none">
                        <span class="user-name font-weight-bolder">{{ Auth::guard('admin')->user()->name }}</span>
                        <span class="user-status text-uppercase">{{ Auth::guard('admin')->user()->role }}</span>
                    </div>
                    <span class="avatar">
                        <img class="round" src="{{ $base_url }}app-assets/images/portrait/small/avatar-s-11.jpg"
                            alt="avatar" height="40" width="40">
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-user">
                    <a class="dropdown-item" href="page-profile.html">
                        <i class="mr-50" data-feather="user"></i>
                        Profile
                    </a>
                    <form method="POST" action="{{ route('admin.logout') }}" class="d-inline-block">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="mr-50" data-feather="power"></i> Logout
                        </button>
                    </form>
                </div>
            </li>
        </ul>
    </div>
</nav>