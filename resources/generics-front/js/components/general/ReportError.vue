<!--
@Component:
    report-error
@Description:
    Report error button and modal. It gets user error description and sends to
    EduQC mail
@CalledComponents:
    vue-spinner
@ApiRoutes:
@WebRoutes:
    dashboard/reportar
@Props:
    userId  : user id
    token   : user authentication token
@TODO:
    1 - Use token
-->

<template xmlns:v-model="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div>
        <button @click="cleanModal" class="Button Button--report Icon Icon--warningAfter pull-right" title="Reportar um erro"
           data-toggle="modal" data-target="#report">Reportar um erro</button>
        <div class="Modal modal fade" id="report" tabindex="-1" role="dialog" aria-labelledby="reportLabel">
            <div class="modal-dialog" role="document">
                <div class="Modal-content modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="reportLabel">Reportar um erro</h4>
                    </div>
                    <div class="modal-body">
                        <div v-if="messageSent">
                            <div v-if="success" class="Form Form--default" style="text-align: center">
                                <span class="Form-label">
                                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                                    Mensagem enviada com sucesso
                                </span>
                            </div>
                            <div v-else class="Form Form--default" style="text-align: center">
                                <span class="Form-label">
                                    <i class="fa fa-times-circle-o" aria-hidden="true"></i>
                                    Erro ao enviar mensagem.
                                </span>
                            </div>
                        </div>
                        <div v-else>
                            <div v-if="!loading">
                                <div class="Form Form--default" id="conversion-form">
                                    <div class="form-group">
                                        <label for="message" class="Form-label">
                                            Encontrou algum erro? Relate-nos abaixo:</label>
                                        <textarea name="message" id="message" rows="4"
                                                  class="Form-textarea form-control"
                                                  v-model="message"></textarea>
                                    </div>
                                    <a href="#"
                                       v-on:click="sendMail"
                                       class="Button Button--default Button--defaultBlueFull">
                                        Enviar</a>
                                </div>
                            </div>
                            <div v-else>
                                <div class="Form Form--default" style="text-align: center">
                                    <span class="Form-label">Enviando email</span>
                                    <pulse-loader color="#eb2341"></pulse-loader>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import PulseLoader from 'vue-spinner/src/PulseLoader.vue'

    export default {
        props : [
            'userId',
            'token',
            'pageUrl',
            'questionId',
            'title'
        ],
        components: {
            PulseLoader
        },
        data(){
            return {
                message: "",
                loading: false,
                messageSent: false,
                success: false
            }
        },
        mounted() {
        },
        methods:{
            cleanModal(){
                this.message = ""
                this.loading = false
                this.messageSent = false
                this.success = false
            },
            sendMail: function(event){
                event.preventDefault


                let scope = this
                let data = {
                    userId      : scope.userId,
                    subject     : "Erro reportado" + scope.title,
                    message     : scope.message,
                    pageUrl     : scope.pageUrl,
                    questionId  : scope.questionId
                };

                scope.loading = true

                this.$http.post(window.api + 'questions/save-error-report', data);

                this.$http.post(window.local + 'dashboard/reportar', data).then(response=>{
                    scope.loading = false
                    scope.success = true
                    scope.messageSent = true
                    scope.$emit('question-reported')
                }).catch(error => {
                    scope.loading = false
                    scope.messageSent = true
                    scope.success = false
                })
            }
        }

    }
</script>
