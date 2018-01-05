<!--
@Component:
    course-wrapper
@Description:
    Page that displays available coursers.
@CalledComponents:
@ApiRoutes:
@WebRoutes:
  /dashboard/materias/{subjectId}
@Props:
    course  : JSON with course information to be displayed in card.
@Constants:
@TODO:
-->

<template>
    <div style="margin-top: 100px">
        <section class="Module container u-m-t-40">
            <div class="row">
                <header class="Module-header col-sm-10 col-sm-offset-1 sr-only">
                    <h2 class="Section-title">Módulos</h2>
                </header>

                <article v-for="n in 2" class="Module-content">
                    <div class=" col-sm-12 col-md-6" style="position: relative;">
                        <div v-for="(course, i) in courses">
                            <course-card
                                    v-if="i % 2 == n - 1"
                                    :course = "course"></course-card>
                        </div>
                    </div>
                </article>
            </div>
        </section>
    </div>
</template>


<script>
    export default {
        props: {
            courses: {
                type: [Object, Array]
            },
            user: {
                type: Object
            }
        },

        data() {
            return {
                courseClicked   : false,
                idcourseClicked : 0,
                course          : null
            }
        },

        mounted() {
        },

        methods: {

        }
    }


</script>
