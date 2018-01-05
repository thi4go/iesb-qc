<!--
@Component:
    quiz-landing
@Description:
    Page that shows available quizzes and its percentil.
@CalledComponents:
@ApiRoutes:
    question/get-best-question/
    question/get-future-best-question
    user/answerQuizQuestion
@WebRoutes:
@Props:
    subjects        :   JSON list of subjects that have available
@Constants:
@TODO:
    1 - Improve style
-->


<template xmlns:v-model="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <section style="padding-top: 10px">
        <section class="container">
            <!--<app-download/>-->
            <div v-for="n in 2">
                <div class="col-sm-12 col-md-6" style="position: relative;">
                    <div v-for="(subject, i) in subjectsCourses">
                        <div v-if="i % 2 == n - 1" class="Card Card--simulate Card--simulatePainel "
                             style="margin-bottom: 30px">
                            <div class="Card-header u-m-b-10">
                                <h2 class="Card-title Card-title--color40 u-bold">{{subject.text}}</h2>
                                <div class="Card-content">
                                    <div class="Progress u-m-b-10">
                                        <p class="Progress-legend">Percentil</p>
                                        <div class="Progress-bar Progress-bar--color13 u-m-b-5">
                                            <div class="Progress-loading Progress-loading--color30"
                                                 role="progressbar"
                                                 v-bind:aria-valuenow="subject.percentil * 100"
                                                 v-bind:style="'width:'+subject.percentil * 100 +'%'"
                                                 aria-valuemin="0" aria-valuemax="100"
                                            ></div>
                                        </div>
                                        <p class="Progress-count">
                                            {{parseFloat(subject.percentil * 100).toFixed(2)}}%</p>
                                    </div>
                                    <a v-bind:href="'/dashboard/simulado/' + subject.idsubject"
                                       class="Button Button--min Button--default Button--defaultGreen
                                        btn-block u-m-b-10 text-center"
                                       title="Resolver">Resolver</a>
                                    <a v-bind:href="'/dashboard/simulado/resultado/' + subject.idsubject"
                                       class="Button Button--min Button--default Button--defaultBlueFull
                                       btn-block text-center"
                                       title="Resultado">Resultado</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
</template>


<script>
    export default{
        props : [
            'subjects'
        ],

        data(){
            return {
                loading:true,
                subjectsCourses: []
            }
        },

        mounted() {
            for(let subject of JSON.parse(this.subjects)){
                this.subjectsCourses.push(subject)
            }
        },
    }
</script>