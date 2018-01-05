<template>
    <div class="Profile">
        <div class="container">
            <div class="row">
                <side-profile
                    v-on:update-step="updateStep"
                ></side-profile>

                <section v-if="step == 0" class="Dashboard Dashboard--section col-sm-9 u-m-t-40 u-m-b-40">
                    <div class="Dashboard-content">

                        <!-- Foto de Perfil -->
                        <profile-picture
                                :avatar="avatar"
                                :user-id = "userId"
                        ></profile-picture>
                        <!-- END Foto de Perfil -->

                        <!-- CONTACT INFO -->
                        <profile-info
                                :user-name   = "userName"
                                :birth       = "birth"
                                :email       = "email"
                                :gender      = "gender"
                                :user-id     = "userId"
                        ></profile-info>
                        <!-- END CONTACT INFO -->
                    </div>
                </section>
                <update-password
                    v-if="step == 1"
                    :user-id="userId"
                ></update-password>
                <payment-records
                    v-if="step == 2"
                    :user-id="userId"
                ></payment-records>

            </div>
        </div>
    </div>
</template>
<script>
    export default{
        props: [
            'userName',
            'birth',
            'gender',
            'userId',
            'avatar',
            'email'
        ],
        data(){
            return{
                step    : 0
            }
        },
        mounted(){

        },
        methods:{
            updateStep(step){
                this.step = step;
            }
        }
    }
</script>