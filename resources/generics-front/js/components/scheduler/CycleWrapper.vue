<!--
@Component:
    cycle-wrapper
@Description:
    Progress bar that displays percentage complete by cicle
@CalledComponents:
    1 - side-wizard
    2 - landing-control
    3 - objective
    4 - availability
    5 - select-subject
    6 - cycle
@ApiRoutes:
@WebRoutes:
    /dashboard/controle
@Props:
@Constants:
@TODO:
    1 - Show tooltips
-->

<template xmlns:v-model="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div class="container u-m-t-30">
        <custom-modal
                v-if        = "showNewCycleModal"
                header      = "Uma nova semana, um novo ciclo!"
                closeButton = true
                text        = "Seus pomodoros serão zerados para que você possa estudar mais! Bons estudos!"
                button-text = "Fechar"
                v-on:close  = "resetCycle"
        ></custom-modal>
        <custom-modal
                v-else-if   = "completeCycle"
                header      = "Parabéns! Você completou o ciclo!"
                closeButton = true
                text        = "Seus pomodoros serão zerados para que você possa estudar mais! Bons estudos!"
                button-text = "Fechar"
                v-on:close  = "resetCycle"
        ></custom-modal>

        <div v-if="loading" style="margin-top: 10em">
            <page-loader color="#eb2341"></page-loader>
        </div>

        <div v-else>
            <side-wizard
                    :tab                   = "controlStep"
                    v-if                   = "controlStep > 0"
                    :has-cycle             = "hasCycle"
                    :return-to-cycle         = "returnToCycle"
                    v-on:child-update-step = "updateStep"
                    v-on:child-reset-cycle = "resetCycle"
            ></side-wizard>
            <div v-if="controlStep == 0" >

                <div style="margin-top: 70px">
                    <div class="col-sm-12 u-m-t-30">
                        <div class="col-sm-3">
                            <button v-on:click="controlStep += 1" class="Button Button--default btn-block Button--defaultBlueFull"> Criar Plano </button>
                        </div>
                        <landing-control
                                :firebase-cycle = "firebaseCycle"
                                :all-cycles     = "allFirebaseCycle"
                        ></landing-control>

                    </div>
                </div>

            </div>
            <div v-if="controlStep == 1">
                <objective
                        :user-id               = "userId"
                        v-on:child-update-step = "updateStep"
                ></objective>
            </div>

            <div v-else-if="controlStep == 2">
                <availability
                        v-on:child-update-availability = "updateStep"
                ></availability>
            </div>

            <div v-else-if="controlStep == 3">
                <select-subject
                        :user-id                    = "userId"
                        :contest-id                 = "contestId"
                        :total-time                 = "totalTime"
                        v-on:child-update-step      = "updateStep"
                ></select-subject>
            </div>

            <div v-else-if="controlStep == 4">
                <cycle
                        :firebase-cycle             = "firebaseCycle"
                        :all-cycles                 = "allFirebaseCycle"
                        :dayCycle                   = "dayCycle"
                        :user                       = "user"
                        v-on:child-update-step      = "updateStep"
                        v-on:complete-cycle         = "completeCycle = true">
                </cycle>
            </div>
        </div>

    </div>
</template>

<script>

