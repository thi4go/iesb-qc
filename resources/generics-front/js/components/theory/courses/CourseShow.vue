<!--
@Component:
    course-show
@Description:
    Page that displays course details, videos and material.
@CalledComponents:
@ApiRoutes:
@WebRoutes:
  /dashboard/materias/{courseId}/{videoId}
@Props:
    course  : JSON with course information to be displayed in card.
@Constants:
@TODO:
-->


<template>
  <div style="margin-top:70px">
    <section class="Module container">
      <div class="Breadcrumbs">
        <div class="container">
          <ol class="Breadcrumb list-inline  col-sm-pull-3 col-sm-6 col-md-pull-3 col-md-7" align="right" >
            <a href="/dashboard/controle"><i class="fa fa-arrow-left fa-2x" aria-hidden="true"></i></a>
            <li class="Breadcrumb-item hidden-xs">
              <span class="Breadcrumb-title">    Você está aqui:</span>
            </li>
            <li class="Breadcrumb-item">
              <a href="/dashboard/materias" v-on:click="courseClicked = false" class="Breadcrumb-link" title="Módulos">Módulos</a>
            </li>
            <li class="Breadcrumb-item Breadcrumb-item--active">
              {{ course.title }}
            </li>
          </ol>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-push-7 col-sm-4 col-md-push-8 col-md-4">
          <div class="Card Card--module" :data-border-color="course.color">
            <div class="Card-content">
              <figure class="Card-figure u-p-b-10">
                <img :src="course.image" :alt="course.title" class="img-responsive center-block" data-no-retina>
              </figure>
              <h3 class="Card-title" :data-color="course.color">{{ course.title}}</h3>
              <p class="Card-text">{{ course.details}}</p>
            </div>
          </div>
        </div>
        <div class="col-sm-pull-3 col-sm-6 col-md-pull-3 col-md-7">
          <div v-if="course.videos.length > 0" class="Card Card--module Card--fixedBorder">
            <div class="Card-info">
              <h4 class="Card-title">Vídeos</h4>
            </div>
            <div class="Card-content">
              <ul v-for="video in course.videos" class="List list-unstyled">
                <br />
                <li class="List-item">
                  <div class="List-content">
                    <div class="List-icon">
                      <i class="Icon Icon--playCircleBefore" :data-color="course.color"></i>
                    </div>
                    <div v-if="video.userMade" class="List-details">
                        <span style="text-decoration: line-through;">
                          <a :href="'/dashboard/materias/'+course.id+'/'+video.id"
                             class="List-link" :title="video.title">{{ video.title }}</a>
                        </span>
                    </div>
                    <div v-else class="List-details">
                      <a :href="'/dashboard/materias/'+course.id+'/'+video.id"
                         class="List-link" :title="video.title">{{ video.title }}</a>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
          <div v-if="course.articles.length > 0" class="Card Card--module Card--fixedBorder">
            <div class="Card-info">
              <h4 class="Card-title">Aulas</h4>
            </div>
            <div class="Card-content">
              <ul v-for="article in course.articles" class="List list-unstyled">
                <br>
                <li class="List-item">

                  <div class="List-content">
                    <div class="List-icon">
                      <i class="Icon Icon--fileTextBefore" :data-color="course.color"></i>
                    </div>
                    <div v-if="article.userMade" class="List-details">
                        <span style="text-decoration: line-through;">
                          <a :href="'/dashboard/materias/'+course.id+'/'+article.id" class="List-link" >{{ article.title }}</a>
                        </span>
                    </div>
                    <div v-else class="List-details">
                      <a :href="'/dashboard/materias/'+course.id+'/'+article.id" class="List-link">{{ article.title }}</a>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>

    export default {
        props: {
            course: {
                type: [Object, Array]
            }
        },

        data() {
            return {

            }
        },

        mounted() {
            this.title = this.course.title
        },

        methods: {

        }
    }

</script>
