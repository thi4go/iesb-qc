<!--
@Component:
    discursive-feedback
@Description:
    Page that responsible for showing feedback of discursive questions
    resolved
@CalledComponents:
    1 - question-counter-pagination
@ApiRoutes:
    discursives/answer-questions
@WebRoutes:
@Props:
    questions   : JSON with a list of discursive questions that were solved
    userId      : id of user
    token       : user authentication token
@TODO:
    1 - Edit Question
    2 - Auto evaluation
    3 - evaluation criterias
    4 - receive userId and token by props
-->

<template xmlns:v-model="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div>

        <section class="Dashboard Dashboard--section u-m-t-20">
            <div class="container">
                <div class="row">
                    <header class="Dashboard-header col-sm-12 u-m-b-20">
                        <h2 class="Dashboard-title Dashboard-title--color30">Correção</h2>
                    </header>
                    <div class="Dashboard-content col-sm-12">
                        <div class="row">
                            <div class="col-sm-7 col-md-8 u-m-b-40">
                                <div class="Widget u-noPadding">
                                    <div class="Widget-bgWhite Widget--border Widget-padding">

                                        <div class="Widget-header">
                                            <h3 class="Widget-title Widget-title--min Widget-title--color40 u-bold">
                                                {{questions[questionCounter].subject_name}}</h3>
                                            <p class="Widget-text Widget-text--tiny">
                                                {{questions[questionCounter].name_exam}}-{{examName}}
                                                {{questions[questionCounter].year}}</p>
                                        </div>
                                        <div class="Progress u-m-b-10">
                                            <p class="Progress-legend">Dificuldade</p>
                                            <div class="Progress-bar Progress-bar--color13 u-m-b-5">
                                                <div class="Progress-loading Progress-loading--color30" role="progressbar" aria-valuenow="79" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <p class="Progress-count">79%</p>
                                        </div>
                                        <hr>
                                        <div class="Widget-header clearfix">
                                            <h3 class="Widget-title Widget-title--tiny Widget-title--color30 u-bold pull-left">Enunciado</h3>
                                            <report-error
                                                    :userId     = "userId"
                                                    pageUrl     = "Feedback Discursiva"
                                                    :questionId = "questions[questionCounter].id"
                                                    :title      = "title"
                                            />
                                        </div>

                                        <transition name="fade">
                                            <div v-if="showQuestions">
                                                <div class="u-m-b-20">
                                                    <p class="Widget-text Widget-text--min" style="text-align: justify">
                                                        {{questions[questionCounter].associated_text}}
                                                        <br>
                                                        {{questions[questionCounter].statement}}
                                                    </p>
                                                    <hr>
                                                </div>

                                                <div class="u-m-b-20">
                                                    <div class="Widget-header clearfix u-m-b-10">
                                                        <h3 class="Widget-title Widget-title--tiny Widget-title--color40 u-bold">Sua resposta</h3>
                                                    </div>
                                                    <div class="Widget-content">
                                                        <p class="Widget-text Widget-text--min" style="text-align: justify">
                                                            {{questions[questionCounter].user_answer}}
                                                        </p>
                                                    </div>
                                                    <hr>
                                                </div>

                                                <div class="u-m-b-20">
                                                    <div class="Widget-header clearfix u-m-b-10">
                                                        <h3 class="Widget-title Widget-title--tiny u-bold pull-left">Gabarito</h3>
                                                    </div>
                                                    <div class="Widget-content">
                                                        <p class="Widget-text Widget-text--min" style="text-align: justify">
                                                            {{questions[questionCounter].feedback}}
                                                        </p>
                                                    </div>
                                                    <hr>
                                                </div>

                                                <div>
                                                    <!--<div class="Widget-header clearfix u-m-b-20">-->
                                                    <!--<h3 class="Widget-title Widget-title&#45;&#45;tiny u-bold pull-left">Auto-correção</h3>-->
                                                    <!--</div>-->
                                                    <div class="Widget-content">
                                                        <form action="#" class="Form Form--default">
                                                            <div v-if="criterias[0].Criteria!='' && criterias[0].Weight!='' ">
                                                                <table class="Table u-m-b-20">
                                                                    <thead>
                                                                    <tr>
                                                                        <th width="50%">Critério</th>
                                                                        <th width="20%">Pontos</th>
                                                                        <th width="30%">Acerto</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody class="u-bold">
                                                                    <tr v-for="(criteria, i) in criterias">
                                                                        <td data-th="Critério">
                                                                            {{criteria.Criteria}}

                                                                            <input type="hidden" id="criterion"
                                                                                   v-bind:name="criteria.Criteria"
                                                                                   v-bind:value="i" />
                                                                        </td>
                                                                        <td data-th="Pontos">
                                                                            <!--{{criteria.Weight}}-->
                                                                            <input type="number" v-model="evaluations[i]"
                                                                                   min="0" max="100" step="25"/>
                                                                        </td>
                                                                        <td data-th="Acerto">

                                                                            <p class="Progress-legend">
                                                                                {{evaluations[i]}}%</p>
                                                                            <div class="Progress-bar Progress-bar--color13 u-m-b-5">
                                                                                <div class="Progress-loading Progress-loading--color30"
                                                                                     role="progressbar"
                                                                                     v-bind:aria-valuenow="evaluations[i]"
                                                                                     v-bind:style="'width:'+evaluations[i]+'%'"
                                                                                     aria-valuemin="0" aria-valuemax="100"
                                                                                ></div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>

                                                                    </tbody>
                                                                </table>

                                                                <div class="row u-m-b-20">
                                                                    <div class="form-group col-sm-7">
                                                                        <!--<label  class="Form-label col-sm-5 control-label">Erros de escrita</label>-->
                                                                        <div class="col-sm-3">
                                                                            <!--<input type="number" v-model="writingScore" min="0" max="10" step="1"/>-->
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-sm-4 col-sm-offset-1">
                                                                        <label class="Form-label col-sm-5 control-label">Nota final</label>
                                                                        <div class="col-sm-4">
                                                                            <span>{{finalScore.toFixed(2)}}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="text-right">
                                                                <a id="feedback" v-on:click="evaluateQuestion"
                                                                   class="Button Button--default Button--defaultBlueFull">Finalizar</a>                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </transition>

                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-5 col-md-4 u-m-b-40">
                                <question-counter-pagination
                                        :question-counter = "questionCounter"
                                        :max-value        = "questions.length"
                                        :with-buttons     = "true"
                                        :offset           = "1"
                                        v-on:child-count-update="changeQuestion"
                                        :settable         = "true"
                                >
                                </question-counter-pagination>

                                <div class="Widget u-noPadding">
                                    <div class="Widget-bgBlue Widget--border Widget-padding Widget--noRadiusBottom text-center">
                                        <div class="Counter">
                                            <h3 class="Widget-title Widget-title--color10 Widget-title--tiny u-bold">Meu tempo</h3>
                                            <p class="Counter-time">{{questions[questionCounter].answer_time}}</p>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>


    </div>

