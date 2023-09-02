<nav class="main-header navbar navbar-expand navbar-dark">
    <a href="/" class="navbar-brand ml-5">
        <span class="brand-text font-weight-light"><b>{{ __("Plant") }}</b><em>{{ __("AI") }}</em></span>
    </a>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

        <li class="nav-item mr-2">
        <li class="nav-item">
            <a class="nav-link text-danger" href="{{ route('logout') }}"
               onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt ml-1"></i>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
        </li>
    </ul>
</nav>
