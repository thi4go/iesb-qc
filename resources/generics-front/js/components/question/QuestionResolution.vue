<!--
@Component:
    question-resolution
@Description:
    Component that shows current question number ant total of questions. Each time the current question counter
    is incremented, a emit is sent to the component parent. It loads 30 by 30 questions in order to
    improve performance.
@CalledComponents:
    1 - timer
    2 - question-topic-changer
    3 - question-paginate
    4 - question-counter-pagination
    5 - vue-spinner
@ApiRoutes:
    questions/by-{generic}/{id},{currentPagination}?token={token}
    questions/by-{generic}-user-nr/{id}/{currentPagination}/{userId}?token={token}
    questions/by-{generic}-user/{id}/{currentPagination}/{userId}?token={token}
    questions/by-{generic}-not-reviewed/{id},{currentPagination}?token={token}
@WebRoutes:
@Props:
    subject         : subject of the current question
    topic           : topic of the current question
    questions       : JSON list of questions to be displayed
    user            : user information
    count           : number of questions to be resolved
    generic         : 'topic' or 'subject', adjustable according to type of request being done
    userId          : user id
    status          : type of request that will be done for api
    id              : subject or topic id
@TODO:
    1 - Remove props redundancy. i.e: userId and user
    2 - Receive and use token
-->

<template>
    <section class="Dashboard Dashboard--section u-m-t-40">
        <div class="container">
            <div class="row">
                <header class="Dashboard-header col-sm-12 u-m-b-20">
                    <h2 class="Dashboard-title Dashboard-title--color30">Questões</h2>
                </header>
                <div class="Dashboard-content col-sm-12" >
                    <div class="row">
                        <div class="col-sm-7 col-md-8 u-m-b-40" id="fadeOut">
                            <div class="Widget u-noPadding">
                                <div class="Widget-bgWhite Widget--border Widget--noRadiusBottom Widget-padding">
                                    <div v-if="user.user_level == 4">
                                        <question-topic-changer
                                                :id-subject="subject.idsubject"
                                                :question = "questions[questionIndex]"
                                        >
                                        </question-topic-changer>
                                        <!-- <question-show-by-id></question-show-by-id> -->
                                        <label for=""> Digite o ID da questão: </label>
                                        <input type="text" v-model="questionID">
                                        <button @click="showQuestionByID" class="Button Button--default Button--defaultBlueFull" >Buscar Questão</button>
                                    </div>
                                    <question-paginate v-if="showPaginate"
                                            :questions         = "questions"
                                            :question-counter  = "questionIndex"
                                            :userId            = "userId"
                                            :user_level        = "user.user_level"
                                            :title             = "title"
                                            @pause-timer       = "pauseTimer">
                                    </question-paginate>
                                    <!-- v-on:child-count-update = "updateGlobalQuestionCounter"> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-5 col-md-4 u-m-b-40">
                            <pulse-loader v-if="loading"></pulse-loader>
                            <question-counter-pagination
                                    v-else
                                    :max-value         = "maxValue"
                                    :question-counter  = "globalQuestionCounter"
                                    :offset            = "1"
                                    v-on:child-count-update = "updateGlobalQuestionCounter"
                                    :settable          = "true">
                            </question-counter-pagination>
                            <div class="Widget u-noPadding">
                                <timer
                                        v-bind:feedBackTime= "getFeedbackTime"
                                        v-on:child-msg="getFinalTime"
                                        :pause-timer="pause"></timer>
                                <div class="Widget-bgDarkBlue Widget-padding text-center">
                                    <div v-if="!submitting">
                                        <button v-on:click="setFeedbackTime" class="Button Button--default Button--defaultGreenWhite btn-block" title="Finalizar">Finalizar</button>
                                    </div>
                                    <div v-else>
                                        <pulse-loader></pulse-loader>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