</template>

<script>
    import vueSlider from 'vue-slider-component'

    export default {
        props: [
            'questions',
            'userId',
            'token',
            'examName',
            'title'
        ],

        data() {
            return {
                questionCounter : 0,
                showQuestions   : true,
                writingScore    : 0,
                criterias       : [],
                evaluations     : [],
                finalScore      : 0
            }
        },

        mounted() {
            this.populateCriteria()
        },

        watch: {
            evaluations: function(){
                let i = 0
                this.finalScore = 0

                for(let value of this.evaluations){
                    this.finalScore += parseFloat(this.criterias[i].Weight) * (parseFloat(value)/100)
                    i += 1
                }

            }
        },

        methods: {
            changeQuestion: function(counter){
                let scope = this
                let currentCounter = this.questionCounter
                this.showQuestions = false
                this.questionCounter = counter

                this.populateCriteria()

                setTimeout(function(){
                    scope.showQuestions = true
                }, 200)

            },


            evaluateQuestion: function (event) {
                event.preventDefault

                let scope = this
                let q = scope.questions[scope.questionCounter]

                let nlines = q.hasOwnProperty('nOfLines')? q.nOfLines : q.answer_lines

                let info = {
                    subjectId   : q.subject_idsubject,
                    userId      : parseInt(scope.userId),
                    questionId  : q.id,
                    correct     : 0,
                    userAnswer  : q.user_answer,
                    answerTime  : q.answer_time,
                    nOfLines    : nlines,
                    score       : scope.finalScore
                };


                if(q.user_answer != null){
                    scope.$http.post(window.api + 'discursives/answer-questions',info)
                }

                window.location.assign('/dashboard/discursivas');

            },

            populateCriteria: function () {
                this.criterias      = []
                this.evaluations    = []

                try{
                    for(let criteria of JSON.parse(this.questions[this.questionCounter].criteria)){
                        this.criterias.push(criteria)
                        this.evaluations.push(0)
                    }
                }catch (e){
                    this.criterias      = [{
                        Criteria: "",
                        Weight:   ""
                    }]
                    this.evaluations    = []
                }

            }

        }

    }







</script>
