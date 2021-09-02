<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand text-uppercase font-weight-bold ml-5" href="{{ route('home') }}"><span
            class="text-blue">brainster</span><span class="text-gray">preneurs</span></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto text-center font-weight-bold">
            <li class="nav-item ml-5 mr-5">
                <a class="nav-link p-0" href="{{ route('projects') }}">
                    <img src="{{ Auth::user()->image }}" alt="" class="rounded-circle profile-thumbnail" />
                </a>
            </li>
        </ul>
    </div>
</nav>
