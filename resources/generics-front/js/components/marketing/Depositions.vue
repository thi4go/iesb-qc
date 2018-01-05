<!--
@Component:
    depoiment-panel
@Description:
    Component with EduQC depositions.
@CalledComponents:
@ApiRoutes:
@WebRoutes:
@Props:
@TODO:
-->

<template>
    <div class="container-fluid">
        <div class="row">
            <header style="color: #016db9;" class="Post-title col-md-12 text-center">
                <h2 class="Section-title">O que as pessoas acham do EduQC?</h2>
            </header>
        </div>
        <div id="myCarousel" class="carousel slide text-center" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
            </ol>
            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                <div v-for="(comment, i) in comments"
                     v-bind:class="'item ' + (i == 0 ? 'active' : '')" >
                    <a v-bind:href="'#' + comment.link">
                    <span>
                        <img v-bind:src="comment.photo"
                             style="width:149px;height:90px;"
                             v-bind:alt="comment.author"></span>
                        <h4>
                            <i>{{comment.text}}</i><br>
                            <span><b>{{comment.author}}</b></span>

                        </h4>
                    </a>
                </div>
            </div>
            <!--Videos-->
            <div v-for="comment in comments">
                <div v-bind:id="comment.link" class="col-md-4">
                    <div class="Section-content col-sm-12" style="padding-bottom: 30px;">
                        <div class="embed-responsive embed-responsive-16by9 u-fixedVideoDesktop">
                            <iframe class="embed-responsive-item"
                                    v-bind:src="comment.video"
                                    frameborder="0" allowfullscreen=""></iframe>
                        </div>
                    </div>
                    <p>Depoimento do {{comment.author}}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props : [

        ],

        data(){
            return {
                comments:[
                    {
                        photo:  "http://engcivil.maquinadeaprovacao.com/assets/images/william-douglas-slide.png",
                        author: "William Douglas, Guru dos Concursos e Juiz Federal",
                        text:   '"Você que é aluno do EduQC merece o meu aplauso!"',
                        link:   "william-douglas",
                        video:  "https://www.youtube.com/embed/yB9PvpVsDAU?list=PLLHQFy5G5-8DSJuO-fUrOQTR6z5RrRzwS?rel=0&amp;controls=0&amp;showinfo=0"
                    },
                    {
                        photo:  "http://engcivil.maquinadeaprovacao.com/assets/images/lucas-ribeiro.png",
                        author: "Lucas Ribeiro, Aprovado no TCU",
                        text:   '"A plataforma me ajudou muito a me manter motivado pelos estudos!"',
                        link:   "lucas-ribeiro",
                        video:  "https://www.youtube.com/embed/NNi6pJxFtkc?list=PLLHQFy5G5-8DSJuO-fUrOQTR6z5RrRzwS?rel=0&amp;controls=0&amp;showinfo=0"
                    },
                    {
                        photo:  "http://engcivil.maquinadeaprovacao.com/assets/images/luiz-laydner.png",
                        author: "Luiz Laydner, 1º Lugar no Banco Central",
                        text:   '""É a melhor ferramenta para quem quer ser aprovado!"',
                        link:   "luiz-laydner",
                        video:  "https://www.youtube.com/embed/NJITKqexJPw?list=PLLHQFy5G5-8DSJuO-fUrOQTR6z5RrRzwS?rel=0&amp;controls=0&amp;showinfo=0"
                    }
                ]
            }
        },

        mounted() {
        },

    }
</script>
