<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="fb:app_id" content="1053810061364111" />
    {!! Meta::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! Twitter::generate() !!}
    <link rel="canonical" href="{{ Request::url() }}" />

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
<body class="{{ AppHelper\bodyClass() }}">

    <script>
    window.fbAsyncInit = function() {
      FB.init({
        appId      : '622602667914388',
        xfbml      : true,
        version    : 'v2.6'
      });
    };

    (function(d, s, id){
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) {return;}
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/pt_BR/sdk.js";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
    </script>

    <!-- header -->
    @include('blog.front.partials.header')
    <!-- content -->
    @yield('content')
    <!-- footer -->
    @include('blog.front.partials.footer')
    @include('blog.front.partials.slidemenu')
    @include('blog.front.partials.tags')
    @include('blog.front.partials.search')
    <!-- scripts -->
    @include('blog.front.partials.scripts')
    <!-- google analytics -->
    @include('blog.front.partials.analytics')
    <!-- alexa -->
    @include('blog.front.partials.alexa')
    <!-- zopim -->
    @include('blog.front.partials.zopim')
</body>
</html>
