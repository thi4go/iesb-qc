<!--
@Component:
    question-feedback
@Description:
    Table that shows feedback of questions resolved by user. The performance that shows
    a graph and the feedback table, and the review table shows the resolved questions
    resolution and feedback.
@CalledComponents:
    1 - graph
    2 - question-feedback-table
    3 - page-loader
@ApiRoutes:
@WebRoutes:
@Props:
    tableData : data to be displayed in table
@TODO:
    1 - Display resolved questions feedback
    2 - Add tooltips on graph
-->

<template>
<main class="Main">
      <section class="Dashboard Dashboard--section u-m-t-40 u-m-b-20">
        <div class="container">
          <div class="row Widget u-noPadding Widget--border Widget--noRadiusBottom Widget-padding">
            <!-- SUBJECT/TOPIC SELECTOR -->
              <div class="container col-sm-4">
                <div class="row Dashboard-header u-m-b-20">
                  <h2 class="Dashboard-title Dashboard-title--color30 pull-left">
                      Selecione <span v-if="subject.idsubject != 0" >o Assunto</span><span v-else>a Disciplina</span>
                      <button type="button" class="Button Button--popover" title="Selecione a disciplina para recalcular suas estatísticas de acerto e erro.">?</button>
                  </h2>
                </div>
                <div class="row Dashboard-content" style="height: 47%; overflow:auto;">
                    <div class="input-group">
                        <label class="input-group-addon">
                        <input v-on:click="updateStatisticGraph" id="selected-1" v-model="selectedIdTopic" name="selected" type="radio" :value="0">
                        </label>
                        <label class="form-control" for="selected-1">
                        <b>Todos</b>
                        </label>
                    </div>
                    <div v-for="(topic, i) in topics" class="input-group">
                        <label v-if="subject.idsubject == 0" class="input-group-addon">
                            <input v-on:click="updateStatisticGraph" :id="'selected-'+(i+2)" v-model="selectedIdTopic" name="selected" type="radio" :value="topic.idsubject">
                        </label>
                        <label class="input-group-addon" v-else>
                            <input v-on:click="updateStatisticGraph" :id="'selected-'+(i+2)" v-model="selectedIdTopic" name="selected" type="radio" :value="topic.idtopic">
                        </label>
                        <label v-if="subject.idsubject == 0" class="form-control" :for="'selected-'+(i+2)" style="white-space: nowrap;font-weight: normal">
                            {{topic.subject_name}}
                        </label>
                        <label v-else class="form-control" :for="'selected-'+(i+2)" style="white-space: nowrap;font-weight: normal">
                            {{topic.topic_name}}
                        </label>
                    </div>
                </div>
              </div>
              <!-- STATISTIC GRAPH -->
              <div class="container col-sm-7 col-sm-offset-1">
                  <div class="row Dashboard-header u-m-b-20">
                      <h2 class="Dashboard-title Dashboard-title--color30 pull-right">
                          Seu relatório de desempenho
                          <button type="button" class="Button Button--popover" title="O Acerto Líquido desconsidera as questões corretas em virtude de chute.">?</button>
                      </h2>
                  </div>
                  <div class="row Dashboard-content">
                      <div class="Widget">
                          <div class="Widget-bgWhite Widget--border Widget-padding">
                              <div v-if="!noDataAvailable">
                                  <graph
                                          v-if     = "!loading"
                                          :labels  = "graphLabels"
                                          :data    = "graphData"
                                          :options = "options"
                                          style="height: auto; width: 100%"
                                  />
                                  <div v-else style="margin:0 auto;">
                                      <page-loader></page-loader>
                                  </div>
                              </div>
                              <div v-else class="text-center">
                                  Resolva questões desse assunto, gere suas estatísticas e acompanhe sua evolução !<br><br>
                                  <a v-if="!selectedIdTopic"
                                     :href="'/dashboard/questoes?status=1&ids='+subject.idsubject+'&idt='+selectedIdTopic+'&startYear=2012&endYear=2017&generic=subject&keyWord='"
                                     class="Button Button--tiny Button--default Button--defaultBlue" title="Resolver Questões">
                                      Resolver Questões
                                  </a>
                                  <a v-else
                                     :href="'/dashboard/questoes?status=1&ids='+subject.idsubject+'&idt='+selectedIdTopic+'&startYear=2012&endYear=2017&generic=topic&keyWord='"
                                     class="Button Button--tiny Button--default Button--defaultBlue" title="Resolver Questões">
                                      Resolver Questões
                                  </a>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
        </div>
      </section>

      <!-- DATA TABLE STATISTICS -->
      <section class="Dashboard Dashboard--section">
        <div class="container">
          <div class="row">
            <header class="Dashboard-header col-sm-12 u-m-b-20">
              <h2 class="Dashboard-title Dashboard-title--color40">Todas as Tentativas </h2>
            </header>
            <div class="Dashboard-content col-sm-12 u-m-b-40">
              <div class="Widget">
                <div v-if = "!loading" class="Widget-bgWhite Widget--border Widget-padding">
                  <div v-if="!noDataAvailable" class="Widget-footer text-center">
                      Última Tentativa: {{lastAttempt.corrects}}/{{lastAttempt.total}}
                      <hr></hr>
                      <question-feedback-table
                            :table-data = "graphTableData"
                      />
                    <a href="/dashboard/filtro" class="Button Button--tiny Button--default Button--defaultBlue" title="Voltar para o início">Voltar para o início</a>
                  </div>
                  <div v-else class="Widget-footer text-center">
                      <a href="/dashboard/filtro" class="Button Button--tiny Button--default Button--defaultBlue" title="Voltar para o início">Voltar para o início</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

    </main>


