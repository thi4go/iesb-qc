<template>
    <div class="Widget">
        <div class="Widget-bgWhite Widget-padding">
            <div class="Widget-header">
                <h3 class="Widget-title Widget-title--min Widget-title--color40 u-bold">Seus dados</h3>
            </div>
            <div class="Widget-content">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="name" class="sr-only">Nome</label>
                            <input name="name" id="name" class="Form-input form-control" placeholder="Nome" v-model="userName" />
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="birthdate" class="sr-only">Nascimento</label>
                            <input type="text" v-mask="'##/##/####'" class="Form-input form-control Mask-date"
                                   id="birthdate" v-model="birthDate" placeholder="EX.: DD-MM-AAAA" lazy>
                            <!--<input name="birth" id="birthdate" class="Form-input form-control Mask-date" placeholder="Nascimento" v-model="birth"/>-->
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="email" class="sr-only">E-mail</label>
                            <input name="email" id="email" class="Form-input form-control" placeholder="E-mail" v-model="email" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="Form-label">Gênero</label>
                            <select v-model="gender" class="Form-select form-control">
                                <option value="male">Masculino</option>
                                <option value="female">Feminino</option>
                                <option value="other">Outro</option>
                            </select>
                        </div>
                    </div>
                    <!--<div class="col-sm-12 u-m-b-20">-->
                        <!--<div class="form-group">-->
                            <!--<label class="Form-label Form-label&#45;&#45;checkbox checkbox-inline" for="received_mailer">-->
                                <!--<input class="Form-checkbox" type="checkbox" id="received_mailer" value="1"> Receber novidades em meu e-mail-->
                            <!--</label>-->
                        <!--</div>-->
                    <!--</div>-->
                    <div class="col-sm-12 text-center">
                        <pulse-loader v-if="loading" style="margin-top: 10px" color="#eb2341"></pulse-loader>
                        <button v-else v-on:click="updateInfo" class="Button Button--default Button--defaultGreen"
                                 title="Atualizar">Atualizar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import PulseLoader from 'vue-spinner/src/PulseLoader.vue'
    import VueMask from 'v-mask'
    import moment from 'moment'

    export default{
        props:[
            'userName',
            'birth',
            'email',
            'gender',
            'userId'
        ],
        components:{
            PulseLoader,
            VueMask
        },
        mounted(){
            this.birthDate = moment(this.birth, 'YYYY-MM-DD').format('DD/MM/YYYY')
        },
        data(){
            return{
                loading     : false,
                birthDate   : ""
            }
        },
        methods:{
            updateInfo(){
                let url = window.api + 'user/update';
                let date = moment(this.birthDate, 'DD/MM/YYYY').format('YYYY-MM-DD');
                let data={
                    'birth' : date,
                    'name'  : this.userName,
                    'gender': this.gender
                };
                let newData ={
                    'data'      : data,
                    'userId'    : this.userId
                };
                this.$http.post(url,newData).then(response=>{
                    this.loading = true;
                    window.location.reload(false);
                })
            }
        }
    }
</script>