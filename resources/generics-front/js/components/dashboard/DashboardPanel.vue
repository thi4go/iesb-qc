<!--
@Component:
    dashboard-panel
@Description:
    Dashboard landing page. It calls three other components as part of it.
    If user has done more then 3 quizzes it shows fullDashboard otherwise
    it shows the quizPanel
@CalledComponents:
    1 - quiz-panel
    2 - subject-panel
    3 - full-dashboard-panel
@ApiRoutes:
@WebRoutes:
@Props:
    subjects    : JSON array of related subjects
    subjectsQuiz: JSON array containing subjects that have quiz
    totalStudied: percentage of user studies
    userId      : id of user
    token       : user authentication token
@TODO:
    1 - Integrate with fullDashboard
    2 - Pass userId and token by props
    3 - Pass style of welcome panel by props
-->

<template xmlns:v-model="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div style="padding-bottom: 20px;">
        <!-- It must be "!fullDash"-->
        <div v-if="!fullDash">
            <section class="Dashboard Dashboard--call u-m-t-40" style="background-image: url(/assets/images/iesb-black.jpg);background-size: cover;background-position: 50%;background-repeat: no-repeat; ">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-11 col-md-10">
                            <h2 class="Dashboard-title">Bem vindo! Aqui formamos vencedores!</h2>
                            <p class="Dashboard-text">Para iniciarmos nossa análise, precisamos entender qual o seu nivel de aprendizagem, por isso, você deve resolver os simulados para entendermos qual o seu nível de conhecimento.</p>
                            <a href="/dashboard/simulado/landing" class="Button Button--default Button--defaultGreen" title="Resolver Simulados">Responder Simulados</a>

                        </div>
                    </div>
                </div>
            </section>
        <!--<app-download/>-->
            <!--{{subjectsQuiz | json}}-->


        </div>
        <div v-else>
            <full-dashboard
                    :userId="userId"
                    :user-efficiency = "userEfficiency"
                    style="margin-top: 70px"
            ></full-dashboard>
        </div>
        <quiz-panel
                :subjectsQuiz="subjectsQuiz"
        ></quiz-panel>
        <subject-panel
                :total-studied="totalStudied"
                :subjects="subjects"
        ></subject-panel>

    </div>
</template>

<script>

    export default {
        props : [
            'subjects' ,
            'subjectsQuiz' ,
            'totalStudied',
            'userId',
            'userEfficiency',
            'token',
            'quizCount'
        ],

        data(){
            return {
                loading:  true,
                fullDash: false
            }
        },


        mounted() {
            if(this.quizCount >= 3){
                this.fullDash = true;
            }

        },

    }


</script>
