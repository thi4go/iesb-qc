<template xmlns:v-model="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">

    <section class="menu">
        <div class="container-fluid">
            <div class="Consult-faq container">
                <div class="row">
                    <div class="col-sm-12">
                        <h2 class="menu-header">Assuntos</h2>
                        <div v-for="(course,id) in localCourses">

                            <div class="col-xs-12">
                                <div class="col-xs-12">

                                    <h4 class="menu-title"  v-on:click="course.show = !course.show">
                                        <i v-if="!course.show" class="fa fa-plus-square text-right" aria-hidden="true"/>
                                        <i v-else class="fa fa-minus-square text-right" aria-hidden="true"/>
                                        {{course.text}}
                                    </h4>
                                </div>
                            </div>
                            <div v-if="course.show" class="col-xs-12" >
                                <article v-for="n in 2" class="Module-content">
                                    <div class=" col-sm-12 col-md-6" style="position: relative;" >
                                        <div v-for="(coursea, index) in course.courses" >
                                            <course-card
                                                    v-if="index % 2 == n - 1"
                                                    :course = "coursea"></course-card>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    export default{
        props : [],
        data(){
            return {
                localCourses : []
            }
        },
        mounted() {
            let scope = this;
            this.$http.get(window.api+'areas/').then(response=>{
                scope.localCourses = JSON.parse(JSON.stringify(response.data));

            })


        },

        methods : {
            toggleCourse(course){
                course.show = !course.show
            }
        }


    }
</script>

<style lang="scss" scoped>
    .menu{
    margin-top:70px;
    &-title{
         cursor: pointer;
     }
    &-header{
         text-align: center;
         color: #016db9;
     }
    }
</style>