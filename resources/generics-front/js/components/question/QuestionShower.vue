<!--
@Component:
    question-shower
@Description:
    Page that shows question to be resolved
@CalledComponents:
    1 - report-error
    2 - vue-spinner
@ApiRoutes:
@WebRoutes:
@Props:
    question    : JSON with the question being showed
    withButtons : flag to display buttons or not
    buttonType   type of the button that will be displayed
    userId      : id of user
@TODO:
    1 - Show question jury
    2 - Show question year
    3 - Show question difficulty level
-->

<template xmlns:v-model="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div>
        <div class="Widget-header">
            <h3 class="Widget-title Widget-title--min Widget-title--color40 u-bold">{{ questionData.subject_name }}</h3>
            <p class="Widget-text Widget-text--tiny u-bold u-noMargin">{{ questionData.topic_name }}</p>
            <div v-if="buttonType == 1" class="u-m-t-10">
                <span class="Widget-text Widget-text--tiny">{{questionData.carrer}}</span>
                <span v-if="questionData.carrer!=null && questionData.institution!=null" class="Widget-text Widget-text--tiny u-bold u-noMargin"> - </span>
                <span class="Widget-text Widget-text--tiny">{{questionData.institution}}</span>
            </div>
            <div v-if="buttonType == 1">
                <span class="Widget-text Widget-text--tiny">{{questionData.jury_name}}</span>
                <span class="Widget-text Widget-text--tiny"> {{questionData.year}}</span>
                <span class="Widget-text Widget-text--tiny" v-if="user_level == 4"> ID da questão: {{questionData.idquest}}</span>
            </div>
        </div>
        <hr>
        <div class="Widget-header clearfix" id="alert">
            <h3 class="Widget-title Widget-title--tiny Widget-title--color30 u-bold pull-left">Enunciado</h3>
            <report-error
                    :userId = "userId"
                    pageUrl     = "Resolução de Questões"
                    :questionId = "questionData.idquest"
                    :title      = "title"
                    @question-reported = "$emit('question-reported')"
            />
        </div>

        <div v-if="!isResult"> <!-- Normal quesions -->
            <transition name="fade">
                <div v-if="notAnswered" class="alert alert-warning">
                    <p>Selecione uma questão para poder avançar</p>
                </div>
            </transition>
            <transition name="fade-question">
                <div v-if="showQuestion">
                    <p v-html="questionData.associated_text"></p>
                    <br>
                    <br>
                    <p v-html="questionData.enunciation"></p>
                    <br>
                    <div v-for="(alternative, i) in alternatives">
                        <div class="question-item-wrapper" v-if="alternative">
                            <input v-on:change="checkAnswer" type="radio" name="answer"
                                   v-bind:value="letters[i]" v-bind:id="'alternative'+ i" v-model="answer"/>
                            <label class="question-item" v-bind:for="'alternative'+ i" >
                                {{letters[i]}})
                                {{alternative}}
                            </label>
                        </div>
                    </div>
                    <div v-if="!answering">
                        <div v-if="buttonType == 2" class="Form-group form-group text-center u-m-t-40">
                            <button v-on:click="answerQuestion" id="quiz-next-question"
                               class="Button Button--default Button--defaultBlueFull" title="Prosseguir"
                            >Responder</button>
                        </div>
                        <div v-else-if="buttonType == 1" class="Form-group form-group text-center u-m-t-40">
                            <button v-on:click="answerQuestion"
                                    class="Button Button--default Button--defaultBlueFull" title="Ver resposta">
                                Ver resposta</button>
                        </div>
                    </div>
                    <div v-else class="Form-group form-group text-center u-m-t-40">
                        <pulse-loader color="#eb2341"></pulse-loader>
                    </div>
                </div>
            </transition>
        </div>

        <div v-else> <!-- Question feedback -->
            <transition name="fade">
                <div v-if="showQuestion">
                    <article>
                        <p v-html="questionData.associated_text"></p>
                        <br>
                        <br>
                        <p v-html="questionData.enunciation"></p>
                        <br>
                    </article>
                    <br>
                    <div v-for="(alternative, i) in alternatives">
                        <div class="question-item-wrapper" v-if="alternative">
                            <!-- normal wrong alternative-->
                            <p
                                    v-if="questionData.correct_answer != letters[i] && questionData.userAnswer != letters[i]"
                                    class="question-item--regular" >
                                {{letters[i]}}) {{alternative}}
                            </p>
                            <!-- user marked wrong answer -->
                            <p
                                    v-if="questionData.userAnswer == letters[i] && questionData.userAnswer != questionData.correct_answer"
                                    class="question-item--marked-wrong" >
                                {{letters[i]}}) {{alternative}}
                            </p>
                            <!-- correct alternative -->
                            <p v-if="questionData.correct_answer == letters[i]" class="question-item--marked" >
                                {{letters[i]}}) {{alternative}}
                            </p>
                        </div>
                    </div>
                    <div v-if="questionData.bestcomment && questionData.reviewed == 1" class="resolution-area"
                         style="padding:1em;color:white;background-color:#292929 ; margin-top: 2em;">
                        <h4>Resolução</h4>
                        <br>
                        <p v-html="styleTag+questionData.bestcomment+ '</>'" align="justify"></p>
                        <br>
                    </div>
                    <div v-else class="resolution-area" style="padding:1em;color:white;background-color:#292929 ; margin-top: 2em;">
                        <h4>Não há resolução</h4>
                    </div>
                </div>
            </transition>
        </div>
    </div>