//    import DateHelper from "../../../../../../resources/assets/DateHelper";
//    import firebaseSchedule from '../../firebase/schedule'
    const CYCLE_STEP=4;
    export default {
        props:[
            'user'
        ],
        data(){

            return{
                loading             : true,
                hasCycle            : false,
                controlStep         : 1,
                objective           : [],
                availability        : [],
                subjectsId          : [],
                totalTime           : [],
                dataToFirebase      : [],
                goal                : [],
                cycle               : [],
                subjects            : [],
                cycleTime           : null,
                contestId           : null,
                firebaseCycle       : [],
                allFirebaseCycle    : [],
                userId              : null,
                dayGoal             : 0,
                showNewCycleModal   : false,
                dayCycle            :0,
                returnToCycle       : false,
                completeCycle       : false

            }

        },
        mounted(){
            let scope = this;
            this.userId = this.user.id

            let ref = firebaseSchedule.ref('/users/' + this.userId + '/schedule/').limitToLast(1);
            let allCyclesRef = firebaseSchedule.ref('/users/' + this.userId + '/schedule/');


            ref.once('value',function(snapshot){
                if(snapshot.val() !== null){
                    let key = Object.keys(snapshot.val())[0];
                    scope.firebaseCycle = snapshot.val()[key];
                    scope.dayCycle = key;
                    scope.checkCycleTime(key,scope.firebaseCycle.cycleTime);
                    scope.controlStep = 4;
                }
                scope.loading = false;
            })

            allCyclesRef.once('value',function(snapshot){
                scope.allFirebaseCycle = snapshot.val();
            })
        },

        methods: {
            checkCycleTime(date, cycleTime){
                let timePassed = DateHelper.checkCycleTime(date, cycleTime);
                if (timePassed) {
                    this.showNewCycleModal = true;
//                    this.resetCycle();
                }
            },
            updateStep(data, amt){
                if(this.controlStep + amt == 4){
                    this.returnToCycle = false;
                    this.loadDataFromFirebase()
                }
                switch (this.controlStep) {

                    case 1:

                        this.contestId = data.contest
                        this.goal = {
                            contest: data.contest,
                            date: data.date
                        }
                        this.controlStep += amt;

                        break;

                    case 2:
                        this.totalTime = data.totalTime
                        this.availability = data;
                        delete this.availability.totalTime;
                        this.controlStep += amt;
                        break;

                    case 3:

                        if ((Object.keys(data)).length === 0) {
                            this.controlStep += amt
                            break;
                        }

                        this.subjectsId = data.subjectsId
                        let dataToApi = {
                            userId: parseInt(this.userId),
                            totalTime: parseInt(this.totalTime),
                            subjectsId: this.subjectsId,
                            contestId: this.contestId
                        }

                        let scope = this;

                        this.$http.post(window.api + "schedule/calculateSchedule", dataToApi).then(response => {

                            scope.cycle = response.body.data.cycle;
                            scope.subjects = response.body.data.subjects;
                            scope.cycleTime = response.body.data.cycleTime;

                            let dataToFirebase = {
                                goal: scope.goal,
                                cycle: scope.cycle,
                                subjects: scope.subjects,
                                cycleTime: scope.cycleTime,
                                cycleStudied: 0,
                                availability: scope.availability
                            }

                            scope.firebaseCycle = dataToFirebase

                            scope.writeDataToFirebase(dataToFirebase);
                            scope.controlStep += amt;

                            window.location.reload(false);
                        })
                        break;

                    case 4:
                        this.returnToCycle = true;
                        this.controlStep += amt;
                        break;
                }
            },

            writeDataToFirebase: function (dataToFirebase) {
                let userId = this.userId;

                let timeNow = new Date();
                let today = DateHelper.formateDate(timeNow);

                firebaseSchedule.ref('users/' + userId + '/schedule/' + today).set(dataToFirebase)

                return true;
            },
            resetCycle: function () {
                let timeNow = new Date();
                let today = DateHelper.formateDate(timeNow);
                let scope = this;
                for (let day in scope.firebaseCycle.cycleStudied) {
                    if (day == today) {
                        scope.firebaseCycle.cycleStudied[day] = 0;
                    }
                }
//                scope.firebaseCycle.cycleStudied[this.dayCycle] = 0;
                this.writeDataToFirebase(this.firebaseCycle).then(window.location.assign('/dashboard/controle'))
            },
            loadDataFromFirebase(){
                let scope = this;
                scope.loading = true
                let ref = firebaseSchedule.ref('/users/' + this.userId + '/schedule/').limitToLast(1);
                let allCyclesRef = firebaseSchedule.ref('/users/' + this.userId + '/schedule/');


                ref.once('value',function(snapshot){
                    if(snapshot.val() !== null){
                        let key = Object.keys(snapshot.val())[0];
                        scope.firebaseCycle = snapshot.val()[key];
                        scope.dayCycle = key;
                        scope.checkCycleTime(key,scope.firebaseCycle.cycleTime);
                    }
                    scope.loading = false;
                })

                allCyclesRef.once('value',function(snapshot){
                    scope.allFirebaseCycle = snapshot.val();
                })
            }
        }

    }
</script>
