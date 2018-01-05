<style scoped>
    h2 {
        text-align: center;
        text-transform: uppercase;
        font-size: 1.375rem;
        line-height: 1.65rem;
        margin: 0rem 0rem 1.25rem 0rem;
        font-weight: 100;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #303030;
    }

    p {
        font-size: 15px;
    }

</style>
<template xmlns:v-model="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <section class="Section Section--default">
        <div class="container">
            <!--Testar usuario existente-->
            <!--email.Unique-->
            <div v-if="errors.hasOwnProperty('email') ">
                <div v-if="('Unique' in errors.email)" class="alert alert-danger">
                    Um usuário com esse email já existe. Acesse sua conta ou cadastre-se com outro endereço de email.
                </div>
            </div>
            <div v-if="exception_thrown" class="alert alert-warning">
                Ocorreu um erro no sistema. Por favor, tente novamente.
            </div>
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                    <div class="Widget Widget-bgWhite Widget-padding u-m-b-20">
                        <div class="Widget-header text-center">
                            <h2 class="Widget-title Widget-title--min Widget-title--color15">Registre-se</h2>
                        </div>
                        <div class="Widget-content">
                            <!--Com facebook-->
                            <!--<div class="text-center">-->
                            <!--&lt;!&ndash;{{&#45;&#45;<a href="/dashboard/redirect" class="Button Button&#45;&#45;default Button&#45;&#45;defaultFacebook Icon Icon&#45;&#45;facebookBefore u-m-b-10" title="Com facebook">Com facebook</a>&#45;&#45;}}&ndash;&gt;-->
                            <!--&lt;!&ndash;{{&#45;&#45;<p class="Widget-text">ou</p>&#45;&#45;}}&ndash;&gt;-->
                            <!--</div>-->
                            <div class="Form Formdefault">
                                <div class="form-group">
                                    <label>Nome </label>
                                    <input v-model="name" name="name" type="text" placeholder="Insira o seu nome completo" class="Form-input form-control input-lg">
                                    <p v-if="errors.hasOwnProperty('name')" class="help-block alert-danger">Campo Obrigatório</p>
                                </div>

                                <!--CSRF TOKEN-->
                                <!--<input name="_token" type="hidden" value="{{ csrf_token() }}" />-->

                                <div class="form-group">
                                    <label>E-mail </label>
                                    <input v-model="email" name="email" type="text" placeholder="Insira o seu e-mail" class="Form-input form-control input-lg">
                                    <div v-if="errors.hasOwnProperty('email') ">
                                        <p v-if="!('Unique' in errors.email)" class="help-block alert-danger">Email inválido</p>
                                    </div>
                                </div>

                                <!-- <div class="form-group">
                                            <label for="cpf" >CPF </label>
                                            <input name="cpf" type="input" placeholder="CPF" class="Form-input form-control Mask-cpf">
                                            @if ($errors->has('cpf')) <p class="help-block alert-danger">{{ $errors->first('birthdate') }}</p> @endif
                                        </div> -->

                                <div class="form-group">
                                    <label>Senha</label>
                                    <input v-model="password" name="password" type="password" placeholder="Insira a sua senha" class="Form-input form-control input-lg">
                                    <div v-if="errors.hasOwnProperty('password')">
                                        <p v-if="errors.password.hasOwnProperty('Confirmed')" class="help-block alert-danger">As senhas não coincidem</p>
                                        <p v-else class="help-block alert-danger">A senha deve ter no mínimo 6 caracteres</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="sr-only">Confirmar a sua senha</label>
                                    <input v-model="passwordConfirmation" name="password_confirmation" type="password" placeholder="Confirme a sua senha" class="Form-input form-control input-lg">
                                </div>

                                <div class="form-group">
                                    <p>
                                        <input v-model="terms" type="checkbox" class="Form-checkbox">
                                        Estou de acordo com os
                                        <a href="/././termos" target="_blank">Termos de Uso e Privacidade</a></p>
                                </div>
                                <div class="text-center">
                                    <div v-on:click="alerta('Você deve concordar com os Termos de Uso e Privacidade')" v-if="!terms" class="Button Button--default Button--defaultDisabled">Cadastrar</div>
                                    <button v-else-if="!registering" class="Button Button--default Button--defaultGreen" type="submit" v-on:click="register">Cadastrar</button>
                                    <pulse-loader v-else color="#eb2341"></pulse-loader>
                                    <a href="/dashboard/redirect" class="Button Button--default Button--defaultFacebook Icon Icon--facebookBefore"
                                       title="Entrar com facebook">Entrar com facebook</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="Widget Widget-padding">
                        <div class="Widget-header text-center">
                            <h2 class="Widget-title Widget-title--min Widget-title--color15">Já possui cadastro?</h2>
                        </div>
                        <div class="Widget-content text-center">
                            <a href="./login" class="Button Button--default Button--defaultBlueFull">Acessar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
    import PulseLoader from 'vue-spinner/src/PulseLoader.vue'
    export default {
        props : [
            'promowindow',
            'orgId',
            'stageId',
            'userId',
            'token',
            'listId'
        ],

        components: {
            PulseLoader
        },
        data(){
            return{
                terms                   : false,
                name                    : "",
                email                   : "",
                password                : "",
                passwordConfirmation    : "",
                errors                  : {},
                exception_thrown        : false,
                registering             : false,
            }

        },

        mounted() {
        },


        methods:{
            register: function(){
                let scope = this
                scope.registering = true;
                let payload = {name:scope.name, email:scope.email, password:scope.password, password_confirmation:scope.passwordConfirmation, terms:scope.terms};
                scope.$http.post(window.api+'register', payload).then(response=>{
                    if("error" in response.body){
                    scope.errors = response.body.error;
                    scope.registering = false;
                    return
                }
                scope.$http.post('https://api.pipedrive.com/v1/persons?api_token=3c1159392a028e5be89443f2764edbd06aa512cf', {
                    name:scope.name,
                    email:scope.email,
                    org_id:scope.orgId
                }).then(response2=>{
                    let idAux = response2.body.data.id
                    scope.$http.post('https://api.pipedrive.com/v1/deals?api_token=3c1159392a028e5be89443f2764edbd06aa512cf',{
                    title:'Negócio '+scope.name,
                    user_id:2439738,
                    person_id: idAux,
                    stage_id: scope.stageId
                }).then(response3=> {
                    scope.$http.post(window.local+'dashboard/subscribe/', {name:scope.name, email:scope.email, listId:scope.listId})
                        .then(window.location.href = scope.promowindow
                        ).catch(window.location.href = scope.promowindow)
            })
            })
            }).catch(err => {
                    if("error" in err.body){
                    scope.errors = err.body.error;
                    scope.registering = false;
                    return
                }
                scope.exception_thrown = true;
                scope.registering = false;
            })
            },
            alerta(msg){
                alert(msg);
            }
        }

    }
</script>