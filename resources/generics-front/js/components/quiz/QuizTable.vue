<!--
@Component:
    quiz-table
@Description:
    Table that contains information about resolved quizzes.
@CalledComponents:
@ApiRoutes:
    question/get-best-question/
    question/get-future-best-question
    user/answerQuizQuestion
@WebRoutes:
@Props:
    tableData   : data with the information to be displayed at the table
@Constants:
@TODO:
    1 - Add some columns
-->

<template xmlns:v-model="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div>
        <table class="Table">
            <thead>
            <tr>
                <th>
                    Data
                </th>
                <th>
                    Proficiência
                </th>
                <th>
                    Tempo
                </th>
            </tr>
            </thead>
            <tr v-for="data in tableData">
                <td>
                    {{data.dateFormated}}
                </td>
                <td>
                    {{(data.theta).toFixed(2)}}%
                </td>
                <td>
                    {{data.time}}
                </td>
            </tr>
        </table>
    </div>
</template>

<script>
    export default {
        props : [
            "tableData"
        ],

        data(){
            return{
            }

        },

        methods:{

        }

    }
</script>
