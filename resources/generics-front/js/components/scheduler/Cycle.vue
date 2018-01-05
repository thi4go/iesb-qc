<!--
@Component:
    completed-percentage
@Description:
    Progress bar that displays percentage complete by cicle
@CalledComponents:
    1 - pomodoro-line
    2 - completed-percentage
    3 - graph-schedule
    4 - pomodoro-table
    5 - custom-modal
@ApiRoutes:
@WebRoutes:
@Props:
    firebaseCycle   : cycle information of user available on firebase
    user            : user information
    allCycles       : information of all cicles done by the user
@Constants:
    POMODORO_TIME   :  Time that a pomodoro represents
@TODO:
    1 - Change all cycles to the current cycle
-->


<template xmlns:v-model="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div>
        <div class=" col-sm-10 u-m-t-40 u-m-b-40">
            <div class="Widget-bgWhite Widget--border">
                <div class="row">
                    <header class="Dashboard-header col-sm-12 u-m-t-40">
                        <h2 class="Widget-title Widget-title--min Widget-title--color40 u-bold u-m-b-10">Sua meta do dia:
                            <!--<span style="color: #42b983">{{dayGoalText}}</span>-->
                            <i class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip"
                               data-placement="right" title="Cada pomodoro equivale a 25 minutos de estudo líquido."></i>
                        </h2>

                    </header>
                    <div id="pomodoroDayGoal" class="Dashboard-content col-sm-12">
                        <pomodoro-line
                                :clickable      = "false"
                                :greenPomodoro  = "greenDayGoal"
                                :redPomodoro    = "redDayGoal"
                                :bluePomodoro   = "extraDayGoal"
                                :message        = "true"
                                :title             = "dayGoalText"
                        ></pomodoro-line>
                    </div>
                </div>
            </div>
            <div class="Widget-bgWhite Widget--border">
                <div class="row" v-if="dayGoal > 0">
                    <header class="Dashboard-header col-sm-12 u-m-t-10">
                        <h2 class="Widget-title Widget-title--tiny Widget-title--color40 u-bold u-m-b-10">Sugestão:
                        </h2>

                    </header>
                    <div class="Dashboard-content col-sm-12">
                        <div class="Cycle">
                            <table class="SuggestedTable u-m-b-20">
                                <tbody class="u-bold">
                                <tr v-for="s in suggestions">
                                    <td>
                                        {{subjects[s.subject]}}
                                    </td>
                                    <td>
                                        <pomodoro-line
                                                :clickable      = "false"
                                                :greenPomodoro  = "s.green"
                                                :redPomodoro    = "s.red"
                                                :bluePomodoro   = "s.blue"
                                        ></pomodoro-line>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="Widget-bgWhite Widget--border">
                <div class="row">
                    <header class="Dashboard-header col-sm-12 u-m-t-40">
                        <h2 class="Widget-title Widget-title--min Widget-title--color40 u-bold u-m-b-10">
                            Porcentagem concluída
                        </h2>

                    </header>
                    <div class="Dashboard-content col-sm-12">

                        <completed-percentage
                                :current-cycle = "firebaseCycle.cycle"
                                :cycle-studied = "currentCycleStudied"
                                :pomodoro        = "updateCompletedPercentageClick"
                                label="Percentual do seu ciclo de estudos concluído"
                                v-on:child-reset-completed-percentage = "resetPercentageClick"
                                v-if="load"
                        ></completed-percentage>
                        <page-loader v-else color="#eb2341"></page-loader>
                    </div>
                </div>


            </div>
            <div class="Dashboard-content">
                <div class="Widget u-m-b-20">
                    <div class="Widget-bgWhite Widget--border">

                        <div class="Widget-header clearfix u-m-t-40">
                            <h3 class="Widget-title Widget-title--min Widget-title--color40 u-bold">Ciclo de estudo</h3>
                        </div>
                        <pomodoro-table
                                :table-data = "dataToTable"
                                :user-id    = "userId"
                                v-on:pomodoro-msg = "updatePomodoro"
                        ></pomodoro-table>


                        <div class="col-sm-12 ">
                            <div class="Widget-header clearfix u-m-t-40">
                                <h3 class="Widget-title Widget-title--min Widget-title--color40 u-bold">Tempo de Estudo em Horas Líquidas</h3>
                            </div>
                            <div class="col-sm-12 u-m-t-10 u-m-b-10">
                                <div class="Widget-title Widget-title--tiny Widget-title--color20 u-bold u-m-b-10">Data de início:
                                </div>
                                <select class="form-control" v-model="startingCycle">
                                    <option v-for="c in cycleKeys" :value="c">{{formatDateToShow(c)}}</option>
                                </select>
                            </div>
                            <div class="col-sm-12">
                                <graph-schedule
                                        :user-id = "user.id"
                                        :all-cycles = "allCycles"
                                        :user-efficiency = "user.efficiency"
                                        :pomodoro        = "updateGraphClick"
                                        :starting-cycle  = "startingCycle"
                                        v-on:child-reset-graph-click = "resetGraphClick"
                                ></graph-schedule>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <custom-modal
                v-if        = "redDayGoal == 0"
                header      = "Meta do dia alcançada!!"
                icon        = "fa fa-thumbs-up"
                closeButton = true
                text        = "Aproveite o seu dia de descanso, mas se estiver atrasado no ciclo e disposto, estude!"
                button-text = "Ok"
        ></custom-modal>
    </div>
