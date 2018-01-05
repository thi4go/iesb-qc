<!--
@Component:
    question-counter-pagination
@Description:
    Component that shows current question number ant total of questions. Each time the current question counter
    is incremented, a emit is sent to the component parent
@CalledComponents:
@ApiRoutes:
@WebRoutes:
@Props:
    questionCounter : current question counter
    maxValue        : max number of questions that can be paginated
    withButtons     : flag that displays next and back button or not
    offset          : number that count is incremented by.
@TODO:
-->

<template xmlns:v-model="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div class="Widget u-noPadding u-m-b-30">
        <div class="Widget-bgWhite Widget--border Widget-padding text-center">
            <label class="Form-label">Questão
                <span v-if="!editing">{{questionCounterOffset}}</span>
                <input v-else v-model="questionSet" style="width: 3em" class="text-center"></input>
                de <span>{{maxValue}}</span>
            </label>
            <span v-if="settable && !editing" class="Widget-icon" @click="editing=true" title="Ir para questão">
                <i class="fa fa-pencil-square"></i>
            </span>
            <button v-else-if="(questionSet != questionCounterOffset) && questionSet!=''" v-on:click="questionCountUpdate(questionSet-questionCounterOffset)"
                     class="Button Button--default Button--tiny Button--defaultBlue" title="Ir para questão">
                Ir</button>
            <div v-if="withButtons" class="btn-group-vertical">
                <button  v-on:click="questionCountUpdate(-1)"
                         class="Button Button--default btn-block Button--defaultGreenBlue" title="Anterior">
                    Anterior</button>
                <button  v-on:click="questionCountUpdate(1)"
                         class="Button Button--default btn-block Button--defaultGreenBlue" title="Próximo">
                    Próximo</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            questionCounter: {
                type: Number,
                default: 0
            },
            maxValue: {
                type: Number,
                default: 0
            },
            withButtons: {
                default: true
            },
            offset: {
                default: 0
            },
            settable:{
                default: false
            }
        },

        data() {
            return {
                localQuestionCounter: 0,
                feedbackShow: false,
                questionSet: 0,
                editing: false
            }
        },

        mounted() {
            this.localQuestionCounter = this.questionCounter
            this.questionSet = this.questionCounterOffset
        },

        computed: {
            questionCounterOffset: function() {
                return this.localQuestionCounter + this.offset
            }
        },

        watch: {
            questionCounter: function() {
                this.localQuestionCounter = this.questionCounter
            },
            questionCounterOffset(){
                this.questionSet = this.questionCounterOffset
            }
        },

        methods: {
            questionCountUpdate: function(p) {
                let target = this.questionCounterOffset + p

                if(target <= 0){
                    p = 1-this.questionCounterOffset
                }
                else if(this.questionSet > this.maxValue){
                    p = this.maxValue - this.questionCounterOffset
                }

                this.questionSet = this.questionCounterOffset

                if (this.localQuestionCounter + p < this.maxValue && this.localQuestionCounter + p >= 0) {
                    this.localQuestionCounter += p
                    this.feedbackShow = false
                    this.$emit('child-count-update', this.localQuestionCounter, this.feedbackShow)
                } else {
                    this.feedbackShow = true
                    this.$emit('child-count-update', this.localQuestionCounter, this.feedbackShow)
                }
                this.editing = false
            }
        }
    }
</script>
