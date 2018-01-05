<!--
@Component:
    eu-quero-model
@Description:
    Component with Eu-quero campaing.
@CalledComponents:
    1 - count-down
    2 - depoiment-panel
    3 - contact-info
@ApiRoutes:
@WebRoutes:
@Props:
@TODO:
-->

<template>
    <div>
        <div class="container-fluid" style="background-image: url(/assets/images/bgSite.jpg);background-size: cover;background-position: 50%;background-repeat: no-repeat;">
            <div class="container" style="padding-top: 20px">
                <div class="row">
                    <div class="row">
                        <!-- Logo -->
                        <div class="col-sm-6 col-md-2" style="padding-bottom: 10px;">
                            <div class="Brand">
                                <a class="Brand-link" href="" title="Engenharia Civil">
                                    <!-- <img src="http://engcivil.maquinadeaprovacao.com/assets/images/logoWhiteBlue.png"  alt="Engenharia Civil"> -->
                                </a>
                            </div>
                        </div>
                        <!-- End Logo -->
                        <!-- Empty space - corresponde ao espaço vazio em desktops largos-->
                        <div class="col-md-7"></div>
                        <!-- End Empty space -->
                        <count-down
                                :weekDay    = "weekDay"
                                :hours      = "hours"
                                :minutes    = "minutes"
                                :seconds    = "seconds"
                                :endDay     = "endDay"
                        />
                    </div>
                    <div class="col-xs-7 col-sm-9 col-md-10" style="text-align: right;">
                    </div>
                    <!-- Text -->
                    <div class="row">
                        <header style="color: #016db9;" class="Post-title col-md-12 text-center">
                            <h2 class="Section-title">Seja <strong>Aprovado</strong> nos Concursos de <b>Engenharia Civil</b>!</h2>
                        </header>
                    </div>
                    <!-- End Text -->
                    <!-- Video --><div class="col-sm-1"></div>
                    <div class="Section-content col-sm-10" style="padding-bottom: 30px;">
                        <div class="embed-responsive embed-responsive-16by9 u-fixedVideoDesktop">
                            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/VtFAMB2DJ9Q?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allowfullscreen=""></iframe>
                        </div>
                    </div>
                    <div class="col-sm-1"></div>
                    <!-- End Video -->
                </div>
                <!-- Eu Quero! -->
                <div class="text-center">
                    <a href="/dashboard/register-promo" class="btn btn-lg Button-Euquero" style="text-align: center; margin-bottom: 30px;"
                       title="Iniciar">Eu Quero!</a>
                </div>
            </div>
        </div>
        <depoiment-panel></depoiment-panel>
        <div class="container-fluid">

            <contact-info :contact-email="contactEmail"></contact-info>
        </div>
    </div>
</template>

<script>
    export default {
        props : [
            'weekDay',
            'hours',
            'minutes',
            'seconds',
            'endDay',
            'contactEmail'
        ],

        data(){
            return {
                loading : true
            }
        },

        mounted() {
        },
    }
</script>
