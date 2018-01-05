<!--
@Component:
    feedback
@Description:
    Quiz feedback page. It displays the user performance and resolution of the questions according
    to que quiz done.
@CalledComponents:
    1 - quiz-graph
    2 - question-counter-pagination
    3 - vue-spinner
@ApiRoutes:
@WebRoutes:
@Props:
    questions   : JSON list of resolved quiz questions
    userId      : user id
    token       : user authentication token
    subjectName : name of the quiz subject
    subjectId   : id of quiz subject
@TODO:
    1 - Graph tooltip when only one quiz resolved
    2 - Add percentil column
-->

<template xmlns:v-model="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div class="container">
        <div class="Feedback" v-if="!loading">

            <nav>
                <aside class="Sidebar col-sm-2 " style="margin-top: 60px">
                    <ul class="Sidebar-menu">
                        <li class="Sidebar-item">
                            <a href="#" v-on:click="tab=1"
                               :class="'Button btn-block Button--default ' + ((tab==1) ? 'Button--defaultBlueFull' : 'Button--defaultGreen')"
                               title="questions">Gabarito</a>
                        </li>
                        <li class="Sidebar-item">
                            <a href="#" v-on:click="tab=2"
                               :class="'Button btn-block Button--default ' + ((tab==2) ? 'Button--defaultBlueFull' : 'Button--defaultGreen')"
                               title="graph">Desempenho</a>
                        </li>
                    </ul>
                </aside>
            </nav>

            <!-- Grafico -->
            <div v-if="graph">
                <div class="container col-sm-10" v-if="!loading">
                    <div class="row">
                        <header class="Dashboard-header col-sm-12 u-m-b-20">
                            <div class="Feedback-header Feedback-header--color30">
                                <h2>
                                    Desempenho
                                </h2>
                            </div>
                        </header>
                        <div style="margin-top: 30px">
                            <quiz-graph
                                :all-subject-quizzes = "allSubjectQuizzes"
                                :user-id             = "userId"
                                :title               = "title"
                            >
                            </quiz-graph>
                            <header class="Feedback-header Feedback-header--color40 col-sm-12 u-m-b-20 u-m-t-20">
                                <h2 class="">{{ subjectName }}</h2>
                            </header>
                            <div class="Dashboard-content col-sm-12 u-m-b-40">
                                <div class="Widget">
                                    <div class="Widget-bgWhite Widget--border Widget-padding">
                                        <div id="accordion" role="tablist" aria-multiselectable="true" class="panel-group u-m-b-40">
                                            <div class="panel Accordion-panel">
                                                <header role="tab" id="heading-direito-administrativo" class="Accordion-header">
                                                    <h3 class="Accordion-title">
                                                        <a role="button" data-toggle="collapse"
                                                           data-parent="#accordion"
                                                           href="#collapse-direito-administrativo"
                                                           aria-expanded="true"
                                                           aria-controls="collapse-direito-administrativo"
                                                           class="Accordion-link"></a></h3>
                                                </header>
                                                <quiz-table
                                                        :table-data="tableData"
                                                ></quiz-table>
                                            </div>
                                        </div>
                                        <div class="Widget-footer text-center">
                                            <a href="#" class="Button Button--tiny
                                            Button--default Button--defaultBlue"
                                               title="Voltar para o início">Voltar para o início</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Grafico -->

            <!-- Gabarito -->
            <div v-if="question">

                <section class="Dashboard Dashboard--section">
                    <div class="container col-sm-10">
                        <div class="row">
                            <header class="Dashboard-header col-sm-12 u-m-b-20">
                                <div class="Feedback-header Feedback-header--color30">
                                    <h2>
                                        Gabarito
                                    </h2>
                                </div>
                            </header>
                            <div class="Dashboard-content col-sm-12" style="margin-top: 30px" >
                                <label for="quiz" class="Form-label">
                                    Escolha um Simulado pelo dia que você fez:
                                    <select v-on:change="getNewQuiz"
                                            v-model="quizIdSelected"
                                            id="quiz" name="quiz" placeholder="Selecione um Simulado"
                                            class="Form-select form-control">
                                        <option v-for="quiz in quizzes" v-bind:value="quiz.idquiz">
                                            {{quiz.created_at}}
                                        </option>
                                    </select>
                                </label>
                                <div v-if="questionsLoaded">

                                    <div class="row">
                                        <div class="col-sm-7 col-md-8 u-m-b-40" id="fadeOut">
                                            <div class="Widget u-noPadding">
                                                <div
                                                        class="Widget-bgWhite Widget--border Widget--noRadiusBottom Widget-padding">
                                                    <question-paginate
                                                            :questions        = "localQuestions"
                                                            :question-counter = "globalQuestionCounter"
                                                            :with-buttons     = "false"
                                                            :userId           = "userId"
                                                            :title            = "title"
                                                    >
                                                    </question-paginate>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-5 col-md-4 u-m-b-40">
                                            <question-counter-pagination
                                                    :max-value              = "maxValue"
                                                    :question-counter       = "globalQuestionCounter"
                                                    :offset                 = "1"
                                                    v-on:child-count-update = "updateGlobalQuestionCounter">
                                            </question-counter-pagination>
                                        </div>
                                    </div>
                                </div>
                                <div v-else>
                                    Escolha um Simulado anterior Para ver as questões
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <!-- END Gabarito -->
        </div>
        <div v-else style="margin:0 auto;">
            <page-loader color="#eb2341"></page-loader>
        </div>
    </div>
