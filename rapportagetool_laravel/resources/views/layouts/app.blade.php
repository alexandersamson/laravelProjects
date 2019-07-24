<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        @include('modals.generic-info-modal')
        @include('modals.generic-form-modal')
        @include('modals.generic-append-modal')
        @include('modals.generic-delete-modal')
        @include('modals.generic-erase-modal')
        @include('modals.generic-recover-modal')
        @include('includes.navbar')
        <main class="container">
            @include('includes.messages')
            @yield('content')
        </main>
    </div>
</body>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
{{--<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>--}}
<script src="/vendor/clipboard/dist/clipboard.min.js"></script>


{{--<script>--}}
{{--    try{--}}
{{--        CKEDITOR.replace( 'article-ckeditor' );--}}
{{--    } catch (e) {console.log('ckeditor not loaded');}--}}
{{--</script>--}}
</html>
