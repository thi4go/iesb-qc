<template>
    <div class="Widget u-m-b-30">

        <div class="Widget-bgWhite Widget-padding">
            <div class="Widget-header">
                <h3 class="Widget-title Widget-title--min Widget-title--color40 u-bold">Foto de Perfil</h3>
            </div>
            <div class="Widget-content">
                <div class="Avatar text-center">
                    <img :src="avatar" class="img-circle img-responsive u-m-b-40" data-no-retina="true">

                </div>
                <div class="Form-upload text-center">
                    <input type="file" accept=".png,.jpg,.jpeg" id="file" @change="onFileChange" class="inputfile">
                    <label for="file">Escolha um arquivo</label>
                    <button class="Button Button--default Button--defaultGreen" v-on:click="updateImage">Alterar</button>
                    <p v-if="error" class="help-block alert-danger">Tamanho Inválido. Selecione uma imagem menor que 200KB</p>
                    <pulse-loader v-if="loading" style="margin-top: 10px" color="#eb2341"></pulse-loader>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import PulseLoader from 'vue-spinner/src/PulseLoader.vue'

    export default {

        props: [
            'avatar',
            'userId'
        ],
        components:{
            PulseLoader
        },
        data(){
            return{
                url         : '',
                error       : false,
                loading     : false
            }
        },
        mounted(){
            this.url = window.api + 'user/upload-avatar';
        },
        methods:{
            onFileChange(e) {
                var files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                let reader = new FileReader();
                let scope = this;

                reader.onload = (e) => {
                    let check = e.target.result;
                    if(check.length > 272130){
                        scope.error = true
                    }else {
                        scope.avatar = check;
                    }
                };
                reader.readAsDataURL(file);
            },
            updateImage(){
                let scope = this;
                let data = {
                    'avatar' : scope.avatar,
                    'userId' : scope.userId
                };
                this.$http.post(scope.url,data).then(response=>{
                    scope.loading = true;
                    window.location.reload(false);
                });
            }
        }



    }
</script>
<style lang="scss" scoped>
    .inputfile {
        width: 0.1px;
        height: 0.1px;
        opacity: 0;
        overflow: hidden;
        position: absolute;
        z-index: -1;
    }
    .inputfile + label {
        background-color: #292929;
        border-width: 2px;
        border-style: solid;
        border-color: #292929 ;
        text-transform: uppercase;
        font-size: 0.750em;
        font-weight: 700;
        padding: 10px 20px;
        color: #ffffff;
        border-radius: 3px;
        letter-spacing: 2px;
    }

    .inputfile:focus + label,
    .inputfile + label:hover {
        background-color: white;
        color: #016db9;
    }
    .inputfile + label {
        cursor: pointer; /* "hand" cursor */
    }

</style>
