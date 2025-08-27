@auth
    @include('layout.header')
    @include('layout.left-sidebar')
    @yield('content')
    @include('layout.right-sidebar')
    @include('layout.footer')
@endauth
