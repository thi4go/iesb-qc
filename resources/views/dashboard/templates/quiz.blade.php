<!DOCTYPE html>
<html class="no-js" lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1, user-scalable=0" name="viewport">
    <meta property="fb:app_id" content="1053810061364111" />
    {!! Meta::generate() !!}
@include('dashboard.partials.styles')

@include('dashboard.partials.icons')

</head>

<body class="homes main_wrapper dashboard">
<script>
    window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
    ]); ?>
</script>

    <!-- schedule timer -->
    @include('dashboard.partials.timer')

    <main class="main_content" role="main" id="app">
        <div>
            @include('dashboard.partials.navbar')
        </div>

        @yield('content')
    </main>

    <footer class="main_footer Footer">
        @include('dashboard.partials.footer')
    </footer>

    @include('dashboard.partials.scripts')


</body>

</html>
