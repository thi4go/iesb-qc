<!--
@Component:
    pomodoro
@Description:
    Red or green promodoro display. Updates firebase according to marked pomodoro.
@CalledComponents:
@ApiRoutes:
    contests/get-contests
@WebRoutes:
@Props:
    subjectId       : all cycles information of user contained in firebase
    userId          : user id
    clickable       : flag to set pomodoro clickavle or not
    color        : color of the pomodoro(green, red or blue)
    pomodoroNumber  : id number of the pomodoro
    dataBound       : if the actions on the pomodoro should update firebase
@Constants:
@TODO:
-->

<template xmlns:v-model="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <a href="#" v-if="clickable">
        <li v-on:click="pomodoroClick"  class="PomodoroList-item">
            <span
                    v-bind:class="{ 'PomodoroList-icon--danger': color=='red', 'PomodoroList-icon--success' : color=='green', 'PomodoroList-icon--extra' : color=='blue'}"
                    class="PomodoroList-icon  Icon Icon--pomodoroBefore">
            </span>
        </li>
    </a>
    <a v-else>
        <li class="PomodoroList-item">
            <span
                    v-bind:class="{ 'PomodoroList-icon--danger': color=='red', 'PomodoroList-icon--success' : color=='green', 'PomodoroList-icon--extra' : color=='blue'}"
                    class="PomodoroList-icon  Icon Icon--pomodoroBefore">
            </span>
        </li>
    </a>
</template>

<script>
//    import DateHelper from "../../../../../../resources/assets/DateHelper";
//    import firebaseSchedule from '../../firebase/schedule'

    export default {
        props:{
            subjectId: {
            },
            userId: {
            },
            clickable: {
                default: true
            },
            color: {
                default: 'red'
            },
            pomodoroNumber: {
            },
            dataBound:{
                default: false
            }
        },

        data(){
            return{
            }
        },

        mounted(){
        },

        methods:{

            pomodoroClick(event){
                if (event) event.preventDefault()

                if(!this.clickable)
                    return

                this.$emit('updated-color', this.pomodoroNumber)

            },

            writeStudiedPomodoro(){
                let number;
                let scope = this;

                if(this.color == 'red')
                    number = 1;
                else if(this.color == 'green')
                    number = -1;

                let today        = new Date();
                let todayDateFormated = DateHelper.formateDate(today);

                let ref = firebaseSchedule.ref('/users/' + this.userId + '/schedule/').limitToLast(1);

                ref.once('value', function(snapshot) {
                    let key          = Object.keys(snapshot.val());
                    let values       = snapshot.val()[key];
                    let cycleStudied = values.cycleStudied;

                    let studiedRef = firebaseSchedule.ref('/users/' +
                        scope.userId +
                        '/schedule/' +
                        key +
                        '/cycleStudied/' +
                        todayDateFormated + '/' +
                        scope.subjectId
                    );

                    if(cycleStudied[todayDateFormated] === undefined) {
                        studiedRef.transaction(function(current_value) {
                            if(current_value == null)
                                    return 1
                            return current_value + number;
                        });
                    }
                    else if(cycleStudied[todayDateFormated][scope.subjectId] === 0 && number === -1){

                        for (let i in cycleStudied) {
                            let otherStudiedDay = firebaseSchedule.ref('/users/' +
                                scope.userId +
                                '/schedule/' +
                                key +
                                '/cycleStudied/' +
                                i + '/' +
                                scope.subjectId
                            );
                            if(otherStudiedDay) {
                                otherStudiedDay.transaction(function (current_value) {
                                    return current_value + number;
                                });
                                break;
                            }
                        }

                    }
                    else {
                        studiedRef.transaction(function(current_value) {
                            return current_value + number;
                        });
                    }

                });

                this.$emit('write-firebase')
            }

        },
        beforeDestroy(){
            if(this.dataBound) {
                this.writeStudiedPomodoro()
            }
        }

    }
</script>
