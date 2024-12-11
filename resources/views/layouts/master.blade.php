
@include('layouts.header')
@include('layouts.sidebar')
<main class="app-content">
    @yield('content') <!-- Ini adalah tempat di mana konten dari child view akan dimasukkan -->
</main>
@include('layouts.footer')


