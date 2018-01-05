<!--
@Component:
    change-password
@Description:
    Page responsible for changing user password. It displays an error message if the url
    time expired, and allows to change password otherwise
@CalledComponents:
@ApiRoutes:
    user/update-pwd
@WebRoutes:
@Props:
    expired     : true if url is expired, false otherwise
    userName    : name of the user that will be displayed on the screem
    userId      : id of user
    token       : user authentication token
@TODO:
    1 - Improve style
    2 - Pass userId and token by props
-->

<template xmlns:v-model="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <section class="Section Section--default">
        <div class="container">
            <div v-if="updated" class="alert alert-success">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                    Senha alterada com sucesso!
            </div>
            <div v-if="expired">
                <div class="alert alert-danger">
                    Email de restauração expirado. Clique
                    <a href="/dashboard/forgot-password">aqui</a> para redefinir a senha.
                </div>
            </div>
            <div v-else class="Widget-content u-m-b-30">
                <div class="Form Formdefault">
                    <label>Olá, {{userName}}</label><br><br>
                    <div class="form-group">
                        <label >Senha</label>
                        <input v-model="password" type="password" placeholder="Insira a sua senha"
                               class="Form-input form-control input-lg">
                    </div>
                    <div class="form-group">
                        <label  class="sr-only">Confirmar a sua senha</label>
                        <input v-model="confirmPassword" type="password" placeholder="Confirme a sua senha"
                               class="Form-input form-control input-lg">
                        <p v-if="error" class="help-block alert-danger">{{errorMessage}}</p>
                    </div>
                    <div v-if="!loading" class="text-center">
                        <button class="Button Button--default Button--defaultGreen"
                                v-on:click="changePassword">Redefinir Senha</button>
                    </div>
                    <div v-else class="text-center">
                        <pulse-loader color="#eb2341"></pulse-loader>
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
            'expired',
            'userId',
            'token',
            'userName'
        ],

        components: {
            PulseLoader
        },

        data(){
            return{
                loading:            false,
                password:           "",
                confirmPassword:    "",
                error:              false,
                errorMessage:       "",
                updated:            false
            }

        },

        mounted() {
        },


        methods:{
            changePassword: function () {
                this.loading = true

                if(this.password.length < 6){ // check pass length
                    this.error = true
                    this.errorMessage = "Digite uma senha com mínimo de 6 caracteres"
                    this.loading = false
                }else{
                    if(this.confirmPassword == this.password){
                        let scope = this
                        let data = {
                            userId        : this.userId,
                            password      : this.password
                        };


                        scope.$http.post(window.api + 'user/update-pwd', data).then(response=>{
                            if(response.body.message == null ||
                                response.body.message == 'Atualização da senha falhou !'){
                                scope.error = true
                                scope.errorMessage = "Erro ao mudar senha. Tente mais tarde"
                            }else{
                                scope.loading  = false
                                scope.updated  = true
                                scope.error    = false
                            }
                        })

                    }else{
                        this.error = true
                        this.errorMessage = "Confirmação de senha não confere."
                        this.confirmPassword = ""
                        this.password = ""
                        this.loading = false

                    }
                }
            }
        }

    }
</script>
