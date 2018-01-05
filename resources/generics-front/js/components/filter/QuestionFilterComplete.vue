<!--
@Component:
    question-filter
@Description:
    Page that manages  question filtering. It filters by resolved and not resolved.
@CalledComponents:
    1 - question-filter-counter
@ApiRoutes:
    subject
    questions/count-by-subject/
    questions/count
    topic/by-subject/{subjectId}
    questions/count-by-topic/{topicID}
    topic/by-subject-user-nr/{subjectId}/{userId}
    questions/count-by-topic-user-nr/{topicID}/{userId}
    topic/by-subject-user/{subjectId}/{userId}
    questions/count-by-topic-user/{topicID}/{userId}
    topic/by-subject-not-reviewed/{subjectId}
    questions/count-by-topic-not-reviewed/{topicID}
@WebRoutes:
    /dashboard/questoes?subject={subject}&topic={topic}&status={status}&count={count}
@Props:
    user        : user info with level and id
    token       : user authentication token
@TODO:
    1 - Fix labels
    2 - receive token by props
-->

<template xmlns:v-model="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <section class="Dashboard Dashboard--section u-m-t-40 u-m-b-40">
        <div class="container">
            <div class="row">
                <header class="Dashboard-header col-sm-12 u-m-b-20">
                    <h2 class="Dashboard-title Dashboard-title--color30">Filtro de questões</h2>
                </header>
                <div class="Dashboard-content col-sm-12">
                    <div class="Widget Widget--border Widget-bgWhite Widget--noRadiusRight col-sm-6" style="height: 600px;">
                        <div class="u-table">
                            <div class="u-vAlign">
                                <form class="Form Form--default">
                                    <div class="form-group">
                                        <label for="subject" class="Form-label">Disciplina</label>
                                        <select id="subject" v-model="idsubject" v-on:change="handleSubjectSelect"
                                                name="topic" placeholder="Selecione o Assunto"
                                                class="Form-select form-control">
                                            <option value="0"> Todas </option>
                                            <option v-for="subject in subjects" v-bind:value="subject.idsubject">
                                                {{ subject.subject_name }}
                                            </option>
                                        </select>
                                    </div>
                                    <div v-if="idsubject!=0" class="form-group">
                                        <label for="topic" class="Form-label">
                                            Assunto </label>
                                        <select id="topic"
                                                v-model="idtopic" v-on:change="countQuestions" name="topic"
                                                placeholder="Selecione o Assunto" class="Form-select form-control">
                                            <option value="0"> Todos </option>
                                            <option v-for="topic in topics" v-if="topic!=null" v-bind:value="topic.idtopic">
                                                {{ topic.topic_name }}
                                            </option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="nalt" class="Form-label">Nº de Alternativas</label>
                                        <select id="nalt" v-model="nOfAlternatives"
                                                v-on:change="countQuestions"
                                                placeholder="Selecione o número de alternativas"
                                                class="Form-select form-control">
                                            <option value="0"> Todas </option>
                                            <option value="2"> 2 </option>
                                            <option value="4"> 4 </option>
                                            <option value="5"> 5 </option>

                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="jury" class="Form-label">Banca</label>
                                        <select id="jury" v-model="idjury" v-on:change="countQuestions"
                                                name="topic" placeholder="Selecione o Assunto"
                                                class="Form-select form-control">
                                            <option value="0"> Todas </option>
                                            <option v-for="jury in juries" v-bind:value="jury.idjury">
                                                {{ jury.name }}
                                            </option>
                                        </select>
                                    </div>

                                    <!--<div class="form-group">-->
                                    <!--<label for="keyword" class="Form-label">Palavra-chave</label>-->
                                    <!--<input id="keyword" v-model="keyWord"-->
                                    <!--v-on:change="countQuestions"-->
                                    <!--placeholder="Digite a palavra-chave"-->
                                    <!--class="Form-input form-control">-->
                                    <!--</div>-->





                                    <div class="form-group">
                                        <label  class="Form-label">Anos</label>
                                        <br>
                                        <div v-on:click="getValue">
                                            <vue-slider
                                                    ref="sliderYear"
                                                    v-on:drag-end="getValue"
                                                    :disabled="false"
                                                    :min="min"
                                                    :max="max"
                                                    :piecewise="true"
                                                    :piecewise-style="pieceStyle"
                                                    :show="true"
                                                    :sliderStyle="tooltipStyle"
                                                    :value="yearValue"
                                                    :tooltipDir="tDir"
                                            ></vue-slider>
                                        </div>
                                    </div><br>

                                    <div v-if="user.user_level == 4" class="form-group">
                                        <label class="Form-label">
                                            QUESTÕES JA REVISADAS: {{ reviewedQuestions }}
                                        </label>
                                    </div>

                                    <div class="form-group">
                                        <label class="Form-label">Status</label>
                                        <div class="Form-group">
                                            <div class="Form-radio Form-radio">
                                                <input v-on:click="countQuestions()"
                                                       id="status-1"
                                                       type="radio" v-model="status"
                                                       name="status" v-bind:value="1" >
                                                <label for="status-1" class="Form-label">Todas</label>
                                            </div>
                                            <div class="Form-radio Form-radio">
                                                <input
                                                        type="radio"
                                                        id="status-2"
                                                        v-model="status"
                                                        v-on:click="countQuestions()"
                                                        name="status" v-bind:value="2">
                                                <label for="status-2" class="Form-label">Ainda não resolvi</label>
                                            </div>


                                            <!--<div class="Form-radio Form-radio">-->
                                            <!--<input type="radio"-->
                                            <!--id="status-3"-->
                                            <!--v-model="status" v-on:click="countQuestions()"-->
                                            <!--name="status" v-bind:value="3">-->
                                            <!--<label for="status-3" class="Form-label">Resolvi</label>-->
                                            <!--</div>-->
                                            <div v-if="user.user_level == 4" class="Form-radio Form-radio">
                                                <label class="Form-label Form-label--checkbox checkbox-inline">
                                                    <input v-on:click="countQuestions()" v-model="status"
                                                           class="Form-checkbox" name="status" type="radio"
                                                           v-bind:value="4" > SOMENTE QUESTÕES NÃO REVISADAS
                                                </label>
                                            </div>
                                        </div>
                                    </div><br>

                                    <!-- <div class="form-group">
                                        <label class="Form-label Form-label--checkbox checkbox-inline">
                                            <input class="Form-checkbox" type="checkbox" id="obs" value="1"> Mostrar somente questões com resolução
                                        </label>
                                    </div> -->
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="Widget Widget--border Widget-bgBlue Widget--noRadiusLeft col-sm-6" style="height: 600px;">
                        <div class="u-table">
                            <div class="u-vAlign">
                                <div class="row">
                                    <div class="col-xs-6 col-sm-12">
                                        <h3
                                                class="Widget-title Widget-title--medium Widget-title--color10 u-bold">
                                            Questões</h3>
                                        <question-filter-counter
                                                v-if="ready"
                                                :n="count"
                                                v-bind:loading='loading'
                                                v-on:child-count-changed='updateReviewedQuestions'>
                                        </question-filter-counter>
                                        <moon-loader v-else style="margin: 15px" color="#eb2341"></moon-loader>
                                    </div>
                                    <div class="col-xs-6 col-sm-12">
                                        <button v-on:click="resetFilter"
                                                class="Button Button--voidBorder Button--voidBorderWhite">
                                            Redefinir</button>
                                        <button v-if="count > 0" v-on:click="redirectToResolution"
                                                class="Button Button--default Button--defaultGreen">
                                            Resolver</button>
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

