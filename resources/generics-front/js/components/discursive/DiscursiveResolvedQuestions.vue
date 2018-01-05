<!--
@Component:
    discursive-resolved-questions
@Description:
    Page that shows the history of discursive questions resolved by the user
@CalledComponents:
    1 - report-error
@ApiRoutes:
@WebRoutes:
@Props:
    questions   : JSON list of questions resolved by user
    userId      : id of user
    token       : user authentication token
@TODO:
    1 - Add columns with more info: data, grade, etc...
-->

<template xmlns:v-model="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <section class="Dashboard Dashboard--section u-m-t-40">
        <div class="container">
            <div v-if="feedback">
                <discursive-feedback
                        v-bind:questions="currentQuestion"
                        :examName="examName"
                        :title="title"
                        :user-id="userId">
                </discursive-feedback>
            </div>
            <div v-else class="Dashboard-content">
                <div class="Widget u-m-b-20">
                    <div class="Widget-bgWhite Widget--border Widget-padding">
                        <div class="Widget-header clearfix">
                            <h3 class="Widget-title Widget-title--min Widget-title--color40 u-bold">
                                Questões discursivas resolvidas</h3>
                        </div>
                        <div>
                            <table class="DiscursiveTable u-m-b-20">
                                <thead class="hidden-xs hidden-sm">
                                <tr>
                                    <th>
                                        Numero
                                    </th>
                                    <th>
                                        Data
                                    </th>
                                    <th>
                                        Matéria
                                    </th>
                                    <th>
                                        Número de Linhas Escritas
                                    </th>
                                    <th>
                                        Tempo de Resposta
                                    </th>
                                    <th>
                                        Pontuação
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="u-bold">
                                <tr v-for="(question, i) in questionsAux">
                                    <td data-th="Número">

                                        <a v-on:click="getFeedback(i)" href="#"> {{question.id}}</a>
                                    </td>
                                    <td data-th="Data">
                                        {{question.time_stamp}}
                                    </td>
                                    <td data-th="Matéria">
                                        {{question.subject_name}}
                                    </td>
                                    <td data-th="Número de Linhas">
                                        {{question.answer_lines}}
                                    </td>
                                    <td data-th="Tempo de Resposta">
                                        {{question.answer_time}}
                                    </td>
                                    <td data-th="Pontuação">
                                        <div v-if="question.score!=null">{{question.score.toFixed(2)}}</div>
                                        <div v-else>-</div>
                                    </td>
                                    <!--<td >-->
                                    <!--{{question.maxLines}}-->
                                    <!--</td>-->

                                    <!--<td >-->
                                    <!--{{question.writtenLines}}-->
                                    <!--</td>-->

                                    <!--<td data-th="Status">-->
                                    <!--<a href="#" id="studyButton" class="Button Button&#45;&#45;tiny btn-block  text-center-->
                                    <!--Button&#45;&#45;default Button&#45;&#45;defaultDanger" title="Estudar">-->
                                    <!--{{question.grade}}-->
                                    <!--</a>-->
                                    <!--</td>-->
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        props:[
            'userId',
            'questions',
            'token',
            'examName',
            'title'
        ],

        data(){
            return {
                questionsAux: [],
                feedback: false,
                currentQuestion: []
            }
        },

        mounted(){
            for(let question of this.questions){
                this.questionsAux.push(question)
            }
        },

        methods:{
            getFeedback: function(index){
                this.currentQuestion = []
                this.currentQuestion.push(this.questionsAux[index])
                this.feedback = true
            }
        }
    }
</script>
