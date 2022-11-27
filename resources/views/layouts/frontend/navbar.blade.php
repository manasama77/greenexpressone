<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <!-- Brand -->
        <a class="navbar-brand" href="/">
            <div class="navbar-brand-img">
                <img src="/img/logo-green-express-one.png" alt="Logo {{ $app_name }}" class="img-logo">
            </div>
        </a>

        <!-- Toggler/collapsibe Button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="/">Home</a>
                </li>
                @foreach ($pages as $page)
                    @if (!in_array($page->id, [1, 2]))
                        <li class="nav-item">
                            <a class="nav-link" href="/page/{{ $page->slug }}">{{ $page->page_title }}</a>
                        </li>
                    @endif
                @endforeach
                <li class="nav-item">
                    <button type="button" class="nav-link font-weight-bold btn btn-dark text-white px-2 shadow"
                        onclick="showModalCheck()">
                        <i class="fas fa-search fa-fw"></i> Check Booking
                    </button>
                </li>
            </ul>
        </div>
    </div>
</nav>
