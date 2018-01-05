<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="apple-touch-icon" href="pages/ico/60.png">

    <title>@yield('title') | BRZ Panel</title>

    <!-- Begin icons -->
    <link rel="apple-touch-icon" sizes="76x76" href="pages/ico/76.png">
    <link rel="apple-touch-icon" sizes="120x120" href="pages/ico/120.png">
    <link rel="apple-touch-icon" sizes="152x152" href="pages/ico/152.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">

    @include('blog.back.partials.styles')

    <script type="text/javascript">
    window.onload = function()
    {
      // fix for windows 8
      if (navigator.appVersion.indexOf("Windows NT 6.2") != -1)
        document.head.innerHTML += '<link rel="stylesheet" type="text/css" href="/brzbox/pages/css/windows.chrome.fix.css" />'
    }
    </script>
</head>
<body class="fixed-header menu-behind">

    @if (Sentinel::check())
        @include('blog.back.partials.sidebar')
        <div class="page-container">
            @include('blog.back.partials.header')
            <div class="page-content-wrapper">
                <div class="content">
                    @crumbs('blog.vendor.crumbs.breadcrumbs_painel')
                    <!-- Start notifications -->
                    @include('flash::message', ['fixed' => true])
                    <!-- Start content -->
                    <div class="container-fluid sm-p-l-20 sm-p-r-20">
                    @yield('content')
                    </div>
                </div>
                <!-- Start footer -->
                @include('blog.back.partials.footer')
            </div>
        </div>

        @include('blog.back.partials.modal')
    @else
        @yield('content')
    @endif

    @include('blog.back.partials.scripts')

</body>
</html>
