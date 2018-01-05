<!--
@Component:
    completed-percentage
@Description:
    Progress bar that displays percentage complete by cicle
@CalledComponents:
    1 - vue-radial-progress
@ApiRoutes:
@WebRoutes:
@Props:
    currentCycle    : current circle number
    cycleStudied    : all the studied info related to the cicle
    pomodoro        : pomodoro clicked 'green' or 'red'
@Constants:
@TODO:
-->


<template xmlns:v-model="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div>
        <div class="Progress u-m-b-10">
            <p class="Progress-legend">{{label}}</p>
            <div class="Progress-bar Progress-bar--color13 u-m-b-5">
                <div class="Progress-loading Progress-loading--color30"
                     role="progressbar"
                     v-bind:aria-valuenow="cycleCompleted*100"
                     v-bind:style="'width:'+ cycleCompleted * 100 +'%'"
                     aria-valuemin="0" aria-valuemax="100"
                ></div>
            </div>
            <p class="Progress-count">
                {{(cycleCompleted*100).toFixed(0)}}%</p>

        </div>
    </div>
</template>
<script>

    import RadialProgressBar from "vue-radial-progress";

    export default {
        props:[
            'currentCycle',
            'cycleStudied',
            'pomodoro',
            'label'
        ],
        mounted(){
            this.calculateCompletedPercentage();
        },
        data(){
            return{
                pomodoroTotal   : 0,
                pomodoroStudied : 0,
                progressBarSize : 300,
                cycleCompleted  : 0,
            }
        },
        watch : {
            pomodoro(){

                this.pomodoroStudied += this.pomodoro;

                this.cycleCompleted = this.pomodoroStudied / this.pomodoroTotal;
                this.$emit('child-reset-completed-percentage')
            }
        },
        components:{
            RadialProgressBar
        },
        methods : {
            calculateCompletedPercentage(){
                for(let i in this.currentCycle){
                    this.pomodoroTotal += this.currentCycle[i];
                }
                for(let i in this.cycleStudied){
                    let dayStudied = this.cycleStudied[i];
                    for(let j in dayStudied)
                        this.pomodoroStudied += dayStudied[j];
                }

                this.cycleCompleted = this.pomodoroStudied/this.pomodoroTotal;
            },

        }


    }
</script>