</template>

<script>
//    import DateHelper from "../../../../../../resources/assets/DateHelper";
    import ScaleLoader from 'vue-spinner/src/ScaleLoader.vue'
    import RingLoader from 'vue-spinner/src/RingLoader.vue'
    import GridLoader from 'vue-spinner/src/GridLoader.vue'
//    import firebaseQuiz from '../../firebase/quiz'

    export default {
        props : [
            'questions',
            'subjectName',
            'userId',
            'subjectId',
            'token',
            'title'
        ],

        components:{
            ScaleLoader,
            RingLoader,
            GridLoader,
        },

        data(){
            return{
                tab : 1,
                globalQuestionCounter  : 0,
                question         : true,
                graph            : false,
                thetas           : [],
                dataTest         : [],
                loading          : true,
                tableData        : [],
                testIdSelected   : null,
                quizIdSelected   : null,
                quizzes          : [],
                contests         : [],
                maxValue         : 0,
                localQuestions   : [],
                questionsLoaded  : false,
                allSubjectQuizzes : [],

            }
        },

        mounted() {

            this.getFirebaseData();
            this.getOldQuizzes();

            if(!this.questions)
                return;

            this.localQuestions = this.questions;
            this.maxValue = this.questions.length;
            this.questionsLoaded = true;
            $('[data-toggle="tooltip"]').tooltip()

        },
        watch:{
            tab(){
                switch(this.tab){
                    case 1:
                        this.question = true;
                        this.graph    = false;
                        break;
                    case 2:
                        this.question = false;
                        this.graph    = true;
                        break;
                }
            }
        },
        methods:{
            getOldQuizzes(){
                this.$http.get(window.api + 'user/get-old-user-quizzes/'+this.subjectId+'/'+this.userId).then(response=> {
                    let data = response.body.data;
                    this.quizzes  = data.quizzes;
                })
            },
            getFirebaseData(){
                let scope = this;
                var ref = firebaseQuiz.ref('/users/' + this.userId + '/' + this.subjectId);

                ref.on('value', function(snapshot) {
                    let response = snapshot.val();
                    let data    = {};

                    scope.allSubjectQuizzes = snapshot.val();

                    for(let key in response) {
                        scope.thetas.push(response[key].theta)
                        let tempKey = DateHelper.formatDateToShow(key);
                        data[key] = {
                            dateFormated : tempKey,
                            theta        : response[key].theta,
                            time         : response[key].time
                        }
                    }

                    scope.tableData = data;
                    scope.loading = false;
                });
            },
            getNewQuiz : function(){
                let scope = this;
                this.$http.get(window.api + 'quiz/get-old-quiz-questions/'+this.quizIdSelected).then(response=> {
                    scope.localQuestions = response.body.data.questions;
                    scope.maxValue = scope.localQuestions.length
                    scope.globalQuestionCounter = 0;
                    scope.questionsLoaded = true;

                })
            },

            active : function(data){
                this.tab = data;
                switch(data){
                    case 1:
                        this.question = true;
                        this.graph    = false;
                        break;
                    case 2:
                        this.question = false;
                        this.graph    = true;
                        break;
                }
            },

            updateGlobalQuestionCounter: function(count,bool) {
                if (bool) {
                    this.graph = true;
                    this.question = false;
                } else {
                    this.globalQuestionCounter = count

                }
            }
        }


    }
</script>
