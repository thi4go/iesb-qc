<!--
@Component:
    select-subject
@Description:
    Page in which subjects to be studied are chosen when building control.
@CalledComponents:
@ApiRoutes:
    subjects/subjects-and-percentil-by-contest/{userId}/{contestId}
@WebRoutes:
@Props:
    contestId       : cycle id
    userId          : user id
    token           : user authentication token
@Constants:
@TODO:
-->


<template xmlns:v-model="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div class="Dashboard-content">
        <div v-if="loading" class="Dashboard-content col-sm-12">
            <page-loader color="#eb2341"></page-loader>
        </div>
        <div class="Widget" v-else>
            <div class="Widget-bgWhite Widget--border Widget-padding">
                <div class="Widget-header col-sm-10 u-m-t-40">
                    <h3 class="Widget-title Widget-title--min Widget-title--color40 u-bold">Disciplinas</h3>
                </div>
                <div class="Widget-content">
                    <div class="row">
                        <div class="col-sm-10 u-m-b-40">
                            <table class="Table">
                                <thead>
                                <tr>
                                    <th>Escolha as disciplinas</th>
                                    <th>Proficiência
                                        <button type="button"
                                                class="Button Button--popover popover-dismiss"
                                                data-container="body"
                                                data-toggle="popover"
                                                data-placement="bottom"
                                                data-content="É a posição em que você se encontra em relação aos concorrentes.">?</button></th>
                                    <th>Incluir</th>
                                </tr>
                                </thead>
                                <tbody class="u-bold">

                                <tr v-for="subject in subjects">
                                    <td data-th="Disciplina">
                                        {{subject.subject_name}}
                                    </td>
                                    <td data-th="Proficiência">
                                        {{(subject.userPercentil * 100).toFixed(2)}}%
                                    </td>
                                    <td data-th="Incluir">
                                        <div v-if="subjectsChecked.includes(subject.idsubject)">
                                            <label>

                                                <toggle-button @change="selectChange(subject.idsubject)"
                                                               :value="true"
                                                               :labels="{checked: 'Sim', unchecked: 'Não'}"
                                                />



                                            </label>
                                        </div>
                                        <div v-else>
                                            <label>

                                                <toggle-button @change="selectChange(subject.idsubject)"
                                                               :value="false"
                                                               :labels="{checked: 'Sim', unchecked: 'Não'}"
                                                />

                                            </label>
                                        </div>
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row col-sm-offset-5">
                        <div class="col-xs-6 col-sm-3">
                            <button v-on:click="updateStep(-1)" id="subjects-submit-btn" type="submit"
                                    class="Button Button--small text-center Button--default Button--defaultDanger"
                                    title="Anterior">Anterior</button>
                        </div>
                        <div class="col-xs-6 col-sm-3">
                            <button v-on:click="updateStep(1)" type="submit"
                                    class="Button Button--small text-center Button--default Button--defaultGreen"
                                    title="Próximo">Próximo</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import ToggleButton from 'vue-js-toggle-button'
    Vue.use(ToggleButton)
    export default {

        props:[
            'userId',
            'contestId',
            'totalTime'
        ],

        data(){
            return{
                subjects : [],
                subjectsChecked : [],
                loading: true,
            }
        },

        mounted(){
            let scope = this;
            this.$http.get(window.api + 'subjects/subjects-and-percentil-by-contest/'+this.userId+'/'+this.contestId+'/'+this.totalTime).then(response=>{
                scope.subjects = response.body.data
                let subjects = scope.subjects;
                for(let key in subjects){
                    if(subjects[key].checked)
                        scope.subjectsChecked.push(parseInt(subjects[key].idsubject))
                }
                scope.loading = false;
            });
        },

        methods:{
            updateStep(amt){
                let data = {
                    subjectsId : this.subjectsChecked
                }
                this.$emit('child-update-step',data,amt)
            },
            selectChange(id){
                if(this.subjectsChecked.includes(id)){
                    var index = this.subjectsChecked.indexOf(id)
                    this.subjectsChecked.splice(index,1)
                }else{
                    this.subjectsChecked.push(id)
                }
            }
        }

    }
</script>
