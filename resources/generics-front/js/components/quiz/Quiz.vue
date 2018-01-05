<!--
@Component:
    quiz
@Description:
    Quiz feedback page. It displays the user performance and resolution of the questions according
    to que quiz done.
@CalledComponents:
    1 - feedback
    2 - question-shower
    3 - question-counter-pagination
    4 - timer
@ApiRoutes:
    question/get-best-question/
    question/get-future-best-question
    user/answerQuizQuestion
@WebRoutes:
@Props:
    questions   : JSON list of resolved quiz questions
    userId      : user id
    token       : user authentication token
    subjectName : name of the quiz subject
    subjectId   : id of quiz subject
@Constants:
    QUESTIONS_NUMBER: number of questions that composes the quiz
@TODO:
    1 - Reload quiz from where user stopped last time, in case it was not finished.
-->

<template xmlns:v-model="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div>
        <div v-if="loading">
            <page-loader color="#eb2341"></page-loader>
        </div>

        <div v-else-if="feedback">
            <feedback
                    :questions="questions"
                    :subject-name="subjectName"
                    :user-id="userId"
                    :subject-id="subjectId"
                    :title="title"
            ></feedback>
        </div>

        <div v-else>

            <section class="Dashboard Dashboard--section u-m-t-40">
                <div class="container">
                    <div class="row">
                        <header class="Dashboard-header col-sm-12 u-m-b-20">
                            <h2 class="Dashboard-title Dashboard-title--color30">Simulado</h2>
                        </header>
                        <div class="Dashboard-content col-sm-12" >
                            <div class="row">

                                <div class="col-sm-7 col-md-8 u-m-b-40" id="fadeOut">
                                    <div class="Widget u-noPadding">
                                        <div class="Widget-bgWhite Widget--border Widget--noRadiusBottom Widget-padding">

                                                <question-shower
                                                        v-on:child-answer  = "answerQuestion"
                                                        :question          = "question"
                                                        :isResult          = "false"
                                                        :button-type       = "buttonType"
                                                        :userId            = "userId"
                                                        :title             =  "title"
                                                        @question-reported = "replaceQuestion">
                                                </question-shower>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-5 col-md-4 u-m-b-40">
                                    <question-counter-pagination
                                            :question-counter = "questionCounter"
                                            :max-value        = "QUESTIONS_NUMBER"
                                            :with-buttons     = "false"
                                            :offset           = "1"
                                    >
                                    </question-counter-pagination>

                                    <div class="Widget u-noPadding">
                                        <timer
                                                v-bind:feedBackTime= "!showQuestions"
                                                v-on:child-msg="getFinalTime"></timer>
                                        <!--<div class="Widget-bgDarkBlue Widget-padding text-center">-->
                                            <!--<a href="/sair" class="Button Button&#45;&#45;default Button&#45;&#45;defaultGreenWhite btn-block" title="Finalizar">Finalizar</a>-->
                                        <!--</div>-->
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

<script src="https://www.gstatic.com/firebasejs/3.7.0/firebase.js"></script>

