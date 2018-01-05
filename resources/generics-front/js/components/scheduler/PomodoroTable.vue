<!--
@Component:
    select-subject
@Description:
    Renders table with subjects and pomodoros related to them
@CalledComponents:
    1 - pomodoro-line
@ApiRoutes:
@WebRoutes:
    materias/disciplina/{subjectId}/{userId}
@Props:
    tableData       : information to display on table data
    userId          : user id
    token           : user authentication token
@Constants:
@TODO:
-->

<template xmlns:v-model="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div id="pomodoroTable" class="Cycle">
        <table class="Table u-m-b-20">
            <thead class="hidden-xs hidden-sm">
                <tr>
                    <th>
                        Disciplina
                    </th>
                    <th>
                        Pomodoros
                    </th>
                    <th class="Status">
                        Ações
                    </th>
                </tr>
            </thead>
            <tbody class="u-bold">
            <tr v-for="(data,index) in table">
                <td data-th="Disciplina">
                    {{data.subjectName}}
                </td>
                <td data-th="Pomodoros">
                    <pomodoro-line
                        :clickable      = true
                        :green-pomodoro = data.greenPomodoro
                        :red-pomodoro   = data.redPomodoro
                        :subject-id     = index
                        :user-id        = userId
                        v-on:updated-color = "pomodoroHandler"
                        :data-bound-scope = "dataBound"
                    ></pomodoro-line>
                </td>
                <td data-th="Ações">
                    <div class="col-sm-offset-1 col-sm-12">
                        <a href=# v-on:click="clearSubject(index)" id="clearButton" class="Button Button--tiny btn-half text-center
                        Button--default Button--defaultDanger" title="Limpar">Limpar</a>

                        <a :href="'materias/disciplina/'+index+'/'+userId" id="studyButton" class="Button Button--tiny btn-half text-center
                        Button--default Button--defaultGreen" title="Estudar">Estudar</a>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>

    export default {
        props:[
            'tableData',
            'userId',
            'token'
        ],

        data(){
            return {
                table : null,
                dataBound : false
            }
        },

        mounted(){
        },

        methods:{
            pomodoroHandler: function (number, subjectId) {
                let total = this.table[subjectId].greenPomodoro + this.table[subjectId].redPomodoro
                this.$emit('pomodoro-msg', number - this.table[subjectId].greenPomodoro, subjectId)
                this.table[subjectId].greenPomodoro = number;
                this.table[subjectId].redPomodoro = total - number;
            },
            clearSubject(subjectId){
                this.dataBound = true
                let scope = this
                this.$nextTick(()=> {
                    let total = scope.table[subjectId].greenPomodoro + scope.table[subjectId].redPomodoro
                    scope.$emit('pomodoro-msg', 0 - scope.table[subjectId].greenPomodoro, subjectId)
                    scope.table[subjectId].greenPomodoro = 0;
                    scope.table[subjectId].redPomodoro = total;
                    scope.$nextTick(()=>{
                        scope.dataBound = false
                    })
                })
            }
        },
        watch:{
            tableData(){
                this.table = this.tableData
            }
        }
    }
</script>
