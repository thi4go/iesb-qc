<!--
@Component:
    pomodoro-line
@Description:
    Renders pomodoros per line according to subjects.
@CalledComponents:
    1 - pomodoro
@ApiRoutes:
    contests/get-contests
@WebRoutes:
@Props:
    greenPomodoro   : number of green pomodoros associated to subject
    redPomodoro     : number of red pomodoros associated to subject
    subjectId       : id of the associated line subject
    userId          : userId
    clickable       :
    message         :
@Constants:
@TODO:
-->

<template xmlns:v-model="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div class="Cycle Widget-content Widget--hidden">
        <div v-if="updated" class="pomodoroList">

            <li v-for="m in greenPomodoro">
                <pomodoro
                        v-on:updated-color = "pomodoroClick"
                        v-on:write-firebase = "pomodoroWrite"
                        :subject-id = "subjectId"
                        :user-id    = "userId"
                        color   = "green"
                        :clickable  = "clickable"
                        :pomodoro-number = "m"
                        :data-bound.sync      ="dataBound"
                ></pomodoro>
            </li><li v-for="n in redPomodoro">
                <pomodoro
                        v-on:updated-color = "pomodoroClick"
                        v-on:write-firebase = "pomodoroWrite"
                        :subject-id = "subjectId"
                        :user-id    = "userId"
                        color   = "red"
                        :clickable  = "clickable"
                        :pomodoro-number = "greenPomodoro+n"
                        :data-bound.sync      ="dataBound"
                ></pomodoro>
            </li><li v-for="n in bluePomodoro">
            <pomodoro
                    :subject-id = "subjectId"
                    :user-id    = "userId"
                    color   = "blue"
                    :clickable  = "false"
                    :pomodoro-number = "greenPomodoro+redPomodoro+n"
                    :data-bound      ="false"
            ></pomodoro>
        </li>
        </div>
    </div>
</template>

<script>

    export default {
        props:[
            'greenPomodoro',
            'redPomodoro',
            'bluePomodoro',
            'subjectId',
            'userId',
            'clickable',
            'message',
            'dataBoundScope'
        ],

        data(){
            return {
                updated: false,
                dataBound: false,
            }
        },
        mounted(){
            this.updated =  true
        },

        methods:{
            pomodoroClick :  function (number) {
                this.dataBound = true
                let scope = this;
                this.$nextTick(() => {
                    if(number == 1 && scope.greenPomodoro == 1){
                        number = 0
                    }
                    scope.$emit('updated-color', number, scope.subjectId)
                })
            },
            pomodoroWrite(){
                this.dataBound = false
            }
        },
        computed:{

        },
        watch:{
            redPomodoro: function (){
                this.updated =  false
                this.updated =  true
            },

            greenPomodoro: function (){
                this.updated =  false
                this.updated =  true
            },

            dataBoundScope(){
                this.dataBound = this.dataBoundScope
            }
        },
    }
</script>
