<template xmlns:v-model="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <section class="Dashboard Dashboard--section u-m-b-40">
        <div class="container">
            <full-quiz-graph

                    v-if = "!loadingQuiz"
                    :all-quizzes = "allQuizzes"
                    :userId="userId"
            >
            </full-quiz-graph>
            <moon-loader v-else style="margin: auto" color="#eb2341">

            </moon-loader>

        </div>
    </section>
</template>

<script>
    import MoonLoader from 'vue-spinner/src/MoonLoader.vue'

    export default {
        props : [
            'subjects' ,
            'totalStudied',
            'userId',
            'userEfficiency'
        ],
        components:{
            MoonLoader
        },
        data(){
            return {
                loadingCurrentCycle : true,
                loadingQuiz         : true,
                loadingCycle        : true,
                subjectsCourses     : [],
                allFirebaseCycle    : [],
                firebaseCycle       : [],
                allQuizzes          : []
            }
        },


        mounted() {
            let ref   = window.firebaseQuiz.ref('/users/' + this.userId);
            let allCyclesRef = window.firebaseSchedule.ref('/users/' + this.userId + '/schedule/');
            let currentCycle = window.firebaseSchedule.ref('/users/' + this.userId + '/schedule/').limitToLast(1);

            let scope = this;

            currentCycle.once('value',function(snapshot){
                if(snapshot.val() !== null){
                    let key = Object.keys(snapshot.val())[0];
                    scope.loadingCurrentCycle = false;
                    scope.firebaseCycle = snapshot.val()[key];
                }
            })
            ref.on('value', function(snapshot) {
                scope.allQuizzes = snapshot.val();
                scope.loadingQuiz = false;
            })

            allCyclesRef.once('value',function(snapshot){
                scope.allFirebaseCycle = snapshot.val();
                scope.loadingCycle = false;
            })
        },

    }


</script>
