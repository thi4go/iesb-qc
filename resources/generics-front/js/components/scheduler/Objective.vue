<!--
@Component:
    objective
@Description:
    Page of control in which user selects desired course and final date.
@CalledComponents:
    1 - date-picker
@ApiRoutes:
    contests/get-contests
@WebRoutes:
@Props:
    allCycles       : all cycles information of user contained in firebase
    firebaseCycle   :
@Constants:
@TODO:
-->
<template xmlns:v-model="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
</template>

<script>

    import DatePicker from 'vue-datepicker'

    export default {
        mounted(){
            this.$http.get(window.api+'contests/get-contests').then(response=>{
                this.contests = response.body.data
                this.loading = true
                try{
                    this.contestIdSelected=this.contests[0].idcontest
                }catch(e){
                }
                this.updateStep(1)
            })
        },
        components: {
            'date-picker': DatePicker
        },
        data(){
            return{
                startTime: {
                    time: '',
                },
                option: {
                    type: 'day',
                    week: ['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab', 'Dom'],
                    month: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio',
                        'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
                    format: 'DD-MM-YYYY',
                    placeholder: 'Início',
                    inputStyle: {
                        'display': 'inline-block',
                        'padding': '6px',
                        'line-height': '22px',
                        'font-size': '16px',
                        'border': '1.5px solid #f3f3f3',
                        'box-shadow': '0 1px 3px 0 rgba(255, 255, 255)',
                        'border-radius': '3px',
                        'border-style': 'solid',
                        'border-color': '#ccc',
                        'width' : '100%',
                        'color': '#000000'
                    },
                    color: {
                        header: '#ccc',
                        headerText: '#f00'
                    },
                    buttons: {
                        cancel: 'Cancelar',
                        ok: 'Ok',

                    },
                    overlayOpacity: 0.5, // 0.5 as default
                    dismissible: true // as true as default
                },
                limit :[
                    {
                        type: 'fromto',
                        from: new Date().toISOString().slice(0, 10)
                    }
                ],
                chooseConc        : false,
                chooseDate        : false,
                prox              : false,
                contests          : [],
                contestIdSelected : "",
                loading           : false
            }
        },
        methods:{

            updateStep(amt){
                let data = {}
                data = {

                    contest : this.contestIdSelected,
                    date    : this.startTime.time.split('-').reverse().join('-')
                }
                this.$emit('child-update-step',data,amt)
            },

        },

        watch:{
            contestIdSelected(){
                if(this.contestIdSelected != ""){
                    this.chooseConc = true;
                }
            }
        }

    }
</script>