<script>


    const QUESTIONS_NUMBER = 10;

    export default {
        props : [
            'quizId',
            'userId',
            'subjectId',
            'subjectName',
            'title'
        ],

        data(){
            return {
                question            :  [],
                questions           : [],
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
                quiztime            : null,
                QUESTIONS_NUMBER    : QUESTIONS_NUMBER,
                buttonType          : 2,
                streak              : 1
            }
        },

        mounted() {
            let data = {
                subjectId : parseInt(this.subjectId),
                userId : parseInt(this.userId),
                quizId : parseInt(this.quizId),
                delta_theta : this.streak + 1,
            };

            this.$http.post(window.api+'question/get-best-question/',data).then(response=>{
                this.question = response.body.data;
                this.loading = false;

                this.getFutureNewQuestion(data);
            })
        },

        methods:{

            getFutureNewQuestion: function (data) {

                let scope = this;
                let dataOld = data
                data.questionId = this.question.idquest;

                this.questionsId.push(this.question.idquest);

                data.questionsId = this.questionsId;

                this.$http.post(window.api+'question/get-future-best-question',data).then(response=>{
                    if(!(response.body.data.futureRightAnswerQuestion.success && response.body.data.futureWrongAnswerQuestion.success)){
                        scope.getFutureNewQuestion(dataOld)
                        return
                    }
                    scope.futureRightQuestion = response.body.data.futureRightAnswerQuestion;
                    scope.futureWrongQuestion = response.body.data.futureWrongAnswerQuestion;

                    if(!this.answering)
                        return;

                    this.answerLogic(this.answer);
                })

            },

            answerQuestion: function(answer){
                this.questions.push(this.question);
                this.answering = true;

                this.showQuestions = false;

                if(this.questionCounter === QUESTIONS_NUMBER - 1)
                    this.calculateFeedback(answer);
                else
                    this.answerAndGetNewQuestion(answer);
            },

            answerAndGetNewQuestion: function (answer) {
                if(this.futureWrongQuestion.length !== 0) {
                    this.answerLogic(answer);
                }
                else
                    this.answer = answer;
            },

            answerLogic: function (answer) {
                let data,idquest = this.question.idquest;
                let scope = this;

                if (this.question.correct_answer === answer) {
                    this.question = this.futureRightQuestion;
                    this.streak++;
                }
                else {
                    this.question = this.futureWrongQuestion;
                    this.streak = 1;
                }

                this.futureWrongQuestion = [];
                this.futureRightQuestion = [];

                data = {
                    questionId  : idquest,
                    delta_theta : this.streak + 1, //+1 pois é da questão n+1
                    subjectId   : parseInt(this.subjectId),
                    quizId      : parseInt(this.quizId),
                    userId      : parseInt(this.userId),
                    user_answer : answer,
                    questionsId : this.questionsId,
                    feedback    : 0,
                };

                this.answering = false;

                this.questionCounter++;

                this.$http.post(window.api + 'user/answerQuizQuestion', data).then(response=> {
                    scope.getFutureNewQuestion(data);
                })
            },

            findGetParameter: function (parameterName) {
                let result = null,
                        tmp = [];
                location.search
                        .substr(1)
                        .split("&")
                        .forEach(function (item) {
                            tmp = item.split("=");
                            if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
                        });
                return result;
            },
            calculateFeedback: function (answer) {
                let data;

                this.answering   = true;

                data = {
                    questionId  : this.question.idquest,
                    delta_theta : this.streak + 1,
                    subjectId   : parseInt(this.subjectId),
                    quizId      : parseInt(this.quizId),
                    userId      : parseInt(this.userId),
                    user_answer : answer,
                    feedback    : 1
                };


                this.$http.post(window.api+'user/answerQuizQuestion',data).then(response=>{

                    let firebaseData = {};

                    let timeNow = new Date();
                    timeNow = DateHelper.formateDateTime(timeNow);

                    let theta = Calculator.normalcdf(response.body.data.theta)*100;
                    let thetas = response.body.data.thetas;

                    firebaseData[timeNow] = {
                        'theta'  : theta,
                        'thetas' : thetas,
                        'time'   : this.quizTime,
                        'quizId' : this.quizId
                    };

                    this.writeUserData(firebaseData);

                })

            },

            writeUserData: function (firebaseData) {
                let userId    = this.userId;
                let subjectId = this.subjectId;
                let scope = this;
                let key    = Object.keys(firebaseData)[0];
                let values = firebaseData[key];
                let traceback = this.findGetParameter('schedule');

                firebaseQuiz.ref('users/' + userId + '/' + subjectId+'/'+key).set(values, function() {
                    if(traceback)
                        window.location.replace('controle');
                    else
                        scope.feedback = true;
                });
            },

            getFinalTime: function (time) {
                this.quizTime = time;
                if(!this.answering)
                    this.showQuestions = true;
            },

            replaceQuestion(){
                let idquest = this.question.idquest
                this.questionsId.pop();
                let data = {
                    questionId  : idquest,
                    delta_theta : this.streak + 1,
                    subjectId   : parseInt(this.subjectId),
                    quizId      : parseInt(this.quizId),
                    userId      : parseInt(this.userId),
                    questionsId : this.questionsId,
                };
                this.question = this.futureRightQuestion;
                this.futureWrongQuestion = [];
                this.futureRightQuestion = [];
                this.getFutureNewQuestion(data);
            },
        }
    }

</script>
