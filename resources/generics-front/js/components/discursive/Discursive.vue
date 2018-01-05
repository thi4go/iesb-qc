<!--
@Component:
    discursive
@Description:
    Page that manages discursives questions pagination, resolution and feedback.
@CalledComponents:
    1 - discursive-question-shower
    2 - question-counter-pagination
    3 - timer
    4 - discursive-feedback
@ApiRoutes:
    discursives/answer-questions
@WebRoutes:
@Props:
    questions   : JSON with a list of discursive questions
    userId      : id of user
    token       : user authentication token
@TODO:
    1 - Save discursives only when question is answered
-->

<template xmlns:v-model="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div>
        <div v-if="loading">
            carregando...
        </div>
        <div v-else-if="feedback">
            <discursive-feedback
                    :questions  = "questionAux"
                    :userId     = "userId"
                    :examName   = "examName"
                    :title      = "title">
            </discursive-feedback>

        </div>
        <div v-else>
            <section class="Dashboard Dashboard--section u-m-t-40">
                <div class="container">
                    <div class="row">
                        <header class="Dashboard-header col-sm-12 u-m-b-20">
                            <h2 class="Dashboard-title Dashboard-title--color30">Discursivas</h2>
                        </header>
                        <div class="Dashboard-content col-sm-12">
                            <div class="row">
                                <div class="col-sm-7 col-md-8 u-m-b-40" id="fadeOut">
                                    <div class="Widget u-noPadding">


                                        <div class="Widget-bgWhite Widget--border Widget-padding">
                                            <discursive-question-shower
                                                    :question="questionAux[questionCounter]"
                                                    :userId = "userId"
                                                    :examName = "examName"
                                                    :title      ="title"
                                            ></discursive-question-shower>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-5 col-md-4 u-m-b-40">
                                    <question-counter-pagination
                                            :question-counter = "questionCounter"
                                            :max-value        = "QUESTIONS_NUMBER"
                                            :with-buttons     = "true"
                                            :offset           = "1"
                                            v-on:child-count-update="changeQuestion"
                                            :settable          = "true"
                                    >
                                    </question-counter-pagination>

                                    <div class="Widget u-noPadding">
                                        <timer
                                                v-bind:feedBackTime= "!showQuestions"
                                                :automatedReset="true"
                                                v-on:child-msg="getFinalTime"></timer>
                                        <div class="Widget-bgDarkBlue Widget--border Widget-padding text-center u-m-t-10">
                                            <a href="/dashboard/discursivas" class="Button Button--default Button--defaultWhiteBlue btn-block u-m-b-10" title="Voltar para o filtro">Voltar para o filtro</a>
                                            <a id = "solve" v-on:click="getFeedback" class="Button Button--default Button--defaultGreenWhite btn-block" title="Resolver">Finalizar</a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
            'questions',
            'examName',
            'title'
        ],

        data(){
            return {
                question            :  [],
                questionsId         : [],
                alternatives        : [],
                loading             : true,
                feedback            : false,
                answer              : null,
                answering           : false,
                questionCounter     : 0,
                futureRightQuestion : [],
                futureWrongQuestion : [],
                showQuestions       : true,
                quizTime            : null,
                QUESTIONS_NUMBER    : 0,
                buttonType          : 2,
                questionAux:[]
            }
        },

        mounted() {
            this.questionAux = JSON.parse(this.questions)
            // get best question
            this.QUESTIONS_NUMBER = this.questionAux.length

            this.loading = false
        },

        methods:{
            getFinalTime: function (time) {
                this.quizTime = time;
            },


            changeQuestion: function(counter){
                let scope = this
                let currentCounter = this.questionCounter
                this.showQuestions = false
                this.questionCounter = counter

                setTimeout(function(){
                    scope.showQuestions = true
                    scope.questionAux[currentCounter].answer_time = scope.quizTime
                }, 200)


            },

            getFeedback: function(){
                let scope = this
                this.showQuestions = false


                setTimeout(function(){
                    scope.feedback = true
                    scope.questionAux[scope.questionCounter].answer_time = scope.quizTime



                    for(let q of scope.questionAux){
                        let info = {
                            subjectId   : q.subject_idsubject,
                            userId      : parseInt(scope.userId),
                            questionId  : q.id,
                            correct     : 0,
                            userAnswer  : q.user_answer,
                            answerTime  : q.answer_time,
                            nOfLines    : q.nOfLines,
                            score       : 0
                        };

                        if(q.user_answer != null){
                            scope.$http.post(window.api + 'discursives/answer-questions',info)
                        }


                    }



                }, 200)

            }


        }
    }

</script>
