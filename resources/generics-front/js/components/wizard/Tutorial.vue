<!--
@Component:
    tutorial
@Description:
    Tutorial wizard in which it is shown how to use the website.
@CalledComponents:
@ApiRoutes:
    user/update-wizard/{userId}?token={token}
@WebRoutes:
@Props:
    userId  : user id
    token   : user authentication token
    wizard  : flag saying if wizard was done or not.
@Constants:
@TODO:
    1 - Make buttons responsive
    2 - Pass style to separated file
-->

<style>
    .wizard {
        margin: 20px auto;
        background: #fff;
    }

    .wizard .nav-tabs {
        position: relative;
        margin: 40px auto;
        margin-bottom: 0;
        border-bottom-color: #e0e0e0;
    }

    .wizard > div.wizard-inner {
        position: relative;
    }

    .connecting-line {
        height: 2px;
        background: #e0e0e0;
        position: absolute;
        width: 80%;
        margin: 0 auto;
        left: 0;
        right: 0;
        top: 50%;
        z-index: 1;
    }

    .wizard .nav-tabs > li.active > a, .wizard .nav-tabs > li.active > a:hover, .wizard .nav-tabs > li.active > a:focus {
        /*color: #555555;*/
        cursor: default;
        border: 0;
        border-bottom-color: transparent;
    }

    span.round-tab {
        width: 70px;
        height: 70px;
        line-height: 70px;
        display: inline-block;
        border-radius: 100px;
        background: #fff;
        border: 2px solid #e0e0e0;
        z-index: 2;
        position: absolute;
        left: 0;
        text-align: center;
        font-size: 25px;
    }
    span.round-tab i{
        /*color:#555555;*/
    }
    .wizard li.active span.round-tab {
        background: #fff;
        border: 2px solid #5bc0de;

    }
    .wizard li.active span.round-tab i{
        color: #5bc0de;
    }

    span.round-tab:hover {
        color: #333;
        border: 2px solid #333;
    }

    .wizard .nav-tabs > li {
        width: 25%;
    }

    .wizard li:after {
        content: " ";
        position: absolute;
        left: 46%;
        opacity: 0;
        margin: 0 auto;
        bottom: 0px;
        border: 5px solid transparent;
        border-bottom-color: #5bc0de;
        transition: 0.1s ease-in-out;
    }

    .wizard li.active:after {
        content: " ";
        position: absolute;
        left: 46%;
        opacity: 1;
        margin: 0 auto;
        bottom: 0px;
        border: 10px solid transparent;
        border-bottom-color: #5bc0de;
    }

    .wizard .nav-tabs > li a {
        width: 70px;
        height: 70px;
        margin: 20px auto;
        border-radius: 100%;
        padding: 0;
    }

    .wizard .nav-tabs > li a:hover {
        background: transparent;
    }

    .wizard .tab-pane {
        position: relative;
        padding-top: 50px;
    }

    .wizard h3 {
        margin-top: 0;
    }

    @media( max-width : 585px ) {

        .wizard {
            width: 90%;
            height: auto !important;
        }

        span.round-tab {
            font-size: 16px;
            width: 50px;
            height: 50px;
            line-height: 50px;
        }

        .wizard .nav-tabs > li a {
            width: 50px;
            height: 50px;
            line-height: 50px;
        }

        .wizard li.active:after {
            content: " ";
            position: absolute;
            left: 35%;
        }
    }

    .tutorial_text{
        text-align: justify;
        text-justify: inter-word;

    }
    .fa-check{
        color: #a6c338;
    }
</style>


