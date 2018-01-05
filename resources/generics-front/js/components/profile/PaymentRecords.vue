<template>
    <section class="Dashboard Dashboard--section col-sm-9 u-m-t-40 u-m-b-40">
        <div class="Dashboard-content">
            <div class="Widget">
                <div class="Widget-bgWhite Widget--border Widget-padding">
                    <div class="Widget-header">
                        <h3 class="Widget-title Widget-title--min Widget-title--color40 u-bold">Histórico de pagamentos</h3>
                    </div>
                    <div class="Widget-content">
                        <pulse-loader v-if="loading" style="margin-top: 10px" color="#eb2341"></pulse-loader>
                        <table v-else class="Table u-m-b-20">
                            <thead>
                            <tr>
                                <th>Data</th>
                                <th>Status</th>
                                <th>Valor</th>
                                <th>Método</th>
                                <!--<th>Recibo</th>-->
                            </tr>
                            </thead>
                            <tbody class="u-bold">


                            <tr v-for="payment in payments">
                                <td data-th="Data">
                                    {{payment.created_at}}
                                </td>

                                <td data-th="Status">
                                    <span v-if="payment.status == 'Recusado'" class="Button Button--tiny Button--default Button--defaultDanger">{{payment.status}}</span>
                                    <span v-else-if="payment.status == 'Autorizado'" class="Button Button--tiny Button--default Button--defaultGreen">{{payment.status}}</span>
                                    <span  v-else class="Button Button--tiny Button--default Button--defaultYellow">{{payment.status}}</span>
                                </td>

                                <td data-th="Valor">
                                    R${{payment.amount}}
                                </td>

                                <td data-th="Método">
                                    {{payment.method}}
                                </td>
                                <!--<td data-th="Recibo">-->
                                    <!--<a href="#" class="Button Button&#45;&#45;tiny Button&#45;&#45;defaultWhiteBlue" title="Baixar">Baixar</a>-->
                                <!--</td>-->
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
    import PulseLoader from 'vue-spinner/src/PulseLoader.vue'
    export default{
        props:[
            'userId'
        ],
        components:{
            PulseLoader
        },
        data(){
            return{
                payments    : {},
                loading     : true
            }
        },
        mounted(){
            this.$http.get(window.api+"transaction/get-user-transactions/"+this.userId).then(response=>{
                this.payments = response.body.data;
                this.loading = false;
            });
        }
    }
</script>