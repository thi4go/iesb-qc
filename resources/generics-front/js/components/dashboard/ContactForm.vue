<template>
    <div>
        <custom-modal
                v-if        = "success"
                header      = "Obrigado pela a mensagem!"
                closeButton = true
                text        = "Entraremos em contato em até 72 horas"
                button-text = "Fechar"
                v-on:close  = "success = null"
        ></custom-modal>
        <div class="row">
            <div class="container Widget Widget-bgWhite Widget-padding u-m-b-20 u-m-t-40">
                <div v-if="success==false" class="alert alert-danger">Mensagem não pôde ser enviada</div>
                <h1>Deixe sua mensagem!</h1>
                <div class="form-group">
                    <label for="name">Nome</label>
                    <input v-model="name" id="name" name="name" class="form-control">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input v-model="email" id="email" name="email" class="form-control">
                </div>

                <div class="form-group">
                    <label for="subject">Assunto</label>
                    <input v-model="subject" id="subject" name="subject" class="form-control">
                </div>

                <div class="form-group">
                    <label for="message">Mensagem</label>
                    <textarea v-model="message" id="message" name="message" class="form-control"></textarea>
                </div>
                <pulse-loader v-if="loading" class="u-m-t-20 pull-left" color="#eb2341"></pulse-loader>
                <button v-else id="email_contact" @click="sendMail" value="Enviar" class="Button Button--default Button--defaultGreen u-m-t-20">Enviar</button>
            </div>
        </div>
    </div>
</template>
<script>
    import PulseLoader from 'vue-spinner/src/PulseLoader.vue'
    export default {

        data(){
            return {
                name:"",
                email:"",
                subject:"",
                message:"",
                loading:false,
                success:null
            }
        },
        components: {
            PulseLoader
        },

        mounted() {
        },

        methods:{
            sendMail(){

                let scope = this
                let data = {
                    email       : scope.email,
                    subject     : scope.subject,
                    message     : scope.message,
                    name        : scope.name
                };

                scope.loading = true

                this.$http.post(window.local + 'dashboard/contact-mail', data).then(response=>{
                    scope.loading = false
                    scope.success = true
                }).catch(error => {
                    scope.loading = false
                    scope.success = false
                })
            }
        }

    }
</script>