<!--
@Component:
    quiz-graph
@Description:
    Quiz related graph.
@CalledComponents:
    1 - graph
@ApiRoutes:
    contests/get-contests-with-approvement-probability/{userId}
@WebRoutes:
@Props:
    allSubjectQuizzes   : list with all subject quizes
    userId              : user id
    token               : user authentication token
@TODO:
    1 - Receive token and use it
-->

<template xmlns:v-model="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div class="Dashboard-content col-sm-12">
        <div class="Widget">
            <header class="Feedback-header Feedback-header--color40 col-sm-12 u-m-t-20 u-m-b-10">
                <h2>Chance de Aprovação</h2>
            </header>
            <div class="Card Card--simulate Card--simulatePainel">
                <div class="Card-header u-m-b-10">
                    <!--<div v-if="contests">-->
                        <!--<select v-on:change="drawNewGraph(contestIdSelected)"-->
                                <!--v-model="contestIdSelected"-->
                                <!--class="Form-select form-control">-->
                            <!--<option disabled value=0>Selecione um concurso</option>-->
                            <!--<option v-for="contest in contests" v-if="contest.checked==1" v-bind:value="contest.idcontest">-->
                                <!--{{contest.name}}-->
                            <!--</option>-->
                        <!--</select>-->
                    <!--</div>-->
                </div>
                <div v-if="contestIdSelected!=''" class="Card-content">
                    <div class="Progress u-m-b-10">
                        <p class="Progress-legend">Sua Chance de Aprovação</p>
                        <div class="Progress-bar Progress-bar--color13 u-m-b-5">
                            <div class="Progress-loading Progress-loading--color30"
                                 role="progressbar"
                                 v-bind:aria-valuenow="chanceOfApproval"
                                 v-bind:style="'width:'+ chanceOfApproval +'%'"
                                 aria-valuemin="0" aria-valuemax="100"
                            ></div>
                        </div>
                        <p class="Progress-count">
                            {{parseFloat(chanceOfApproval).toFixed(0)}}%</p>

                    </div>

                </div>
            </div>
            <div class="Widget-bgWhite Widget--border Widget-padding">
                <graph
                        :labels  = "labels"
                        :data    = "dataset"
                        :options = "options"
                >
                </graph>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props : [
            'allSubjectQuizzes',
            'userId',
            'token',
            'title'
        ],

        mounted() {
            this.getContests();

            for(let key in this.allSubjectQuizzes) {

                this.thetas.push(this.allSubjectQuizzes[key].theta)
                let tempKey = DateHelper.formatDateToShow(key);
                this.labels.push(tempKey);

            }

        },
        data(){
            return{
                contests          : [],
                thetas            : [],
                labels            : [],
                dataset           : [],
                chanceOfApproval  : null,
                contestName       : null,
                contestIdSelected : '',
                options : {
                    scales: {
                        yAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Proficiência (%)',
                                fontSize:16,
                                fontStyle: 'bold',
                                fontFamily:'sans-serif'
                            },
                            ticks: {
                                beginAtZero:true,
                                max:100
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
                                beginAtZero:true
                            }
                        }],
                    },

                }
            }
        },

        methods:{
            getContests(){
                let scope = this;
                this.$http.get(window.api + 'contests/get-contests-with-approvement-probability/'+this.userId).then(response=> {
                    let data = response.body.data;
                    this.contests  = data.contests;
                    this.$http.get(window.api+'contests/get-contests').then(response=>{
                         let checkedContests = response.body.data
                        try{
                            this.contestIdSelected=checkedContests[0].idcontest
                            this.drawNewGraph(this.contestIdSelected)
                        }catch(e){

                        }
                    })
                })
            },
            drawNewGraph(contestId){

                let contest,testTempProfficiency = [];
                for (let contestAux of this.contests){
                    if(contestAux.idcontest == contestId){
                        contest = contestAux;
                        break
                    }
                }
                this.chanceOfApproval = contest.chanceOfApproval*100;
                this.contestName = contest.name;

                for(let i=0;i<this.labels.length;i++){
                    testTempProfficiency.push(contest.barrier*100);
                }

                this.dataset = [
                    {
                        label: 'Sua Proficiência',
                        data: this.thetas,
                        backgroundColor: 'rgba(41, 41, 41, 0.15)',
                        borderColor: '#292929',
                        lineColor: '#292929',
                    },
                    {
                        label: 'Corte',
                        data: testTempProfficiency,
                        fill:false,
                        borderColor: '#eb2341',
                        borderDash: [20, 30],
                        radius:0,

                    }
                ];

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
