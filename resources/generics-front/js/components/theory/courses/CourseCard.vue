<!--
@Component:
    course-card
@Description:
    Page in which subjects to be studied are chosen when building control.
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
    <div class="Card Card--module">
        <div class="Card-info">
            <div v-if="(course.videos.length != 0) && (course.articles.length != 0)" class="Card-count pull-left">
                {{ course.videos.length }} Vídeo(s) | {{ course.articles.length }} Aula(s)
            </div>
            <div v-else-if="(course.videos.length == 0) && (course.articles.length != 0)" class="Card-count pull-left">
                {{ course.articles.length }} Aula(s)
            </div>
            <div v-else-if="(course.videos.length != 0) && (course.articles.length == 0)" class="Card-count pull-left">
                {{ course.videos.length }} Vídeo(s)
            </div>
            <div v-else class="Card-count pull-left">
                Em breve o conteúdo será disponibilizado
            </div>
        </div>
        <div class="Card-content">
            <div class="row">
                <div class="col-sm-7">
                    <h3 class="Card-title">{{ course.title }}</h3>
                    <p class="Card-text u-m-b-20">{{ course.details }}</p>
                    <a :href="'/dashboard/materias/'+course.id" class="Button Button--module btn" style="background-color: #eb2341"
                       title="Iniciar curso">iniciar curso</a>
                </div>
                <figure class="Card-figure col-sm-5 hidden-xs">
                    <img v-if="course.thumb != null" :src="course.thumb" :alt="course.title" class="img-responsive" data-no-retina>
                    <img v-else :src="'/assets/images/logo.png'" :alt="course.title" class="img-responsive" data-no-retina style="opacity: 0.75">
                </figure>
            </div>
        </div>
    </div>
</template>


<script>
    export default {
        props: {
            course: {
                type: Object
            }
        },


        mounted() {
        },

        methods: {

        }
    }
</script>
