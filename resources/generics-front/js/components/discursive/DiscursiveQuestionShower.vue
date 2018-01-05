<!--
@Component:
    discursive-question-shower
@Description:
    Page that shows question to be resolved
@CalledComponents:
    1 - report-error
@ApiRoutes:
@WebRoutes:
@Props:
    question    : JSON with the question being showed
    withButtons : flag to display buttons or not
    buttonType   type of the button that will be displayed
    userId      : id of user
    token       : user authentication token
@TODO:
-->



<style>
    .textArea{
        border: none;
        outline: none;
        resize: none;
        -webkit-box-shadow: none;
        -moz-box-shadow: none;
        box-shadow: none;
        line-height: 30px;
        display:block;
        max-height:300px;

    }
</style>

<template xmlns:v-model="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div >


        <div class="Widget-header">
            <h3 class="Widget-title Widget-title--min Widget-title--color40 u-bold">
                {{question.subject_name}}
            </h3>
            <p class="Widget-text Widget-text--tiny">
                {{question.name_exam}} - {{examName}}
                {{question.year}}</p>
            <p id="name_contest">  </p>
        </div>
        <hr>
        <div class="Widget-header clearfix">
            <h3 class="Widget-title Widget-title--tiny Widget-title--color30 u-bold pull-left">Enunciado</h3>
            <report-error
                :userId = "userId"
                pageUrl     = "Resolução de Discursivas"
                :questionId = "question.id"
                :title      = "title"
            />
        </div>
        <transition name="fade">
            <div v-if="notAnswered" class="alert alert-warning">
                <p>Selecione uma questão para poder avançar</p>
            </div>
        </transition>

        <transition name="fade">
            <div v-if="showQuestion">
                <p id="question" style="text-align: justify;">
                    {{question.associated_text}}
                    <br>
                    {{question.statement}}
                </p>

                <div id="disResolution" >


                    <div class="Form Form--discursive u-m-t-10 ">
                        <h3 class="Widget-title Widget-title--tiny Widget-title--color30 u-bold pull-left"
                        style="padding-bottom: 10px;padding-top: 10px">
                            Sua Resposta</h3>
                        <br>
                        <div class="Form-paper col-sm-11" >
                            <textarea
                                    style="margin-top: 20px;"
                                    class="Form-paper textArea col-sm-11"
                                    v-model="answer"
                                    NAME="HARD"
                                    v-bind:COLS="nCols"
                                    ROWS="5"
                                    WRAP="HARD"
                            ></textarea>
                        </div>
                        <!--<div class="form-group text-right">-->
                            <!--<a  v-on:click="answerQuestion" class="Button Button&#45;&#45;default Button&#45;&#45;defaultBlueFull"-->
                                <!--type="submit">Resolver</a>-->
                        <!--</div>-->
                        <div id="countLines" class="text-right">
                            <p class="Button Button--tiny Button--min Button--default Button--defaultGreen js-notebook-count">
                               Numero de linhas {{nOfLines}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </div>

</template>

<script>
    import vueSlider from 'vue-slider-component'

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
            userId:{

            },
            token:{

            },
            examName:{
                type: String
            },
            title:{

            }
        },

        data() {
            return {
                answer       : null,
                isResult     : false,
                answering    : false,
                notAnswered  : false,
                showQuestion : true,
                nOfLines     : 1,
                nCols        : 60
            }
        },

        mounted() {
            if(this.question == null)
                return;
            this.setResult()
            window.addEventListener('resize', this.handleResize)

            this.handleResize()

        },

        watch: {
            question: function(){
                if(this.question == null)
                    return;
                this.answer      = null
                this.answering   = false
                this.showQuestion = false
                this.notAnswered = false

                let scope = this;

                setTimeout(function(){
                    scope.showQuestion = true
                },200)

                this.setResult()
            },

            answer: function() {
                this.calculateLines()
                this.checkAnswer()

            },
        },

        methods: {
            showResolution: function() {
                this.isResult = true
            },

            calculateLines: function() {
                let rowArray = this.answer.split(/\r*\n/)
                let counter =  rowArray.length

                for(let row of rowArray){
                    counter += Math.floor(row.length / this.nCols)
                }

                this.nOfLines = counter

                this.question.nOfLines = this.nOfLines
            },

            handleResize : function(){
                let screenWidth = document.documentElement.clientWidth

                if(screenWidth >= 1000 ){
                    this.nCols = 60
                }else if(screenWidth < 1000 &&  screenWidth >= 980){
                    this.nCols = 50
                }else if(screenWidth < 980 &&  screenWidth >= 768){
                    this.nCols = 30
                }else if(screenWidth < 768 &&  screenWidth >= 725){
                    this.nCols = 50
                }else if(screenWidth < 725 &&  screenWidth >= 645){
                    this.nCols = 40
                }else if(screenWidth < 645 &&  screenWidth >= 455){
                    this.nCols = 30
                }else{
                    this.nCols = 20
                }

                this.calculateLines()

            },

            answerQuestion : function(){

                if(this.answer === null) {
                    this.notAnswered = true;
                    return;
                }

                this.answering   = true
                this.notAnswered = false


                this.showResolution()


            },

            setResult: function() {
                if(this.question.user_answer !== undefined)
                    this.isResult = true
                else
                    this.isResult = false
            },

            checkAnswer :function(){
                this.question.user_answer = this.answer
            },


        }

    }







</script>
