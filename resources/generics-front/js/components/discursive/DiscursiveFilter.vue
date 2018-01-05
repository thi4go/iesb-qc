<!--
@Component:
    discursive-filter
@Description:
    Page that manages discursive question filtering. It filters by year and subject.
@CalledComponents:
    1 - vue-slider-component
@ApiRoutes:
    discursives/discursive-subjects/{startYear},{endYear},{resolved}
@WebRoutes:
@Props:
    subjects    : JSON with a list of discursive questions that were solved
    count       : total number of disccursive questions
    userId      : id of user
    token       : user authentication token
@TODO:
    1 - Filter by jury
    2 - Filter based on resolved or not by user
    3 - receive userId and token by props
-->

<template xmlns:v-model="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <section class="Dashboard Dashboard--section u-m-t-40 u-m-b-40">
        <div class="container">
            <div class="row">
                <header class="Dashboard-header col-sm-12 u-m-b-20">
                    <h2 class="Dashboard-title Dashboard-title--color30">
                        Filtro de discursivas </h2>
                </header>
                <div class="Dashboard-content col-sm-12">
                    <div class="Widget Widget--border Widget-bgWhite Widget--noRadiusRight col-sm-6">
                        <div class="u-table">
                            <div class="u-vAlign">
                                <form class="Form Form--default">

                                    <div class="form-group">
                                        <label for="discipline" class="Form-label">Disciplina</label>
                                        <select
                                                v-model="selectedSubject"
                                                name="discipline" id="discipline" class="Form-select form-control" >
                                            <option value="0">Total</option>
                                            <option v-for="(subject, i) in discursiveSorted" v-bind:value="i + 1">
                                                {{subject.subject_name}}</option>
                                        </select>
                                    </div>

                                    <div class="form-group">

                                    </div>
                                    <div class="form-group">
                                        <label  class="Form-label">Anos</label>
                                        <br><br>
                                        <div v-on:click="getValue">
                                            <vue-slider
                                            ref="sliderYear"
                                            v-on:drag-end="getValue"
                                            :disabled="false"
                                            :min="min"
                                            :max="max"
                                            :piecewise="true"
                                            :show="true"
                                            tooltip="always"
                                            :dot-size="20"
                                            :slider-style="sliderStyle"
                                            :tooltip-style="tooltipStyle"
                                            :value="yearValue"
                                            :tooltip-dir="tooltipDir"
                                            :bg-style="bgStyle"
                                            :process-style="processStyle"

                                            ></vue-slider>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <label class="Form-label">Tipo</label>
                                        <div class="Form-group">
                                            <div class="Form-radio Form-radio">
                                                <input v-on:click   = "getValue()"
                                                       id           = "status-1"
                                                       type         = "radio"
                                                       v-model      = "questionType"
                                                       name         = "status"
                                                       v-bind:value = "1" >
                                                <label for="status-1" class="Form-label">Todos</label>
                                            </div>
                                            <div class="Form-radio Form-radio">
                                                <input v-on:click   = "getValue()"
                                                       id           = "status-2"
                                                       type         = "radio"
                                                       v-model      = "questionType"
                                                       name         = "status"
                                                       v-bind:value = "2" >
                                                <label for="status-2" class="Form-label">Questões</label>
                                            </div>
                                            <div class="Form-radio Form-radio">
                                                <input v-on:click   = "getValue()"
                                                       id           = "status-3"
                                                       type         = "radio"
                                                       v-model      = "questionType"
                                                       name         = "status"
                                                       v-bind:value = "3" >
                                                <label for="status-3" class="Form-label">Peças</label>
                                            </div>

                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label class="Form-label Form-label--checkbox checkbox-inline">
                                            <input v-on:click="resolved = !resolved" class="Form-checkbox" type="checkbox" id="obs" value="1">
                                            Mostrar somente questões com resolução
                                        </label>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>


                    <div class="Widget Widget--border Widget-bgBlue Widget--noRadiusLeft col-sm-6">
                        <div class="u-table">
                            <div class="u-vAlign">
                                <div class="row">
                                    <div class="col-xs-6 col-sm-12">
                                        <h3 class="Widget-title Widget-title--medium Widget-title--color10 u-bold">Questões</h3>

                                        <div v-if="loading">
                                            <p class="Widget-text Widget-text--count Widget-text--color30 u-bold">
                                                <i class="fa fa-spinner fa-spin"></i>
                                            </p>
                                        </div>
                                        <div v-else>
                                            <p class="Widget-text Widget-text--count Widget-text--color30 u-bold">
                                                {{currentCounter}}</p>
                                        </div>
                                    </div>

                                    <div class="col-xs-6 col-sm-12">

                                        <a v-if="qAvailable" v-bind:href="'/dashboard/questoes-discursivas/' +
                                        (this.selectedSubject == 0 ? -1 : this.discursiveSorted[this.selectedSubject - 1].idsubject) +
                                        ',' +  startYear + ',' + endYear + ',' + (resolved == true ? '1' : '0') + ',' +  questionType"
                                           class="Button Button--voidBorder Button--voidBorderWhite" title="Resolver">Resolver</a>
                                        <a href="/dashboard/discursivas/resolved" class="Button Button--voidBorder Button--voidBorderWhite" title="Resolvidas">Resolvidas</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</template>
