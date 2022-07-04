<header>
    <nav class="py-2">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-3">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('assets/frontend/img/logo.png') }}" width="180" alt="logo">
                    </a>
                </div>
                <div class="col-md-9">
                    <ul class="nav_list">
                        <li>
                            <a href="{{ route('home') }}">Home</a>
                        </li>
                        <li>
                            <a href="#">Ticket Track</a>
                        </li>
                        <li>
                            <a href="#">About</a>
                        </li>
                        <li>
                            <a href="#">Contact</a>
                        </li>
                        <li>
                            @guest
                                <a href="{{ route('login') }}">Login</a>
                            @endguest
                            @auth
                                <a href="{{ route('admin.dashboard') }}">Admin</a>
                            @endauth
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <div class="img_shadow position-absolute w-100">
        <img src="{{ asset('assets/frontend/img/shadow.png') }}" alt="shadow" class="img-fluid w-100">
    </div>
</header>
