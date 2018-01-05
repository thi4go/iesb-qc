<!--
@Component:
    quiz-panel
@Description:
    Panel that shows a list of subjects associated to the quizzes related to them
@CalledComponents:
    1 - vue-carousel
@Props:
    subjectsQuiz: JSON array containing subjects that have quiz
    userId      : id of user
    token       : user authentication token
@TODO:
    1 - Pass userId and token by props
    2 - Add subject relevance progress bar
    3 - Pass card style by props
-->

<template xmlns:v-model="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <section class="Dashboard Dashboard--section u-m-b-40">
        <div class="container">
            <div id="simulado" class="row">
                <header class="Dashboard-header col-sm-12 u-m-b-20">
                    <h2 class="Dashboard-title Dashboard-title--color30">Resolva simulados para...</h2>
                    <div class="alertQuiz"></div>
                </header>
                <div class="Dashboard-content col-sm-12">
                    <carousel
                            :navigationEnabled="true"
                            :perPage="nOfSlides"
                            :autoplay="true"
                            :autoplayTimeout="2000"
                            :paginationEnabled="false"
                            paginationActiveColor="#ffffff"
                            navigationNextLabel='<div class="swiper-button-next Icon Icon--arrowRightBefore"></div>'
                            navigationPrevLabel='<div class="swiper-button-prev Icon Icon--arrowLeftBefore"></div>'>
                        <slide class="container" v-for="subject in subjectsCourses">
                            <div class="Card Card--simulate Card--simulatePainel">
                                <div class="Card-header u-m-b-10">
                                    <h2 class="Card-title Card-title--color40 u-bold">
                                        {{subject.text}}
                                    </h2>
                                </div>
                                <div class="Card-content">
                                    <div class="Progress u-m-b-10">
                                        <p class="Progress-legend">Percentil</p>
                                        <div class="Progress-bar Progress-bar--color13 u-m-b-5">
                                            <div class="Progress-loading Progress-loading--color30"
                                                 role="progressbar"
                                                 v-bind:aria-valuenow="subject.percentil * 100"
                                                 v-bind:style="'width:'+ subject.percentil * 100 +'%'"
                                                 aria-valuemin="0" aria-valuemax="100"
                                            ></div>
                                        </div>
                                        <p class="Progress-count">
                                            {{parseFloat(subject.percentil * 100).toFixed(2)}}%</p>
                                    </div>

                                    <div class="btn-group btn-group-justified">
                                        <a v-bind:href="'/dashboard/simulado/' + subject.idsubject"
                                           class="Button Button--tiny Button--default Button--defaultGreen text-center btn btn-primary "
                                           title="Resolver">Resolver</a>
                                    </div>
                                </div>
                            </div>
                        </slide>
                    </carousel>
                </div>
            </div>
        </div>
    </section>
</template>


<script>
    import { Carousel, Slide } from 'vue-carousel';


    export default {
        props : [
            'subjectsQuiz',
            'userId',
            'token'
        ],

        data(){
            return {
                loading: true,
                subjectsCourses: [],
                nOfSlides: 3
            }
        },

        // bind event handlers to the `handleResize` method (defined below)
        beforeDestroy: function () {
            window.removeEventListener('resize', this.handleResize)
        },

        components: {
            Carousel,
            Slide
        },


        mounted() {
            this.handleResize();

            for(let subject of JSON.parse(this.subjectsQuiz)){
                this.subjectsCourses.push(subject)

            }



            // listen to the resize of the screen
            // in order to update number of slides shown
            window.addEventListener('resize', this.handleResize)
        },

        methods: {
            // whenever the document is resized, re-set the 'fullHeight' variable
            handleResize (event) {
                let width = document.documentElement.clientWidth;
                if(width > 950){
                    this.nOfSlides = 3;
                }else if(width > 650){
                    this.nOfSlides = 2;
                }else{
                    this.nOfSlides = 1;
                }
            }
        }

    }


</script>
