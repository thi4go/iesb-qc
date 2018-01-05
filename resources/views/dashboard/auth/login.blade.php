@extends('dashboard.templates.login')

@section('content')

<section class="Section Section--default">
    <div class="container">
        @if (app('request')->input('failed'))
        <div class="alert alert-danger">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            Insira credenciais válidas para acessar sua conta
        </div><br>
        @endif

        @if (app('request')->input('payment_missing'))
        <div class="alert alert-danger">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            O seu pagamento ainda não foi confirmado
        </div><br>
        @endif

    <div class="row">
        <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">

                <div class="Widget Widget-bgWhite Widget-padding u-m-b-20">
                    <div class="Widget-header text-center">
                        <h2 class="Widget-title Widget-title--min Widget-title--color15">Identifique-se</h2>
                    </div>
                    <div class="Widget-content u-m-b-30">
                        <form method="post" route="dashboard.login" class="Form Formdefault">
                            <div class="form-group">
                                <label for="email" class="sr-only">E-mail</label>
                                <input name="email" type="text" placeholder="Insira o seu e-mail" class="Form-input form-control input-lg">
                            </div>
                            <div class="form-group">
                                <label for="password" class="sr-only">Senha</label>
                                <input name="password" type="password" placeholder="Insira sua senha" class="Form-input form-control input-lg">
                            </div>
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
                            <div class="text-center">
                                <button class="Button Button--default Button--defaultGreen" type="submit">Entrar</button>
                            </div>
                        </form>
                    </div>
                    <div class="Widget-footer text-center">
                        <a href="/dashboard/forgot-password" class="Widget-link Widget-link--color15 Widget-link--min u-m-b-20">Esqueceu sua senha?</a>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop
