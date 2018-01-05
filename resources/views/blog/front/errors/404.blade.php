@extends('blog.front.templates.error')

@section('content')
<section class="Error">
  <div class="container">
    <div class="row">
      <header class="Error-header col-xs-12">
        <h2 class="Error-title">Ops!</h2>
        <h3 class="Error-subtitle">Página não encontrada.</h3>
      </header>
      <article class="Error-content col-xs-12">
        <p class="Error-text">O endereço <span class="Error-url label">{{ Request::url() }}</span> não existe em nosso site.</p>
      </article>
    </div>
  </div>
</section>
@endsection