//    import DateHelper from "../../../../../../resources/assets/DateHelper";
//    import FirebaseUserQuestions from '../../firebase/user-questions'
    import PulseLoader from 'vue-spinner/src/PulseLoader.vue'

    export default {

        props: {
            title:{
            },
            subject:{
            },
            topic:{
            },
            questions:{
                default:[]
            },
            user:{
            },
            count:{
            },
            generic:{
                default:'subject'
            },
            userId:{
            },
            status:{
                default:1
            },
            token:{
            },
            jury:{
                default: null
            },
            startYear:{
            },
            endYear:{
            },
            keyWord:{
                default: ""
            },
            nOfAlt:{
                default: null
            }
        },

        components: {
            PulseLoader
        },

        data() {
            return {
                questionID: 0,
                maxValue: 0,
                globalQuestionCounter: 0,
                getFeedbackTime: false,
                finalTime: null,
                currentPagination: 0,
                submitting: false,
                paginations:    [0],
                questionIndex: 0,
                loading:    false,
                resolvedQuestions: [],
                id : 0,
                showPaginate : true,
                pause : false
            }
        },

        mounted(){
            this.maxValue = (this.count == 0 ? this.questions.length : this.count)
        },

        methods: {

            setFeedbackTime: function() {
                this.resolvedQuestions = this.computeResolvedQuestions()
                if(this.resolvedQuestions.length == 0){
                    alert('Responda ao menos uma questão!')
                } else {
                    this.submitting      = true
                    this.getFeedbackTime = true
                }
            },

            getFinalTime: function(value) {
                this.finalTime       = value
                this.getFeedbackTime = false
                this.sendUserResolutions()
            },

            updateGlobalQuestionCounter: function(value, showFB) {

                if(showFB){
                    this.setFeedbackTime()
                    return
                }

                let valuePagination = parseInt(value / 30)
                this.loading = false
                this.globalQuestionCounter = value
                if(this.currentPagination != valuePagination){
                    this.currentPagination = valuePagination

                    if(!(valuePagination in this.paginations)){
                        let scope = this

                        this.paginations.push(valuePagination)

                        if(this.topic.idtopic == null) {
                            if(this.subject.hasOwnProperty('subject')){
                                scope.id = 0;
                            }else {
                                scope.id = this.subject.idsubject
                            }
                        }else
                            scope.id = this.topic.idtopic

                        let data = {
                            id          : scope.id,
                            jury        : scope.jury,
                            status      : scope.status,
                            userId      : scope.userId,
                            startYear   : scope.startYear,
                            endYear     : scope.endYear,
                            keyWord     : scope.keyWord,
                            nOfAlt      : scope.nOfAlt,
                            pagination  : scope.currentPagination
                        };


                        let url = 'questions/by-' + this.generic

                        this.loading = true
                        this.$http.post(window.api + url, data).then(response => {
                            for(let question of response.body.questions)
                            {
                                scope.questions.push(question)
                            }
                            this.questionIndex = (this.paginations.indexOf(this.currentPagination)*30) + value%30
                            scope.loading = false
                        })
                    }
                }
                if(!this.loading)
                    this.questionIndex = (this.paginations.indexOf(this.currentPagination)*30) + value%30
            },

            showQuestionByID () {
              this.questions[0].userAnswer = ''
              this.showPaginate = false
              let scope = this
              this.$http.get(window.api+'question/show/'+this.questionID).then(response=>{
                // console.log(response.body.questions)
                //console.log(scope.questions[0])
                if (response.body.questions.idquest == scope.questionID) {
                  scope.questions[0].reviewed = response.body.questions.reviewed
                  scope.questions[0].idquest = response.body.questions.idquest
                  scope.questions[0].enunciation = response.body.questions.enunciation
                  scope.questions[0].subject_name = response.body.questions.subject_name
                  scope.questions[0].topic_name = response.body.questions.topic_name
                  scope.questions[0].jury_name = response.body.questions.jury_name
                  scope.questions[0].bestcomment = response.body.questions.bestcomment
                  scope.questions[0].year = response.body.questions.year
                  scope.questions[0].associated_text = response.body.questions.associated_text
                  for (var i = 0; i < response.body.questions.alternatives.length; i++) {
                    if (response.body.questions.alternatives[i].letter == "a") {
                      scope.questions[0].first_answer =  response.body.questions.alternatives[i].text
                    } else if (response.body.questions.alternatives[i].letter == "b") {
                      scope.questions[0].second_answer = response.body.questions.alternatives[i].text
                    } else if (response.body.questions.alternatives[i].letter == "c") {
                      scope.questions[0].third_answer =  response.body.questions.alternatives[i].text
                    } else if (response.body.questions.alternatives[i].letter == "d") {
                      scope.questions[0].forth_answer =  response.body.questions.alternatives[i].text
                    } else {
                      scope.questions[0].fifth_answer =  response.body.questions.alternatives[i].text
                    }
                  }
                  if (response.body.questions.alternatives.length == 2) {
                    scope.questions[0].third_answer = null
                    scope.questions[0].forth_answer = null
                    scope.questions[0].fifth_answer = null
                  }
                  if (response.body.questions.alternatives.length == 4) {
                    scope.questions[0].fifth_answer = null
                  }
                  scope.questionIndex = 0
                  for (var i = 0; i < response.body.questions.alternatives.length; i++) {
                    if (response.body.questions.alternatives[i].idalternative == response.body.questions.correct_answer) {
                      scope.questions[0].correct_answer =  response.body.questions.alternatives[i].letter
                    }
                  }
                } else {
                  alert("Questão não encontrada!")
                }
                scope.showPaginate = true;
              })
            },

            sendUserResolutions: function() {
                let firebaseRequest   = null

                if(this.topic.idtopic == null)
                    this.topic.idtopic = 0

                let request = {
                    questions : this.resolvedQuestions,
                    idsubject : this.subject.idsubject,
                    idtopic   : this.topic.idtopic,
                    time      : this.finalTime,
                    total     : this.resolvedQuestions.length
                }


                this.$http.post(window.api+'user/resolved-questions/'+this.user.id, request)
                    .then(response => {
                        this.writeDataToFirebase(response.body.data)
                    })
            },

            writeDataToFirebase: function(data) {
                let timeNow = new Date()
                let scope   = this

                timeNow     = DateHelper.formateDateTime(timeNow)

                let values = {
                    'correct': data.correct,
                    'total'  : data.total,
                    'time'   : data.time
                }
                let values_arr = [];
                //  para questões que tem seu topico selecionado
                for(let quest of scope.resolvedQuestions){
                    let topic = quest.topic_idtopic
                    if(scope.subject.idsubject == 0){
                        topic = quest.subject_idsubject
                    }
                    if(!values_arr[topic]){
                        values_arr[topic] = {
                            'correct': 0,
                            'total'  : 0,
                            'time'   : data.time
                        }
                    }
                    if (quest.correct_answer == quest.userAnswer) {
                        values_arr[topic].correct++;
                    }
                    values_arr[topic].total++;

                }

                let ref = FirebaseUserQuestions.ref(
                    'users/' + scope.user.id + '/' +scope.subject.idsubject + '/0/' + timeNow
                ).set(values, function() {})

                for(let value in values_arr){
                    let ref = FirebaseUserQuestions.ref(
                        'users/' + scope.user.id+'/'+scope.subject.idsubject+'/'+value+ '/' +timeNow
                    ).set(values_arr[value], function() {
                        window.location.assign('/dashboard/result/'+scope.subject.idsubject+'/'+scope.topic.idtopic);
                    })
                }
            },
            computeResolvedQuestions(){
                return this.questions.filter((value) => {
                            return (value.userAnswer != undefined)
                    })
            },
            pauseTimer(value){
                this.pause = value
            }
        }
    }
</script>
