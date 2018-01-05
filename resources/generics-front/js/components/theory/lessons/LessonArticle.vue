<!--
@Component:
    lesson-article
@Description:
    Article displaying
@CalledComponents:
@ApiRoutes:
@WebRoutes:
    /dashboard/materias/{courseId}/{relatedId}
@Props:
    lesson	: lesson information
    course	: course information
    related	: lessons related to  course
@Constants:
@TODO:
-->

<template>
    <div>
        <section class="Module container" xmlns="http://www.w3.org/1999/html">
            <div class="Dashboard Dashboard--section u-m-t-20">
                <h2 class="Dashboard-title Dashboard-title--color30">{{lesson.title }}</h2>
            </div>

            <div v-if="lesson.link">
                <iframe :src="lesson.link" width="100%" height="1000px"></iframe>
            </div>
            <div v-else-if="lesson.notice" class="row u-m-t-20">
                <div class="col-sm-12">
                    <div v-html="lesson.notice" class="Module-article" style="padding: 20px">
                    </div>
                </div>
            </div>
            <div v-else style="padding-top: 100px; padding-bottom: 100px">
                <div class="Lesson Lesson-title text-center">
                    <h2 class="Lesson-title--color40 u-m-b-30"> Essa aula ainda está em produção! </h2>
                    <div v-if="!sent">
                        <h3 class="Lesson-title--color20 u-m-b-10"> Gostaria de pedir prioridade para este assunto?</h3>
                        <Button v-if="!loading" @click="sendMail" class="Button Button--default Button--defaultBlueFull u-m-b-20">Pedir Prioridade</Button>
                        <pulse-loader v-else color="#eb2341"></pulse-loader>
                    </div>
                    <div v-if="success==false">Não foi possível concluir o pedido, tente novamente</div>
                    <div v-else-if="success==true">O seu pedido foi enviado, em breve a aula estará disponível!</div>
                </div>
            </div>
            <div class="row u-m-t-20">
                <div class="col-sm-12 text-right">
                    <div v-if="lesson.link || lesson.notice">
                        Estudado?
                        <span v-if="lesson.userMade">
                                <toggle-button @change="emitUserMade"
                                               :value="true"
                                               color="#a6ce38"
                                               :width="70"
                                               :labels="{checked: 'Sim', unchecked: 'Não'}"
                                />
                        </span>
                        <span v-else >
                            <toggle-button @change="emitUserMade"
                                           color="#a6ce38"
                                           :width="70"
                                           :value="false"
                                           :labels="{checked: 'Sim', unchecked: 'Não'}"
                            />
                        </span>
                    </div>

                    <div class="Card-content">
                        <div class="Card Card--module Card--fixedBorder">
                            <div class="Card-info">
                                <div class="Card-titleArea pull-left">
                                    <h2 class="Card-title">{{ lesson.title }}</h2>
                                </div>

                            </div>
                            <div class="Card-content">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <p class="Card-text">{{ lesson.details }}</p>
                                        <div class="Module-comments">
                                            <h4 class="Module-commentsTitle">Comentários</h4>
                                            <div class="fb-comments"  data-numposts="3"
                                                 data-width="100%" data-order-by="social"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4"  style="height: 100%">
                                        <h4 class="List-title">Entenda mais sobre os assuntos a seguir:</h4>
                                        <ul class="List list-unstyled" style="overflow-y: auto; height: 40em;">
                                            <div v-for="rel in related">
                                                <hr />
                                                <li class="List-item List-item--border">
                                                    <div class="List-content">
                                                        <div class="List-icon">
                                                            <i class="Icon Icon--fileTextBefore"
                                                               :style="'data-color:'+course.color+';'"></i>
                                                        </div>
                                                        <div class="List-details List-details--block">
                                                            <div v-if="rel.userMade">
                                                                <span style="text-decoration: line-through;">
                                                                    <a style="text-decoration: overline;"
                                                                       :href="'/dashboard/materias/'+course.id+'/'+rel.id" class="List-link" :title="rel.title">{{ rel.title }}</a>
                                                                </span>
                                                            </div>
                                                            <div v-else>
                                                                <a style="text-decoration: overline;"
                                                                   :href="'/dashboard/materias/'+course.id+'/'+rel.id"
                                                                   class="List-link" :title="rel.title">
                                                                    {{ rel.title }}</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </div>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>


<script>
    import PulseLoader from 'vue-spinner/src/PulseLoader.vue'

    export default {

        props: {
            lesson: {
                type: Object
            },
            course: {
                type: Object
            },
            related: {
                type: [Object, Array]
            },
            userId:{

            }
        },

        components: {
            PulseLoader
        },
        data() {
            return {
                sent: false,
                success: null,
                loading: false
            }
        },

        methods: {
            emitUserMade: function() {
                this.$emit('child-user-made');
            },
            sendMail(){
                let scope = this
                let data = {
                    userId      : this.userId,
                    subject     : "Prioridade Aula",
                    lessonTitle : this.lesson.title,
                    lessonSubject : this.course.title
                };

                scope.loading = true

                this.$http.post(window.local + 'dashboard/ask-lesson', data).then(response=>{
                    scope.loading = false
                    scope.success = true
                    scope.sent = true
                }).catch(error => {
                    scope.loading = false
                    scope.sent = false
                    scope.success = false
                })
            }
        }
    }



</script>