<!--
@Component:
    question-paginate
@Description:
    Component that manages question.
@CalledComponents:
    1 - question-shower
@ApiRoutes:
    questions/by-{generic}/{id},{currentPagination}?token={token}
    questions/by-{generic}-user-nr/{id}/{currentPagination}/{userId}?token={token}
    questions/by-{generic}-user/{id}/{currentPagination}/{userId}?token={token}
    questions/by-{generic}-not-reviewed/{id},{currentPagination}?token={token}
@WebRoutes:
@Props:
    questionCounter : current question being handled
    questions       : JSON list of questions being handled
    userId          : user id
@TODO:
-->

<template>
    <div class="Widget u-noPadding">
        <div class="Widget-bgWhite ">
            <div class="Widget-header">
            </div>
            <question-shower
                    :question       = "questions[localQuestionCounter]"
                    :with-buttons   = "true"
                    :userId         = "userId"
                    :user_level     = "user_level"
                    :title          = "title"
                    @resolution-show = "pause"></question-shower>
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
            questions: {
                type: [Object, Array]
            },
            userId:{},
            title:{},
            user_level:{
              type: Number,
              default: 2
            }
        },

        data() {
            return {
                maxValue: 0,
                localQuestionCounter: 0
            }
        },

        mounted() {
            this.localQuestionCounter = this.questionCounter
            this.maxValue             = this.questions.length
        },

        watch: {
            questionCounter: function() {
                this.localQuestionCounter = this.questionCounter
            }
        },

        methods: {

            pause(value){
                this.$emit('pause-timer', value)
            }

        }
    }
</script>