<script>
    import vueSlider from 'vue-slider-component'
    import MoonLoader from 'vue-spinner/src/MoonLoader.vue'

    export default {
        props: {
            user: {
                type: Object
            },
            token: {

            }
        },

        components: {
            vueSlider,
            MoonLoader
        },


        data(){
            return {
                idsubject           : 0,
                idjury              : 0,
                idtopic             : 0,
                subjects            : [],
                topics              : [],
                count               : 0,
                status              : 0,
                reviewedQuestions   : 0,
                loading             : true,
                ready               : false,
                totalCount          : 0,
                endYear             : 2017,
                startYear           : 2004,
                min                 : 2004,
                max                 : 2017,
                yearValue           : [
                    2004,
                    2017
                ],
                pieceStyle          : {
                    'background-color': '#a6ce38'
                },
                tooltipStyle        : [
                    {
                        "backgroundColor": "#a6ce38",
                        "borderColor": "#a6ce38"
                    },
                    {
                        "backgroundColor": "#a6ce38",
                        "borderColor": "#a6ce38"
                    }
                ],
                tDir                : [
                    "bottom",
                    "top"
                ],
                juries              : [],
                keyWord             : "",
                canRequest          : true,
                nOfAlternatives     : 0
            }
        },

        mounted(){
            let scope = this
            this.$http.get(window.api + 'subject').then((response) => {
                scope.subjects = response.data
                scope.$http.get(window.api + 'questions/get-juries').then((response) => {
                    scope.juries = response.body.data
                    scope.ready = true
            })
        })

           this.$http.get(window.api + 'questions/count').then((response) => {
               this.count = response.body
           });

            this.status = 1
        },

        methods: {

            resetFilter(){
                this.idtopic = 0;
                this.idjury = 0;
                this.idsubject = 0;
                this.countQuestions();
            },

            redirectToResolution: function() {
                let generic = ""

                if(this.idtopic == 0)
                    generic = 'subject'
                else
                    generic = 'topic'

                let url = '/dashboard/questoes?status=' + this.status +'&ids=' + this.idsubject + '&idt=' + this.idtopic +'&jury=' +
                        this.idjury + '&startYear=' + this.startYear + '&endYear=' + this.endYear +
                        '&count=' + this.count  + '&generic=' + generic + "&keyWord=" + this.keyWord +
                        '&nOfAlt=' + this.nOfAlternatives

                window.location.assign(url);
            },

            handleSubjectSelect: function(){

                this.idtopic = 0;
                this.idjury = 0;
                this.getTopics();
                this.countQuestions();

            },

            getTopics: function() {
                this.$http.get(window.api + 'topic/by-subject/'+this.idsubject).then((response) => {
                    this.topics = response.body.topic
            });
            },

            countQuestions: function(constraint) {
                this.loading = true
                let url      = window.api
                let id = ""
                let scope = this

                if(this.idtopic == 0){
                    url += 'questions/count-by-subject'
                    id  = this.idsubject
                }
                else{
                    url += 'questions/count-by-topic'
                    id  = this.idtopic
                }

                let data = {
                    id          : id,
                    jury        : scope.idjury,
                    status      : scope.status,
                    userId      : scope.user.id,
                    startYear   : scope.startYear,
                    endYear     : scope.endYear,
                    keyWord     : scope.keyWord,
                    nOfAlt      : scope.nOfAlternatives
                };

                if(this.canRequest){
                    this.canRequest = false
                    this.$http.post(url + '?token=' + scope.token, data).then((response) => {
                        scope.loading = false
                        scope.count   = response.body
                        scope.canRequest = true
                });
                }


            },

            updateReviewedQuestions: function(bool) {
                if(this.user.user_level == 4){

                    let url = window.api

                    if(this.idtopic != 0)
                        url += 'questions/count-by-topic-reviewed/' + this.idtopic
                    else
                        url += 'questions/count-by-subject-reviewed/' + this.idsubject

                    this.$http.get(url).then((response) => {
                        this.reviewedQuestions = response.body
                });

                }
            },


            getValue: function(years){
                let slider = this.$refs["sliderYear"]
                let scope = this;

                this.loading = true;
                scope.startYear = slider.getValue()[0]
                scope.endYear = slider.getValue()[1]

                this.countQuestions()
            }


        },

        watch: {
            keyWord: function(){
                this.countQuestions()
            }
        }
    }

</script>