</template>




<script>
//    import FirebaseUserQuestions from '../../firebase/user-questions'
//    import DateHelper from "../../../../../../resources/assets/DateHelper";

	export default {

		props: {
            iduser: {
                type: Number
            },
            subject: {
                type: [Object, Array]
            },
            topics: {
                type: [Object, Array]
            },
            idtopic: {
                type: Number
            }
		},

		data() {
			return {
				graphLabels     : [],
				graphData       : [],
                graphTableData  : [],
                liquidScore     : [],
                loading         : true,
                noDataAvailable : false,
                lastAttempt     : [],
                selectedIdTopic : 0,
                options     : {
                    scales: {
                        yAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Acerto Líquido (%)',
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
                                labelString: 'Tentativas',
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

		mounted() {
            if (!this.subject.idsubject) {
                this.subject.idsubject = 0;
                this.subject.subject_name = 'Todas';

            }
            this.getFirebaseData(this.subject.idsubject, this.idtopic)
            this.selectedIdTopic = this.idtopic
		},

		methods: {

            updateStatisticGraph: function() {
                this.noDataAvailable = false
                this.loading         = true

                if(this.selectedIdTopic == 0)
                    this.getFirebaseData(this.subject.idsubject)
                else
                    this.getFirebaseData(this.subject.idsubject, this.selectedIdTopic)
            },

            getFirebaseData: function(idsubject, idtopic = null) {
                this.graphLabels = []
                this.graphData   = []
                this.liquidScore = []

                let scope = this
                let ref   = ''
                //check if user selected a topic or the subject (all topics)
                if(idtopic == null || idtopic == 0)
                    ref = FirebaseUserQuestions.ref('/users/' + scope.iduser + '/' + idsubject +'/0' )
                else
                    ref = FirebaseUserQuestions.ref('/users/' + scope.iduser + '/' + idsubject + '/' + idtopic)


                ref.once('value', function(snapshot){

                    let response = snapshot.val()
                    let data     = {}
                    let aggregateResponse = {}
                    let temp = []

                    //aggregate response data when all topics are selected
                    if(idtopic == null) {
                        temp = _.flatten(_.values(response)) //transform json object to parsable array

                        for(let key in temp) {
                            for(let log in temp[key]){
                                aggregateResponse[log] = temp[key][log]
                            }
                        }

                        response = aggregateResponse
                    }

                    let safeLastAttempt = true

                    if(response == null) {
                        scope.noDataAvailable = true
                        scope.loading         = false
                    } else {

                        for(let key in response) {
                            let formatKey   = DateHelper.formatDateToShow(key);
                            let liquidScore = (response[key].correct / response[key].total) * 100

                            if(safeLastAttempt) {
                                scope.lastAttempt = {
                                    corrects: response[key].correct,
                                    total   : response[key].total
                                }

                            }

                            scope.liquidScore.push(liquidScore)
                            scope.graphLabels.push(formatKey);

                            data[key] = {
                                dateFormated : formatKey,
                                liquidScore  : liquidScore,
                                time         : response[key].time
                            }
                        }

                        scope.graphTableData = data

                        scope.graphData = [
                            {
                                label: 'Acertos / Total de Questões',
                                data: scope.liquidScore,
                                backgroundColor: 'rgba(235, 35, 65, 0.5)',
                                lineColor: 'rgba(255,99,132,1)'
                            },
                        ]

                        scope.loading = false
                    }

                })
            }
		}




	}


</script>
