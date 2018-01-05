<!--
@Component:
    subject-panel
@Description:
    Panel that shows the user progress and  a list of subjects and the user progress studying each subject
    or a link to start studying it, in case it hasn't started
@CalledComponents:
@ApiRoutes:
@WebRoutes:
@Props:
    subjects    : JSON array of related subjects
    totalStudied: percentage of user studies
    userId      : id of user
    token       : user authentication token
@TODO:
-->

<template xmlns:v-model="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <section class="Dashboard Dashboard--section u-m-b-40">
        <div class="container">
            <div class="row">
                <section class="Dashboard Dashboard--section u-m-b-40">
                    <div class="container">
                        <div class="row">
                            <header class="Dashboard-header col-sm-12 u-m-b-20">
                                <h2 class="Dashboard-title Dashboard-title--color40">% das aulas estudadas</h2>
                            </header>
                            <div class="Dashboard-content col-sm-12">
                                <div class="Progress">
                                    <div class="Progress-bar Progress-bar--color13 u-m-b-5">
                                        <div class="Progress-loading Progress-loading--color30" role="progressbar"
                                             v-bind:aria-valuenow="totalStudied" aria-valuemin="0"
                                             v-bind:style="'width:'+totalStudied+'%'"
                                             aria-valuemax="100"></div>
                                    </div>
                                    <p class="Progress-count">{{totalStudied}}% Estudado</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <div>
                    <header class="Dashboard-header col-sm-12 u-m-b-20">
                        <h2 class="Dashboard-title Dashboard-title--color30">% por disciplina</h2>
                    </header>


                    <div class="BoxResponsive">
                        <!-- Rendering by columns in order to keep
                                responsive layout -->

                        <!-- renders first column -->
                        <div v-for="n in 3" class="col-sm-6 col-md-4 u-m-b-10">
                            <div v-for="(subject, i) in subjectsCourses">
                                <div v-if="i % 3 == n - 1" class="Card Card--simulate">
                                    <div class="Card-header u-m-b-10">
                                        <h2 class="Card-title Card-title--color40 u-bold">
                                            {{subject.title}}
                                        </h2>
                                    </div>
                                    <div class="Card-content">
                                        <div v-if="subject.percentageMade === 0">
                                            <a v-bind:href="'/dashboard/materias/' + subject.id"
                                               class="Card-link Card-link--play Icon Icon--playBefore"
                                               title="Veja sua primeira aula agora">
                                                Estude a Primeira Aula</a>
                                        </div>
                                        <div v-else class="Progress">
                                            <div class="Progress-bar Progress-bar--color13 u-m-b-5">
                                                <div class="Progress-loading Progress-loading--color30"
                                                     role="progressbar"
                                                     v-bind:aria-valuenow="subject.percentageMade*100"
                                                     v-bind:style="'width:'+subject.percentageMade*100+'%'"
                                                     aria-valuemin="0" aria-valuemax="100"
                                                ></div>
                                            </div>
                                            <p class="Progress-count">
                                                {{("0" + (subject.percentageMade*100).toString().split(".")[0]).slice(-2)}}%
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script src="https://www.gstatic.com/firebasejs/3.7.0/firebase.js"></script>

<script>

    export default {
        props : [
            'subjects' ,
            'totalStudied',
            'userId',
            'token'
        ],

        data(){
            return {
                loading:true,
                subjectsCourses: []
            }
        },


        mounted() {
            let data = {
                totalStudied : parseInt(this.totalStudied),
            };

            for(let subject of JSON.parse(this.subjects)){
                for(let course of subject.courses){
                    this.subjectsCourses.push(course)
                }
            }



        },

    }


</script>