er
<script src="https://www.gstatic.com/firebasejs/3.7.0/firebase.js"></script>

<script>

    import vueSlider from 'vue-slider-component'

    export default {
        props : [
            'subjects',
            'count',
            'userId',
            'token'
        ],

        components: {
            vueSlider
        },

        data(){
            return {
                discursiveSubjects  : [],
                loading             : false,
                totalQuestions      : 0,
                endYear             : 2017,
                startYear           : 2010,
                min                 : 2010,
                max                 : 2017,
                qAvailable          : false,
                selectedSubject     : 0,
                currentCounter      : 0,
                yearValue           : [
                    2010,
                    2017
                ],
                tooltipDir: [
                    "bottom",
                    "top"
                ],
                piecewise: false,
                style: {
                    "marginBottom": "30px"
                },
                bgStyle: {
                    "backgroundColor": "#fff",
                    "boxShadow": "inset 0.5px 0.5px 3px 1px rgba(0,0,0,.36)"
                },
                sliderStyle: [
                    {
                        "backgroundColor": "#eb2341"
                    },
                    {
                        "backgroundColor": "#292929"
                    }
                ],
                tooltipStyle:[
                    {
                        "background-color": "#eb2341",
                        "border-color": "#eb2341",
                    },
                    {
                        "background-color": "#292929",
                        "border-color": "#292929",
                    }
                ],
                processStyle: {
                    "backgroundImage": "-webkit-linear-gradient(left, #eb2341, #292929)"
                },
                resolved            : false,
                questionType        : 1

            }
        },


        mounted() {
            this.totalQuestions = this.count;

            for(let subject of JSON.parse(this.subjects)){
                this.discursiveSubjects.push(subject)
            }


            this.currentCounter = this.totalQuestions;
        },

        methods: {
            getValue() {
                let slider = this.$refs["sliderYear"]
                let scope = this;

                this.loading = true;
                scope.startYear = slider.getValue()[0]
                scope.endYear = slider.getValue()[1]


                this.$http.get(window.api +
                    'discursives/discursive-subjects/' + scope.startYear + "," +
                    scope.endYear + "," + (scope.resolved == true ? '1' : '0') + ',' +  scope.questionType).then(response=>{
                    scope.discursiveSubjects = []
                    scope.totalQuestions = 0
                    for(let subject of response.body){
                        scope.totalQuestions += subject.count
                        scope.discursiveSubjects.push(subject)
                    }

                    if( scope.selectedSubject != 0)
                        scope.currentCounter = scope.discursiveSorted[scope.selectedSubject - 1].count
                    else
                        scope.currentCounter = scope.totalQuestions

                    scope.loading = false

                })

            },

        },

        watch: {
            selectedSubject: function() {
                let scope = this

                this.loading = true;

                if(this.selectedSubject == 0)
                    this.currentCounter = this.totalQuestions
                else
                    this.currentCounter = this.discursiveSorted[this.selectedSubject - 1].count

                scope.loading = false

            },

            currentCounter: function(){
                if(this.currentCounter <= 0)
                    this.qAvailable = false
                else
                    this.qAvailable = true

            },

            resolved: function(){
                this.getValue()
            }
        },

        computed:{
            discursiveSorted(){
                return this.discursiveSubjects.slice(0).sort((a,b) => {
                            var x = a.idsubject; var y = b.idsubject;
                            return ((x < y) ? -1 : ((x > y) ? 1 : 0));
                        })
            }
        }



    }


</script>
