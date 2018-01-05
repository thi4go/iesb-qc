<!--
@Component:
    question-topic-changer
@Description:
    Page responsible for question topics admin management
@CalledComponents:
@ApiRoutes:
    topic/get-subjects-topics/{idSubject}
    question/update-subject
    question/update-topic
    topic/by-subject/{subjectIdSelect}
@WebRoutes:
@Props:
    idSubject   : id of the subject
    question    : current question
    userId      : id of user
    token       : user authentication token
@TODO:
    1 - Improve style
    2 - Pass userId and token by props
-->

<template xmlns:v-model="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div>
        <label for="subjects" class="Form-label">
            Escolha uma nova Disciplina:
            <select v-on:change="updateTopics" v-model="subjectIdSelected" id="subjects" name="subjects" placeholder="Selecione Um Simulado" class="Form-select form-control" style="width: 15em">
                <option v-for="subject in subjects" v-bind:value="subject.idsubject">
                    {{subject.subject_name}}
                </option>
            </select>
            <button v-on:click="saveSubject" class="Button Button--default Button--defaultBlueFull" title="Ver resposta">Salvar nova Disciplina</button>
        </label>

        <label for="topics" class="Form-label">
            Escolha um novo Topico:
            <select v-on:change="" v-model="topicIdSelected" id="topics" name="topics" placeholder="Selecione Um Simulado" class="Form-select form-control" style="width: 14em">
                <option v-for="topic in topics" v-bind:value="topic.idtopic">
                    {{topic.topic_name}}
                </option>
            </select>
            <button v-on:click="saveTopic" class="Button Button--default Button--defaultBlueFull" title="Ver resposta">Salvar novo Assunto</button>
        </label>
    </div>
</template>

<script>
    export default {
        props : [
            'idSubject',
            'question',
            'userId',
            'token'
        ],
        data(){
            return{
                subjects : [],
                topics   : [],
                topicIdSelected : null,
                subjectIdSelected : null,
            }

        },
        mounted() {
            this.$http.get(window.api+'topic/get-subjects-topics/'+this.idSubject).then(response=>{
                this.subjects = response.body.data.subjects
                this.topics   = response.body.data.topics
            })
        },


        methods:{
            saveSubject : function(){
                let data = [];

                data = {
                    idsubject  : this.subjectIdSelected,
                    idquest : this.question.idquest
                }

                this.$http.post(window.api+'question/update-subject',data).then(response=>{
                    alert('Disciplina Salva')
                })
            },

            saveTopic : function(){
                let data = [];

                data = {
                    idtopic  : this.topicIdSelected,
                    idquest : this.question.idquest
                }

                this.$http.post(window.api+'question/update-topic',data).then(response=>{
                    alert('Topico Salvo')
                })
            },

            updateTopics: function () {

                this.$http.get(window.api+'topic/by-subject/'+this.subjectIdSelected).then(response => {
                    this.topics = response.body.topic;
                })
            }
        }

    }
</script>
