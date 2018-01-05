<!DOCTYPE html>
<html class="no-js" lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta content="IE=edge" http-equiv="X-UA-Compatible">
  <meta content="width=device-width, initial-scale=1, user-scalable=0" name="viewport">
  <meta property="fb:app_id" content="1053810061364111" />
{!! Meta::generate() !!}

<!-- styles -->
@include('dashboard.partials.styles')

<!-- icons -->
@include('dashboard.partials.icons')

<!-- scripts -->
  <script src="https://code.jquery.com/jquery-3.1.0.min.js" integrity="sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s=" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

<script>
    window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
    ]); ?>
</script>

<!--[if (lt IE 9) & (!IEMobile)]>
<p class="browsehappy">Você está usando um <strong>navegador antigo</strong>. Por favor <a href="http://browsehappy.com/">atualize o seu navegador</a> para uma boa experiência.</p>
<![endif]-->

<noscript>
  <div class="Alert Alert--javascript">
    Para completa funcionalidade deste site é necessário habilitar o JavaScript. <a href="http://www.enable-javascript.com/pt/" target="_blank">Aqui</a> estão as instruções de como habilitar o JavaScript em seu navegador.
  </div>
</noscript>


<!-- profile sidebar -->

<!-- schedule timer -->
@include('dashboard.partials.timer')
<body class='dashboard profile'>
<!-- content -->
<main class="main_content" role="main" id="app">
  <!-- navbar -->
  @include('dashboard.partials.navbar')

  @yield('content')
</main>

<!-- footer -->
@include('dashboard.partials.footer')

<!-- scripts -->
@include('dashboard.partials.scripts')

<!-- google analytics -->
@include('dashboard.partials.analytics')

</body>
</html>
