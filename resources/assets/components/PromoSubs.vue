<!--
@Component:
    promo-subscription
@Description:
    Page for payment options.
@CalledComponents:
    1 - contact-info
@ApiRoutes:
@WebRoutes:
    /inscricao/pagar
@Props:
@TODO:
-->

<style>
    .contact{
        font: 400 15px Lato, sans-serif;
        line-height: 1.8;
        color: #93b82e;
        padding-bottom: 40px;
    }
</style>

<template xmlns:v-model="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <section class="Dashboard Dashboard-content Sales-sectionPayment u-m-t-40">
        <div class="container u-m-t-30" style="padding-top: 30px">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 hidden-sm " align="center"></div>
                    <div class="col-md-6 col-sm-12 " align="center">
                        <div class="Card Card--payment Card--paymentPainel Card--paymentPainelBorderBlue  u-m-b-30 u-m-t-30">
                            <div class="Card--header text-center">
                                <h2 class="Card-title Card-title--blueFull u-bold">OAB Premium</h2>
                            </div>
                            <div class="Card-content Card-text Card-text--blue  u-m-b-10">
                                <h3 class="text-center"><strike><h4>R$ 80</h4></strike> <b>R$ 40</b> pelo acesso</h3>
                                <div style="padding: 5px">
                                    <strong> Para você </strong> multiplicar as suas chances de <strong>aprovação</strong>,
                                    com o mais qualificado conteúdo,
                                    e um inteligente algoritmo de plano de estudos que se adapta às suas particularidades e
                                    diversas outras vantagens, como:
                                </div>
                                <div class="panel-group col-md-12" id="accordion">
                                    <!-- Listi advantages -->
                                    <div v-for="(advantage, i) in advantages" class="panel">
                                        <div class="panel-heading">
                                            <div class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion"
                                                   v-bind:href="'#collapse' + i">
                                                    <i v-bind:class="advantage.icon"></i>

                                                    {{advantage.title}}
                                                </a>
                                            </div>
                                        </div>
                                        <div v-bind:id="'collapse' + i" class=" col-md-12 panel-collapse collapse">
                                            <div class="panel-body" style="border-color: transparent;">
                                                {{advantage.description}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div style="padding: 5px; text-align: center">
                                     Assine o plano  e desfrute nossas vantagens!
                                </div>
                            </div>
                            <button class="Button Button--default Button--defaultGreenBlue btn-block premAcquired"
                                    data-toggle="modal" v-on:click="sendPipe" data-target="#modalRegister">Pagar via deposito</button>
                            <form method="POST" action="/inscricao/pagar" class="u-m-t-20" v-on:click="sendPipe">
                                <input type="hidden" name="_token" :value="token"/>

                                <div id="pagarme_button"></div>
                            </form>
                            <!-- Modal -->
                            <div class="modal fade" id="modalRegister" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close"  data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Como pagar via depósito</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                1 - Deposite na conta:<br>
                                                Banco do brasil<br>
                                                Agência: 3129.1<br>
                                                Conta corrente: 26.909-3<br>
                                                <br>
                                                2 - mande a foto do comprovante para o email: <br>
                                                oab@qualconcurso.com.br<br>
                                                <br>
                                                3 - Sua conta será ativada pela nossa equipe
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Eu Quero! -->
                        </div>
                    </div>
                    <div class="col-md-3 hidden-sm " align="center"></div>
                </div>
            </div>
        </div>
    </section>
</template>


<script>

    export default {
        props : [
            'avatar',
            'name',
            'token'
        ],

        data(){
            return {
                user:false,
                localAvatar: "",
                dropMenu: false,
                advantages: [
                    {   icon:"fa fa-area-chart",
                        title: "Controle de estudo personalizado de acordo com proficiência e objetivo",
                        description: "A plataforma reconhece seus objetivos e suas habilidades, e, com isso, gerencia "+
                        +"o seu tempo de estudo de cada" +
                        "disciplina, buscando a melhoria de sua capacidade, a fim de atingir seu objetivo!"},
                    {   icon:"fa fa-pencil-square-o",
                        title: " Simulados e Questões",
                        description: "Tenha a sua disposição um vasto leque de questões dos assuntos cobrados! Além " +
                        "disso, realize simulados para avaliar o seu desempenho e compare os seus resultados com os " +
                        "outros simulados que você realiza!"},
                    {   icon:"fa fa-hourglass",
                        title: " Melhor aproveitamento do tempo de estudo",
                        description: "Um melhor aproveitamento do tempo implica em um melhor aprendizado por horas " +
                        "estudadas. Melhore o rendimento do seu estudo com a nossa plataforma, e aprenda mais " +
                        "em menos tempo!"},
                    {   icon:"fa fa-thumbs-up",
                        title: " Plataforma intuitiva",
                        description: "Mexer na nossa plataforma é mais fácil que tirar doce de criança! Toda a " +
                        "navegação pela plataforma é muito fácil e intuitiva! Organizar seus estudos nunca foi tão " +
                        "fácil!"},
                    {   icon:"fa fa-book",
                        title: " Material Completo para estudo",
                        description: "Contamos com um material completo para seu estudo! Além de simulados e" +
                        " questões, disponibilizamos artigos para te orientar nos estudos!"},

                ]
            }
        },



        methods:{
            sendPipe(value){
                var urlPD_checkmail = "https://api.pipedrive.com/v1/persons/find?term=" + this.name +
                    "&start=0&api_token=3c1159392a028e5be89443f2764edbd06aa512cf";
                var urlPD_deals = "https://api.pipedrive.com/v1/deals?api_token=3c1159392a028e5be89443f2764edbd06aa512cf";
                var urlPD_findDeal = "https://api.pipedrive.com/v1/deals/find?term=" + this.name +
                    "&api_token=3c1159392a028e5be89443f2764edbd06aa512cf";
                urlPD_findDeal = urlPD_findDeal.replace(/ /g, "%20");
                urlPD_checkmail = urlPD_checkmail.replace(/ /g, "%20");
//                console.log(urlPD_findDeal);
                let scope = this;
                //checks if person exists and gets person's id on pipedrive
                this.$http.get(urlPD_checkmail,null,{
                    emulateJSON:true
                }).then(response=>{
                    scope.id_person = response.body.data[0].id;

                    this.$http.get(urlPD_findDeal,null,{
                        emulateJSON:true
                    }).then(response=>{
                        if(response.body.data != null){
                            var id_deal = response.body.data[0].id;
//                            console.log(id_deal);
                            scope.flag = true;
                        }else{
                            scope.flag = false;
                        }
                        let dataPD_deals = {
                            "title": "Negócio " + scope.name,
                            "value": value,
                            "currency": "BRL",
                            "user_id": "2439738",
                            "person_id": scope.id_person,
                            "stage_id": "4"
                        };
                        this.$http.post(urlPD_deals,dataPD_deals,{
                            emulateJSON:true
                        }).then(response=>{
                            if(scope.flag){
                                let delete_url = 'https://api.pipedrive.com/v1/deals/'+id_deal+'?api_token=3c1159392a028e5be89443f2764edbd06aa512cf';
                                this.$http.delete(delete_url,null,{
                                    emulateJSON:true
                                }).then(response=>{
//                            console.log(response);
                                });
                            }
                        });

                    });

                });
            }
        },

        mounted() {
            let scriptPay = document.createElement('script')
            scriptPay.setAttribute('type', 'text/javascript')
            scriptPay.setAttribute('src', 'https://assets.pagar.me/checkout/checkout.js')
            scriptPay.setAttribute('v-on:click','sendPipe')
            scriptPay.setAttribute('data-ui-color', '#016db9 ')
            scriptPay.setAttribute('data-ui-color', '#016db9 ')
            scriptPay.setAttribute('data-button-text', 'Pagar com cartão ou boleto')
            scriptPay.setAttribute('data-customer-data', 'false')
            scriptPay.setAttribute('data-payment-method', 'credit_card, boleto')
            scriptPay.setAttribute('data-button-class', 'Button Button--default Button--defaultBlue btn-block premAcquired')
            scriptPay.setAttribute('data-encryption-key', 'ek_live_bZbOuA02bDbSAm55ynCyj5kiwwBRFq')
            scriptPay.setAttribute('data-postback-url', 'https://iesbapi.examedaoab.com/api/transaction/postback-status')
            scriptPay.setAttribute('data-amount', '4000')
            scriptPay.setAttribute('data-max-installments', '4')
            scriptPay.setAttribute('data-header-text', '{price_info}')
            let a = document.getElementById("pagarme_button").appendChild(scriptPay)

        }

    }


</script>
