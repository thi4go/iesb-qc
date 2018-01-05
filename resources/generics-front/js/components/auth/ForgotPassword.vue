<!--
@Component:
    forget-page
@Description:
    Page responsible for requesting the change of password. It checks if the input email is correct
    and in case it is, a email containing a url valid for one year is sent.
@CalledComponents:
@ApiRoutes:
    user/get-user-by-mail/{email}
@WebRoutes:
    dashboard/recover-password
@Props:
    userId      : id of user
    token       : user authentication token
@TODO:
    1 - Improve style
    2 - Pass userId and token by props
-->

<template xmlns:v-model="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <section class="Section Section--default">
        <div class="container">
            <div v-if="emailSent">
                <div v-if="success" class="alert alert-success">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                    Email de recuperação de senha enviado.
                </div>
                <div v-else class="alert alert-danger">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                    {{errorMessage}}
                </div>
            </div>

            <div class="Widget-content u-m-b-30">
                <div class="Form Formdefault">
                    <div class="form-group">
                        <label  class="sr-only">E-mail</label>
                        <input v-model="email" name="email" type="text" placeholder="Insira o seu e-mail" class="Form-input form-control input-lg">
                    </div>
                    <div v-if="!sendingMail" class="text-center">
                        <button class="Button Button--default Button--defaultGreen" v-on:click="sendMail">Recuperar Senha</button>
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
            'userId',
            'token'
        ],

        components: {
            PulseLoader
        },

        data(){
            return{
                email: "",
                sendingMail: false,
                success: false,
                emailSent: false,
                errorMessage: ""
            }

        },

        mounted() {
        },


        methods:{
            sendMail: function(){
                let scope = this
                scope.sendingMail = true

                if(this.email.length <= 0){
                    scope.sendingMail = false
                    scope.emailSent = true
                    scope.sendingMail   = false
                    scope.errorMessage = "Digite um email correto."
                    return
                }

                this.$http.get(window.api + 'user/get-user-by-mail/'+ this.email).then(response=>{

                    let data = {
                        userId        : response.body.data.id,
                        name          : response.body.data.name,
                        email         : scope.email
                    };


                    scope.$http.post(window.local + 'dashboard/recover-password', data).then(response=>{
                        scope.success = true
                        scope.emailSent = true
                        scope.sendingMail   = false

                    }).catch(error => {
                        scope.success = false
                        scope.emailSent = true
                        scope.errorMessage = "Erro de conexão. Tente mais tarde."
                        scope.sendingMail   = false

                    })





                }).catch(error => {
                    scope.success = false
                    scope.errorMessage = "Email não encontrado!"
                    scope.sendingMail   = false
                    scope.emailSent = true
                })
            }
        }

    }
</script>