</template>

<script>
    import SyncLoader from 'vue-spinner/src/SyncLoader.vue'
    import PulseLoader from 'vue-spinner/src/PulseLoader.vue'

    export default {
        props: {
            question: {
                type: Object
            },
            withButtons: {
                default: false
            },
            buttonType:{
                type: Number,
                default: 1
            },
            userId:{},
            title:{},
            user_level:{
              type: Number,
              default: 2
            }
        },

        components: {
            SyncLoader,
            PulseLoader
        },

        data() {
            return {
                questionData     : null,
                answer       : null,
                letters      : ['a', 'b', 'c', 'd', 'e'],
                alternatives : [],
                isResult     : false,
                answering    : false,
                notAnswered  : false,
                showQuestion : true,
                styleTag     : "<pre style='white-space: pre-wrap'>"
            }
        },

        mounted() {
            this.questionData = this.question
            if(this.questionData == null)
                return;
            this.setResult()
            this.addQuestionToAlternative(this.questionData)

        },

        watch: {
            question: function(){
                this.questionData = this.question
                if(this.questionData == null)
                    return;
                if(this.questionData.carrer == "NULL")
                    this.questionData.carrer = null
                if(this.questionData.institution == "NULL")
                    this.questionData.institution = null
                if(this.questionData.jury_name == "NULL")
                    this.questionData.jury_name = null
                this.answer      = null
                this.answering   = false
                this.showQuestion = false
                let scope = this;

                setTimeout(function(){
                    scope.addQuestionToAlternative(scope.questionData)
                    scope.showQuestion = true
                },200)

                this.setResult()
            },

            isResult(){
                this.$emit('resolution-show', this.isResult)
            }
        },

        methods: {
            showResolution: function() {
                this.isResult = true
            },

            answerQuestion : function(){

                if(this.answer === null) {
                    this.notAnswered = true;
                    return;
                }

                this.answering   = true
                this.notAnswered = false

                switch (this.buttonType){
                        //filter
                    case 1:
                        this.showResolution()
                        break;
                        //quiz
                    case 2:
                        this.$emit('child-answer', this.answer)
                        break;
                }

            },

            setResult: function() {
                if(this.questionData.userAnswer !== undefined)
                    this.isResult = true
                else
                    this.isResult = false
            },

            checkAnswer :function(){
                this.questionData.userAnswer = this.answer
            },

            addQuestionToAlternative : function(questionData){
                this.alternatives = []
                this.questionData     = questionData
                this.alternatives.push(questionData.first_answer)
                this.alternatives.push(questionData.second_answer)
                this.alternatives.push(questionData.third_answer)
                this.alternatives.push(questionData.forth_answer)
                this.alternatives.push(questionData.fifth_answer)
            }
        }
    }
</script>
