<!--
@Component:
    question-feedback-table
@Description:
    Table that shows feedback of question done by user
@CalledComponents:
    1 - question-shower
@ApiRoutes:
@WebRoutes:
@Props:
    tableData : data to be displayed in table
@TODO:
    1 - Add columns with approval chances and percentil
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
                    Acerto Líquido
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
                    {{data.liquidScore}}%
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
