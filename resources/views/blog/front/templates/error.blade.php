<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Página não encontrada | {{ Config::get('brz.app.name') }}</title>

    <!-- styles -->
    @include('blog.front.partials.styles')

    <!-- icons -->
    @include('blog.front.partials.icons')

    <!-- scripts -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="error">
    <!-- header -->
    @include('blog.front.partials.header')
    <!-- content -->
    @yield('content')
    <!-- footer -->
    @include('blog.front.partials.footer')
    <!-- widgets -->
    @include('blog.front.partials.slidemenu')
    @include('blog.front.partials.tags')
    @include('blog.front.partials.search')
    <!-- scripts -->
    @include('blog.front.partials.scripts')
</body>
</html>
