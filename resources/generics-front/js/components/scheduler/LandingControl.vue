<!--
@Component:
    landing-control
@Description:
    Control landing page that shows option to create new cycle or access the existing one
@CalledComponents:
    1 - graph
@ApiRoutes:
@WebRoutes:
@Props:
    allCycles       : all cycles information of user contained in firebase
    firebaseCycle   :
@Constants:
@TODO:
-->

<template xmlns:v-model="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div class="col-sm-9">
        <div class="Cycle-landing" >
            <h4>Escolha um Ciclo: </h4>
            <div class="table" v-for="plan in plans">
                <div class="item">
                    {{plan.name}}
                </div>
                <div class="text-right" >
                    <button class="Button Button--default Button--defaultDanger ">Excluir</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props:[
            'firebaseCycle',
            'allCycles'
        ],

        mounted(){

        },
        data(){
            return{
                plans: [
                    {name: "civil"},
                    {name: "civil2"}
                ]
            }
        },


    }
</script>