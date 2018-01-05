<!--
@Component:
    graph-schedule
@Description:
    Progress bar that displays percentage complete by cicle
@CalledComponents:
    1 - graph
@ApiRoutes:
@WebRoutes:
@Props:
    allCycles       : all cycles information of user contained in firebase
    userEfficiency  : user efficiency
    pomodoro        : time of pomodoro updated 'red' or 'green'
@Constants:
    POMODORO_TIME   :  Time that a pomodoro represents
@TODO:
-->

<template xmlns:v-model="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div class="Chart">
        <graph :key="startingCycle"
                :labels     = "label"
                :data       = "dataset"
                :options    = "options"
                :height     = "250"
        >
        </graph>
    </div>
</template>

<script>

    const POMODORO_TIME = 25;

    export default {
        props:[
            'allCycles',
            'userId',
            'userEfficiency',
            'pomodoro',
            'startingCycle'
        ],
        data(){
            return {

                newEfficiency : 0,
                label       : [],
                dataset     : [],
                planned     : [],
                studied     : [],
                studiedOnDay: [],
                daysStudied : [],
                daysPlanned : [],
                acumulatedPlanned : 0,
                acumulatedStudied : 0,
                options : {
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                return data.datasets[tooltipItem.datasetIndex].label + ': ' + (tooltipItem.yLabel*60*60).toString().toHHMM();
                            }
                        }
                    },
                    scales: {
                        yAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Tempo (Horas Líquidas)',
                                fontSize:16,
                                fontStyle: 'bold',
                                fontFamily:'sans-serif'
                            },
                            ticks: {
                                beginAtZero:true,
                            }
                        }],
                        xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Dia Estudado',
                                fontSize:16,
                                fontStyle: 'bold',
                                fontFamily:'sans-serif'
                            },
                            ticks: {
                                beginAtZero:true,
                                maxTicksLimit: 10
                            }
                        }],
                    },

                },
            }
        },
        mounted(){
            this.newEfficiency = this.userEfficiency;
            this.calculateDataToGraph();
        },

        watch : {
            pomodoro(){
                let todayStudiedI = this.studied.length-1;

                this.studied[todayStudiedI] = Number(this.studied[todayStudiedI]) + (Number((POMODORO_TIME/60))*this.pomodoro)

                this.dataset = [
                    {
                        label: 'Planejado',
                        data: this.planned,
                        backgroundColor: 'rgba(235, 35, 65, 0.2)',
                        borderColor:'#eb2341',
                        lineColor: '#eb2341' ,

                    },
                    {
                        label: 'Estudado',
                        data: this.studied,
                        backgroundColor: 'rgba(41, 41, 41, 0.15)',
                        borderColor: '#292929',
                        lineColor: '#292929',
                    }
                ];
                this.$emit('child-reset-graph-click')
            },

            startingCycle(){
                this.clearGraph()
                this.calculateDataToGraph()
            }

        },

        methods:{
            clearGraph(){
                this.label       = []
                this.dataset     = []
                this.planned     = []
                this.studied     = []
                this.studiedOnDay= []
                this.daysStudied = []
                this.daysPlanned = []
                this.acumulatedPlanned = 0
                this.acumulatedStudied = 0
                this.options = {
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                return data.datasets[tooltipItem.datasetIndex].label + ': ' + (tooltipItem.yLabel*60*60).toString().toHHMM();
                            }
                        }
                    },
                    scales: {
                        yAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Tempo (Horas Líquidas)',
                                fontSize:16,
                                fontStyle: 'bold',
                                fontFamily:'sans-serif'
                            },
                            ticks: {
                                beginAtZero:true,
                            }
                        }],
                                xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Dia Estudado',
                                fontSize:16,
                                fontStyle: 'bold',
                                fontFamily:'sans-serif'
                            },
                            ticks: {
                                beginAtZero:true,
                                maxTicksLimit: 10
                            }
                        }],
                    },

                }
            },
            calculateDataToGraph(){

                let dates = Object.keys(this.allCycles);
                let nextCycleDate;
                let cycle = {};

                for(let key in dates){
                    let cycleDate = dates[key];
                    key = parseInt(key);

                    // Gets next cycle start to finish current cycle
                    if(dates[key+1] && cycleDate<this.startingCycle) {
                        nextCycleDate = DateHelper.getDateObject(dates[key + 1])
                    }
                    else {
                        nextCycleDate = new Date();

                        // ----------------------------------------------

                        cycle = this.allCycles[cycleDate]
                        let cycleStudied = cycle.cycleStudied;
                        cycleDate = DateHelper.getDateObject(cycleDate);
                        this.getDaysStudied(cycleStudied)
                        this.getDaysPlannedToStudy(cycleDate, cycle, nextCycleDate)
                    }
                }

                let today = new Date();
                let formatedToday = DateHelper.formateDate(today);

                if(this.daysPlanned[formatedToday])
                    return;

                this.acumulatedPlanned += this.newEfficiency*this.getPlannedOnDay(today,cycle)
                this.daysPlanned[formatedToday] = ((this.acumulatedPlanned/60)).toFixed(2)

                let data = {
                    userId:     this.userId,
                    efficiency: this.newEfficiency
                }
                this.$http.post(window.api+'user/update-efficiency', data);

                for(let day in this.daysPlanned){
                    this.label.push(DateHelper.formatDateToShow(day));

                    let value = this.daysPlanned[day];
                    this.planned.push(value)

                    if(this.daysStudied[day])
                        this.studied.push(this.daysStudied[day])
                    else {
                        if(this.studied.slice(-1)[0])
                            this.studied.push(this.studied.slice(-1)[0])
                        else
                            this.studied.push(0)
                    }

                }

                this.dataset = [
                    {
                        label: 'Planejado',
                        data: this.planned,
                        backgroundColor: 'rgba(235, 35, 65, 0.2)',
                        borderColor:'#eb2341',
                        lineColor: '#eb2341' ,

                    },
                    {
                        label: 'Estudado',
                        data: this.studied,
                        backgroundColor: 'rgba(41, 41, 41, 0.15)',
                        borderColor: '#292929',
                        lineColor: '#292929',
                    }
                ];

            },

            getDaysPlannedToStudy(cycleDate,cycle,nextDateLimit){
                let daysNotStudied=0;
                nextDateLimit.setHours(0,0,0,0)
                let cycleTime = cycle.cycleTime
                let dateLimit = new Date(cycleDate.valueOf());
                let userEfficiencystep = this.userEfficiency;
                let previousDayOnStudied = 0;
                let previousStudied = 0;
                // Efficiency by weight
                let maxEfficiency = 0.75
                let minEfficiency = 0.25
                let weightEfficiency = 1.2
                // Efficiency by sheet plan
                let EWMO = 0.5
                let dayB4Yield = 0.5
                dateLimit.setDate(dateLimit.getDate()+cycleTime);

                if(!(cycle.cycleStudied == 0)){

                    cycleDate = Object.keys(cycle.cycleStudied);
                    cycleDate = new Date(cycleDate[0].valueOf());
                    cycleDate.setTime(cycleDate.getTime() + cycleDate.getTimezoneOffset()*60*1000)

                }
                // Percorre todos os dias do ciclo
                for (let d = cycleDate; d <= dateLimit && d < nextDateLimit; d.setDate(d.getDate() + 1)) {
                    let hasStudied = 0;
                    let newDate = DateHelper.formateDate(d);
                    if(this.daysPlanned[newDate]) {
                        continue;
                    }
                    // dayOnStudied é o que o cara estudou no dia (acumulado). Caso ele não tenha estudado, o acumulado passa a ser o do dia anterior
                    let dayOnStudied = this.daysStudied[newDate]? this.daysStudied[newDate] : previousDayOnStudied
                    // Pega o planejado no dia (não acumulado)
                    let plannedOnDay = this.getPlannedOnDay(d,cycle)/60
                    // O estudado no dia (não acumulado) é a diferença entre o dia atual (acumulado) para o dia anterior (acumulado)
                    let studiedOnDay = dayOnStudied == 0 ? 0 : dayOnStudied - previousDayOnStudied;
                    // Proporção entre o estudado e o quanto deveria ter sido estudado no dia
                    let dayYield = plannedOnDay != 0?studiedOnDay/(plannedOnDay*userEfficiencystep):0

                    // calcula os dias não estudados
                    daysNotStudied = studiedOnDay ? 0 : daysNotStudied;
                    if (daysNotStudied<7) {
                        // Se ele não estudou por mais
                        this.acumulatedPlanned += userEfficiencystep*this.getPlannedOnDay(d,cycle);
                    }

                    this.daysPlanned[newDate] = ((this.acumulatedPlanned/60)).toFixed(2) // calc
                    userEfficiencystep = dayYield * EWMO + (1-EWMO) * userEfficiencystep;
                    if (userEfficiencystep>maxEfficiency)
                        userEfficiencystep = maxEfficiency
                    if (userEfficiencystep<minEfficiency)
                        userEfficiencystep = minEfficiency
                    dayB4Yield = dayYield;
                    previousDayOnStudied = dayOnStudied;
                    daysNotStudied++;
                }

                this.newEfficiency = userEfficiencystep
            },
            getDaysStudied: function (cycleStudied) {

                for(let studiedDate in cycleStudied){
                    let dayStudied = cycleStudied[studiedDate];
                    for(let i in dayStudied){
                        this.studiedOnDay[i] = dayStudied[i];
                        this.acumulatedStudied += dayStudied[i]*POMODORO_TIME
                    }
                    this.daysStudied[studiedDate] = (this.acumulatedStudied/60).toFixed(2);
                }
            },
            getPlannedOnDay(date,cycle){
                let weekDay = date.getDay();
                weekDay = DateHelper.getDay(weekDay)

                let availability = cycle.availability[weekDay]

                return availability

            },

        }
    }
</script>
