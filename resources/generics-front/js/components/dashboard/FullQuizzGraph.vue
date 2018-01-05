<template xmlns:v-model="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div class="row">
        <div v-if="loading">
            <page-loader color="#eb2341"></page-loader>
        </div>
        <div v-else>
            <header class="Dashboard-header col-sm-12 u-m-t-20">
                <h2 class="Dashboard-title Dashboard-title--color30">Chance de aprovação</h2>
                <div class="alertQuiz"></div>
            </header>
            <div class="Dashboard-content col-sm-12">
                <div v-if="contestSelected.chanceOfApproval" class="Card-content">
                    <div class="Progress u-m-b-10">
                        <p class="Progress-legend">Sua Chance</p>
                        <div class="Progress-bar Progress-bar--color13 u-m-b-5">
                            <div class="Progress-loading Progress-loading--color30"
                                 role="progressbar"
                                 v-bind:aria-valuenow="(contestSelected.chanceOfApproval* 100)"
                                 v-bind:style="'width:'+ contestSelected.chanceOfApproval * 100 +'%'"
                                 aria-valuemin="0" aria-valuemax="100"
                            ></div>
                        </div>
                        <p class="Progress-count">
                            {{parseFloat(contestSelected.chanceOfApproval * 100).toFixed(0)}}%</p>

                    </div>

                </div>
            </div>
        </div>
        <header class="Dashboard-header col-sm-12 u-m-t-20">
            <h2 class="Dashboard-title Dashboard-title--color30">Seu Desempenho</h2>
        </header>
        <div class="Dashboard-content col-sm-12">
            <graph
                    :data       = "dataset"
                    :options    = "options"
                    :labels     = "label"
                    :height      = "100"
            >
            </graph>
        </div>
    </div>

</template>

<script>

    import BounceLoader from 'vue-spinner/src/BounceLoader.vue';

    export default {
        props : [
            'allQuizzes',
            'userId'
        ],
        components:{
            BounceLoader
        },
        data(){
            return {
                loading           : true,
                subjectsCourses   : [],
                contestSelected   : {},
                checkedContests   : [],
                contests          : [],
                contestIdSelected : 0,
                chanceOfApproval  : null,
                contestName       : null,
                thetasInDate      : {},
                label_aux         : [],
                averageThetas     : [],
                dataset           : [],
                label             : [],
                options: {
                    scales: {
                        yAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Conhecimento (%)',
                                fontSize:16,
                                fontStyle: 'bold',
                                fontFamily:'sans-serif'
                            },
                            ticks: {
                                max:100,
                                beginAtZero:true
                            }
                        }],
                        xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Dia do Simulado',
                                fontSize:16,
                                fontStyle: 'bold',
                                fontFamily:'sans-serif'
                            },
                            ticks: {
                                maxTicksLimit: 20,
                                beginAtZero:true
                            }
                        }],
                    },

                }
            }
        },

        mounted() {
            let scope = this;
            this.getContests().then(()=>{
                let allQuizzes = scope.allQuizzes
                for(let subjectId in allQuizzes){
                    let subjectDates = allQuizzes[subjectId];
                    for(let date in subjectDates) {
                        if(subjectDates[date].hasOwnProperty('thetas')) {
                            scope.label_aux.push(date);
                            scope.thetasInDate[date] = subjectDates[date].thetas;
                            date = scope.transformDate(date);
                            scope.label.push(date);
                        }

                    }
                }
                // sorts the label attributes
                scope.label = scope.label.sort();
                scope.loading = false;
                scope.calculateNewGraphData(scope.contestIdSelected);});
        },
        methods : {
            transformDate(date){
                let aux = date.split('-');
                let timeaux = aux[3].split(':');
                if (timeaux[0] < 10) {
                    timeaux[0] = '0' + timeaux[0];
                }
                if (timeaux[1] < 10) {
                    timeaux[1] = '0' + timeaux[1];
                }
                date= aux[0]+ '-'+aux[1]+ '-'+aux[2] + '-' + timeaux.join(':');
                return date;
            },
            distransformDate(date){
                let aux = date.split('-');
                let timeaux = aux[3].split(':');

                if (timeaux[0] < 10) {
                    timeaux[0] =parseInt(timeaux[0]);
                }
                if (timeaux[1] < 10) {
                    timeaux[1] = parseInt(timeaux[1]);
                }
                date= aux[0]+ '-'+aux[1]+ '-'+aux[2] + '-' + timeaux.join(':');
                return date;
            },
            getContests(){
                return new Promise( (resolve, reject) => {
                    let scope = this;
                    scope.$http.get(window.api + 'contests/get-contests-with-approvement-probability/' + scope.userId).then(response => {
                        let data = response.body.data;
                        scope.contests = data.contests;
                        scope.contests = scope.sortByName(scope.contests)}).then(()=>{

                        scope.$http.get(window.api + 'contests/get-contests').then(response => {
                            scope.checkedContests = response.body.data
                            try {
                                scope.checkedContests = scope.sortByName(scope.checkedContests)
                                scope.contestIdSelected = scope.checkedContests[0].idcontest
                            } catch (e) {
                                reject(e)
                            }
                            resolve(true)
                        })
                    }).catch(e=>{reject(e)})
                })
            },
            calculateNewGraphData(id){
                let scope = this;
                for (let contestAux of scope.contests){
                    if(contestAux.idcontest == id){
                        scope.contestSelected = contestAux;
                    }
                }
                let data = {
                    dateThetas : this.thetasInDate,
                    contestId : id
                };
                this.$http.post(window.api+'contests/get-contest-approvement-probability-full-dash',data).then(response =>{
                    let dateAverageTheta = {};

                    let data = response.body.data;
//  This function orders dateAverageTheta by date, ascending
                    for(let i in this.label){
                        let date = this.distransformDate(this.label[i]);
                        dateAverageTheta[date] = data.dateAverageTheta[date];
                    }
                    this.drawNewGraph(dateAverageTheta,data.contest);
                })

            },

            drawNewGraph(dateAvgTheta,contest){
                let avgTheta = [];
                let barrier  = [];

                for(let date in dateAvgTheta){
                    avgTheta.push((window.Calculator.normalcdf(dateAvgTheta[date])*100).toFixed(2));
                    barrier.push((contest.barrier*100).toFixed(1));
                }

                this.dataset = [
                    {
                        label: 'Você',
                        data: avgTheta,
                        fill:false,
                        borderColor: '#292929',
                    },
                    {
                        label: 'Aprovados',
                        data: barrier,
                        fill:false,
                        borderColor: '#eb2341',
                        borderDash: [20, 30],
                        radius:0,

                    }
                ];
                this.loading = false;
            },
            sortByName(array){
                return array.slice(0).sort((a,b) => {
                            var x = a.name; var y = b.name;
                            return ((x < y) ? -1 : ((x > y) ? 1 : 0));
                        })
            }
        }

    }


</script>
