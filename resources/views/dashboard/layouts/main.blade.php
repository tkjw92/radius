<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/fontawesome-5/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/dashboard/css/adminlte.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/dashboard/css/style.css">
    @yield('header')
</head>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed">
    <div class="wrapper">

        {{-- navbar --}}
        @include('dashboard.layouts.navbar')

        {{-- sidebar --}}
        @include('dashboard.layouts.sidebar')

        {{-- main content --}}
        @yield('content')

        {{-- footer --}}
        @include('dashboard.layouts.footer')
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/bootstrap-4/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets') }}/dashboard/js/adminlte.min.js"></script>
    <script>
        function createRipple(event) {
            const button = event.currentTarget;
            const ripple = document.createElement("span");
            const rect = button.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = event.clientX - rect.left - size / 2;
            const y = event.clientY - rect.top - size / 2;

            ripple.style.width = ripple.style.height = `${size}px`;
            ripple.style.left = `${x}px`;
            ripple.style.top = `${y}px`;

            ripple.classList.add("ripple");

            button.appendChild(ripple);
            ripple.addEventListener("animationend", () => {
                ripple.remove();
            });
        }
    </script>
    @yield('script')
</body>

</html>
