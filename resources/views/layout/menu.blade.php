<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand navbar-web" href="#"><font class="text-warning">INTRA</font>NET</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a>
                </li>
                <li class="nav-item {{ request()->is('search') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/search') }}"><i class="fa fa-search"></i> Search</a>
                </li>
                @if(auth()->user()->isAdmin())
                <li class="nav-item {{ request()->is('folders') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/folders') }}"><i class="fa fa-folder-o"></i> Manage Folders</a>
                </li>
                <li class="nav-item {{ request()->is('users') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/users') }}"><i class="fa fa-users"></i> Users</a>
                </li>
                @endif
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                        <i class="fa fa-user"></i> Hi, {{ ucfirst(strtolower(Auth::user()->fname)) }}
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ url('/logout') }}"><i class="fa fa-sign-out mr-1"></i> Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