<template xmlns:v-model="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">



    <div class="container">
        <div class="row">
            <section>
                <div v-if="changePwd" class="Widget-bgWhite Widget-padding col-sm-10 col-sm-offset-2 text-center">
                    <update-password :userId="userId"></update-password>
                </div>
                <div v-else class="wizard">
                    <div class="wizard-inner">
                        <div class="connecting-line"></div>
                        <ul class="nav nav-tabs" role="tablist">

                            <li  role="presentation" class="active">

                                <a v-on:click="currentstep=1" href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Step 1">
                                    <span class="round-tab">
                                        <i v-if="currentstep==1" class="Icon Icon--profileBefore"></i>
                                        <i v-else class="fa fa-check"></i>
                                    </span>
                                </a>
                            </li>

                            <li  role="presentation" class="disabled">
                                <a v-on:click="currentstep=2" href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Step 2">
                                    <span class="round-tab">
                                        <i v-if="currentstep<=2" class="Icon Icon--editBefore"></i>
                                        <i v-else class="fa fa-check"></i>
                                    </span>
                                </a>
                            </li>


                            <li  role="presentation" class="disabled">
                                <a v-on:click="currentstep=3" href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Step3">
                                    <span class="round-tab">
                                        <i v-if="currentstep<=3" class="Icon Icon--padnoteBefore"></i>
                                        <i v-else class="fa fa-check"></i>
                                    </span>
                                </a>
                            </li>

                            <li  role="presentation" class="disabled">
                                <a v-on:click="currentstep=4" href="#step4" data-toggle="tab" aria-controls="step4" role="tab" title="Complete">
                                    <span class="round-tab">
                                        <i v-if="currentstep<=4" class="fa fa-thumbs-o-up" aria-hidden="true"></i>
                                        <i v-else class="fa fa-check"></i>
                                    </span>
                                </a>
                            </li>

                        </ul>
                    </div>

                    <form role="form">
                        <div class="tab-content">
                            <div class="tab-pane active" role="tabpanel" id="step1">


                                <div class="Widget-bgWhite Widget-padding">
                                    <div class="Widget-header">

                                        <h3>Primeiro passo</h3>

                                        <p class="tutorial_text">
                                            Realize 1 Simulado de cada disciplina.
                                            Faça todos os Simulados, mesmo que não tenha estudado, os resultados não são
                                            importantes. Nesse momento o importante é que você tenha uma avaliação inicial
                                            para você saber por onde começar e ter um comparativo para os próximos meses.
                                            Idealmente, você deve refazê-los todo mês para que você veja sua progressão.
                                        </p>


                                        <div class="row">
                                            <div class="col-sm-12 col-md-12" >
                                                <div class="pull-right" style="padding-top: 10px">
                                                    <button v-on:click="nextStep" type="button" class="Button Button--default Button--defaultGreen">
                                                        Próximo passo
                                                    </button>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>


                            </div>
                            <div class="tab-pane" role="tabpanel" id="step2">
                                <div class="Widget-bgWhite Widget-padding">
                                    <div class="Widget-header">

                                        <h3>Segundo passo</h3>
                                        <p class="tutorial_text">
                                            Planeje seus estudos com nosso Controle Personalizado.
                                            Ele será montado com base na sua proficiência nos Simulados e na sua disponibilidade diária para estudar.
                                            Sabemos que seu tempo é curto, por isso, seu estudo precisa ser eficiente e eficaz.
                                        </p>


                                        <div class="row">
                                            <div class="col-sm-12 col-md-12" >
                                                <div class="pull-right" style="padding-top: 10px">
                                                    <button v-on:click="prevStep" type="button" class="Button Button--default Button--defaultGreen"
                                                            style="padding-right: 10px">
                                                        Passo Anterior
                                                    </button>
                                                    <button v-on:click="nextStep" type="button" class="Button Button--default Button--defaultGreen">
                                                        Próximo passo
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" role="tabpanel" id="step3">
                                <div class="Widget-bgWhite Widget-padding">
                                    <div class="Widget-header">
                                        <h3>Terceiro Passo</h3>
                                        <p class="tutorial_text">
                                            Siga o planejamento do seu Ciclo de Estudos criado no Controle.
                                            Primeiro, estude teoria, depois, faça as questões.
                                            Em Painel, você acompanha o cumprimento de suas metas de estudo e sua evolução das suas chances de aprovação.
                                        </p>

                                        <div class="row">
                                            <div class="col-sm-12 col-md-12" >
                                                <div class="pull-right" style="padding-top: 10px">
                                                    <button v-on:click="prevStep" type="button" class="Button Button--default Button--defaultGreen">
                                                        Passo anterior
                                                    </button>
                                                    <button v-on:click="nextStep" type="button" class="Button Button--default Button--defaultGreen">
                                                        Próximo passo
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane" role="tabpanel" id="step4">
                                <div class="Widget-bgWhite Widget-padding">
                                    <div class="Widget-header">
                                        <h3>Fim</h3>
                                        <p class="tutorial_text">
                                            Parabéns! Você terminou o tutorial. Porém, antes de usar a plataforma, você precisará trocar sua senha.
                                            Qualquer dúvida envie um e-mail para iesb@examedaoab.com
                                        </p>

                                        <div class="row">
                                            <div class="col-sm-12 col-md-12" >
                                                <div class="pull-right" style="padding-top: 10px">
                                                    <button v-on:click="prevStep" type="button" class="Button Button--default Button--defaultGreen">
                                                        Passo Anterior
                                                    </button>
                                                    <button v-on:click="nextStep" type="button" class="Button Button--default Button--defaultBlue">
                                                        Trocar Senha
                                                    </button>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>

</template>

<script>


    export default {
        props : [
            'userId',
            'token',
            'wizard'
        ],

        data(){
            return {
                currentstep: 1,
                changePwd:false,

                steps: [
                    {
                        id: 1,
                        title: 'Position',
                        icon_class: "fa fa-map-marker"
                    }, {
                        id: 2,
                        title: 'Category',
                        icon_class: "fa fa-folder-open"
                    }, {
                        id: 3,
                        title: 'Send',
                        icon_class: "fa fa-paper-plane"
                    }
                ]
            }
        },


        mounted() {

        },

        methods: {

            stepChanged() {
                this.currentstep += 1;
            },

            nextTab(elem) {
                $(elem).next().find('a[data-toggle="tab"]').click();
            },

            nextStep(){
                this.currentstep += 1;
                if(this.currentstep < 5) {
                    let $active = $('.wizard .nav-tabs li.active');
                    $active.next().removeClass('disabled');
                    this.nextTab($active);
                }else{
                    this.changeWizard()
                }
            },

            prevTab(elem) {
                $(elem).prev().find('a[data-toggle="tab"]').click();
            },

            prevStep(){
                this.currentstep -= 1;
                let $active = $('.wizard .nav-tabs li.active');
                this.prevTab($active)
            },

            changeWizard(){
                if(this.wizard == 0){
                    this.$http.get(window.api + "user/update-wizard/" + this.userId + "?token=" + this.token).then(()=>{
                        this.changePwd = true;
                    })
                }
            }


        }

    }


</script>
