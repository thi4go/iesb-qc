<!DOCTYPE html>
<html class="no-js" lang="pt-br" xmlns="http://www.w3.org/1999/html">
<head>
  <meta charset="utf-8">
  <meta content="IE=edge" http-equiv="X-UA-Compatible">
  <meta content="width=device-width, initial-scale=1, user-scalable=0" name="viewport">
  <meta property="fb:app_id" content="1053810061364111" />
  <meta property="fb:admins" content="100012378641360"/>
{!! Meta::generate() !!}

<!-- styles -->
@include('dashboard.partials.styles')

<!-- icons -->
  @include('dashboard.partials.icons')

</head>

<script>
    window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
    ]); ?>
</script>




<!-- content -->
<main class="main_content" role="main" id="app">
    @include('dashboard.partials.navbarLogin')

  @yield('content')
</main>

<!-- footer -->
@include('dashboard.partials.footer')

<!-- scripts -->
@include('dashboard.partials.scripts')

<!-- google analytics -->
@include('dashboard.partials.analytics')


@include('dashboard.partials.facebook')



</body>
</html>
