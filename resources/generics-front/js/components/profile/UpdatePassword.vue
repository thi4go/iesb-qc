<template>
    <section class="Dashboard Dashboard--section col-sm-9 u-m-t-40 u-m-b-40">
        <div class="Dashboard-content">
            <div class="Widget">
                <div class="Widget-bgWhite Widget--border Widget-padding">
                    <div class="Widget-header">
                        <h3 class="Widget-title Widget-title--min Widget-title--color40 u-bold">Atualizar senha</h3>
                    </div>
                    <div class="Widget-content">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="password" class="sr-only">Nova Senha</label>
                                    <input name="password" id="password" type="password" class="Form-input form-control"
                                           v-model="password" placeholder="Nova Senha"/>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="password_confirmation" class="sr-only">Confirmar Nova senha</label>
                                    <input name="password_confirmation" v-model="confirm" id="password_confirmation"
                                           type="password" class="Form-input form-control" placeholder="Confirmar Nova senha" />
                                </div>
                            </div>
                            <div class="col-sm-12 text-center u-m-t-40">
                                <pulse-loader v-if="loading" style="margin-top: 10px" color="#eb2341"></pulse-loader>
                                <button v-if="!loading" v-on:click="updatePassword" class="Button Button--default Button--defaultGreen"
                                        title="Atualizar">Atualizar</button>
                                <p v-if="error" class="alert alert-danger">As senhas não conferem</p>
                                <p v-if="success" class="alert alert-success">Senha atualizada com sucesso</p>
                            </div>
                        </div>
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
                password    : '',
                confirm     : '',
                error       : false,
                loading     : false,
                success     : false
            }
        },
        methods:{
            updatePassword(){
                if(this.password == this.confirm){
                    if(this.password.length >=6){
                        let data ={
                            'password' : this.password,
                            'userId'   : this.userId
                        };
                        this.$http.post(window.api+ 'user/update-pwd',data).then(response=>{
                            this.loading=true;
                            this.success=true;
                            window.location.reload(false);
                        });
                    }else{
                        this.error = true;
                    }
                }else{
                    this.error = true;
                }
            }
        }
    }
</script>
<style scoped>
    .alert{
        margin-top: 20px;
    }
</style>