</template>

<script>

//    import DateHelper from "../../../../../../resources/assets/DateHelper";

    const POMODORO_TIME = 25;

    export default {
        props:[
            'firebaseCycle',
            'user',
            'allCycles',
            'dayCycle'
        ],

        data(){
            return{
                cycle               : [],
                cycleStudied        : [],
                currentCycleStudied : {},
                currentCycle        : [],
                subjects            : [],
                dataToTable         : {},
                toStudy             : {},
                suggestions         : [],
                dataToGraph         : {},
                cycleCompleted      : null,
                userId              : null,
                userEfficiency      : null,
                dataset             : [],
                dayGoal             : 0,
                userPomodoros       : 0,
                updateGraphClick    : null,
                updateCompletedPercentageClick : null,
                load                : false,
                startingCycle       : null
            }
        },

        mounted(){
            this.cycle          = this.firebaseCycle.cycle
            this.cycleStudied   = this.firebaseCycle.cycleStudied;
            let currentCycleStudied = {};
            this.startingCycle = this.dayCycle
            for(let dayStudied in this.cycleStudied){
                if(dayStudied >= this.dayCycle){
                    currentCycleStudied[dayStudied] = this.cycleStudied[dayStudied];

                }
            }

            this.currentCycleStudied = currentCycleStudied;

            this.subjects       = this.firebaseCycle.subjects
            this.userId         = this.user.id;
            this.userEfficiency         = this.user.efficiency;

            this.calculateDayGoal()
            this.calculateDataToTable()

            this.calculateSuggestion()

            this.handleResize()
            window.addEventListener('resize', this.handleResize)
            $('[data-toggle="tooltip"]').tooltip()

            this.load = true;
        },

        watch:{
            missingReds(){
                if(this.missingReds == 0){
                    this.$emit('complete-cycle')
                }
            }
        },

        computed:{
            greenDayGoal(){

                return parseInt((this.userPomodoros < this.dayGoal) ? this.userPomodoros : this.dayGoal)
            },
            redDayGoal(){
                let ret = this.dayGoal - this.greenDayGoal
                return parseInt(ret);
            },
            extraDayGoal(){
                return parseInt(this.userPomodoros - this.greenDayGoal)
            },
            dayGoalText(){
                return (parseInt(this.dayGoal)*POMODORO_TIME*60).toString().toHHMMtext();
            },
            cycleKeys(){
                return (Object.keys(this.allCycles)).reverse()
            },
            missingReds(){
                let reds = 0;
                for(let subject in this.dataToTable){
                    reds += this.dataToTable[subject].redPomodoro
                }
                return reds
            }
        },

        methods:{
            loadPercentage(){
                return
            },
            updatePomodoro(value, subjectId){
                this.updateDayGoalPomodoro(value);
                this.updateGraph(value);
                this.updateCompletedPercentage(value);
                this.updateSuggestions(value, subjectId)
            },
            resetGraphClick(){
                this.updateGraphClick = null;
            },
            resetPercentageClick(){
                this.updateCompletedPercentageClick = null
            },
            updateCompletedPercentage(value){
                this.updateCompletedPercentageClick = value;
            },
            updateGraph(value){
                this.updateGraphClick = value;
            },

            updateDayGoalPomodoro(value){
                this.userPomodoros += value
                if(this.userPomodoros < 0){
                    this.userPomodoros = 0;
                }
            },

            updateSuggestions(value, subjectId){
                for(let i in this.suggestions){
                    let s = this.suggestions[i]
                    if(s.subject == subjectId){
                        let total = s.blue + s.green
                        total += value
                        if(total < 0){
                            total = 0;
                        }
                        this.suggestions[i].green = total < s.goal ? total : s.goal
                        this.suggestions[i].red  = s.goal - s.green
                        this.suggestions[i].blue  = total > s.goal? total-s.goal : 0
                    }
                }
            },

            calculateDayGoal(){
                let day = DateHelper.formateDate(new Date())
                let date = DateHelper.getDay(new Date().getDay())

                let older = this.onOlderCycle(day)

                this.dayGoal = Math.ceil((this.firebaseCycle.availability[date]) / 25)*this.userEfficiency
                let dayCycleStudied = this.cycleStudied[day];
                for(let i in dayCycleStudied ){
                    this.userPomodoros += dayCycleStudied[i]
                }
                if(older){
                    for(let i in older.cycleStudied[day]){
                        this.userPomodoros += older.cycleStudied[day][i]
                    }
                }
            },

            onOlderCycle(day){
                let i = 0;
                for(let c in this.allCycles){
                    i++;
                };

                try{
                    let oldCycle = this.allCycles[Object.keys(this.allCycles)[i-2]]
                    if(oldCycle.cycleStudied[day])
                            return oldCycle
                }catch(e){
                        return null
                }

                return null
            },
            calculateDataToTable(){

                let tempCycleStudied = this.currentCycleStudied;
                let tempCycle = this.cycle
                let line = {};
                let tempGreenPomodorosBySubject = []
                let tempRedPomodorosBySubject = []

                for(let i in tempCycleStudied){
                    let dayStudied = tempCycleStudied[i];
                    for(let j in dayStudied) {
                        tempGreenPomodorosBySubject.push({
                            subjectId      : parseInt(j),
                            greenPomodoros : dayStudied[j]
                        })
                    }
                }

                for(let i in tempCycle){

                    let greenPomodoro = 0;
                    let greenPomodoroBySubject = tempGreenPomodorosBySubject.filter(function(value){
                        return value.subjectId == i
                    })

                    if(greenPomodoroBySubject.length > 0) {
                        for(let value of greenPomodoroBySubject) {
                            greenPomodoro += value.greenPomodoros;
                        }
                    }

                    if(greenPomodoro !== 0) {
                        tempRedPomodorosBySubject[i] = tempCycle[i] - greenPomodoro;
                        line[i] = {
                            greenPomodoro: greenPomodoro,
                            redPomodoro: tempRedPomodorosBySubject[i],
                            subjectName: this.subjects[i]
                        }
                    }
                    else {
                        tempRedPomodorosBySubject[i] = tempCycle[i];
                        line[i] = {
                            greenPomodoro: greenPomodoro,
                            redPomodoro: tempRedPomodorosBySubject[i],
                            subjectName: this.subjects[i]
                        }
                    }

                }
                this.dataToTable = line;
            },

            getGreenPomodorosByDay(pomodorosStudiedArray) {
                let count = 0;

                for(let id in pomodorosStudiedArray) {
                    count += pomodorosStudiedArray[id];
                }

                return count;
            },

            calculateSuggestion(){
                let day = DateHelper.formateDate(new Date())
                if(this.cycleStudied) {
                    if(this.cycleStudied[day]) {
                        for (let subject in this.cycle) {
                            if(this.cycleStudied[day][subject]) {
                                this.toStudy[subject] = this.cycle[subject] - (this.dataToTable[subject].greenPomodoro - this.cycleStudied[day][subject])
                            }else {
                                this.cycleStudied[day][subject] = 0
                                this.toStudy[subject] = this.cycle[subject] - this.dataToTable[subject].greenPomodoro
                            }
                        }
                    }else{
                        this.cycleStudied[day] = {}
                        for (let subject in this.cycle) {
                            this.toStudy[subject] = this.cycle[subject] - this.dataToTable[subject].greenPomodoro
                            this.cycleStudied[day][subject] = 0
                        }
                    }
                }else{
                    this.toStudy = this.cycle
                }

                let array = []

                for(let subject in this.toStudy){
                    let obj = {subjectId : subject,
                                pomodoros : this.toStudy[subject]}
                    array.push(obj)
                }

                let sorted = array.slice(0).sort((a,b) => {
                            var x = a.pomodoros; var y = b.pomodoros;
                    return ((x > y) ? -1 : ((x < y) ? 1 : 0));
                })

                let total = 0

                for(let subject in sorted) {
                    let sugg = {
                        goal: 0,
                        green: 0,
                        red: 0,
                        blue: 0,
                        subject: sorted[subject].subjectId
                    }
                    let diff = Math.floor(this.dayGoal) - total
                    if (sorted[subject].pomodoros <= 4) {
                        sugg.goal = Math.min(sorted[subject].pomodoros, diff)
                        if(this.cycleStudied) {
                            sugg.green = Math.min(sugg.goal, this.cycleStudied[day][sorted[subject].subjectId])
                            sugg.blue = sugg.green == sugg.goal? this.cycleStudied[day][sorted[subject].subjectId] - sugg.goal : 0
                        }
                        sugg.red =  sugg.goal-sugg.green
                    } else if (sorted[subject].pomodoros > 6) {
                        sugg.goal = Math.min(4, diff)
                        if(this.cycleStudied) {
                            sugg.green = Math.min(sugg.goal, this.cycleStudied[day][sorted[subject].subjectId])
                            sugg.blue = sugg.green == sugg.goal? this.cycleStudied[day][sorted[subject].subjectId] - sugg.goal : 0
                        }
                        sugg.red =  sugg.goal-sugg.green
                    } else {
                        sugg.goal = Math.min(3, diff)
                        if(this.cycleStudied) {
                            sugg.green = Math.min(sugg.goal, this.cycleStudied[day][sorted[subject].subjectId])
                            sugg.blue = sugg.green == sugg.goal? this.cycleStudied[day][sorted[subject].subjectId] - sugg.goal : 0
                        }
                        sugg.red =  sugg.goal-sugg.green
                    }

                    this.suggestions.push(sugg)

                    total += sugg.goal
                    if(total >= Math.floor(this.dayGoal-1)){
                        break;
                    }
                }

            },

            handleResize (event) {
                let width = document.documentElement.clientWidth;
                if(width > 950){
                    this.progressBarSize = 300;
                }else{
                    this.progressBarSize = 200;
                }
            },

            formatDateToShow(date){
                return DateHelper.formatDateToShow(date)
            }

        },

    }
</script>
