<!--
@Component:
    lesson-wrapper
@Description:
    Management of article or lesson displaying
@CalledComponents:
    1 - lesson-article
    2 - lesson-video
@ApiRoutes:
@WebRoutes:
    /dashboard/materias/{courseId}/{relatedId}
@Props:
    lesson	: lesson information
    course	: course information
    related	: lessons related to  course
    userId  : user id
    token   : user token authentication
@Constants:
@TODO:
-->

<template>
    <div style="margin-top:70px">
        <div v-if="lesson.type == 1">
            <lesson-article
                :course  = "course"
                :lesson  = "lesson"
                :related = "related"
                :user-id  = "userId"
                v-on:child-user-made = "sendUserMadeRequest"
            ></lesson-article>
        </div>
        <div v-else-if="lesson.type == 2">
            <lesson-video
                :course  = "course"
                :lesson  = "lesson"
                :related = "related"
                v-on:child-user-made = "sendUserMadeRequest"
            ></lesson-video>
        </div>
    </div>
</template>


<script>
    export default {

        props: {
            course: {
                type: Object
            },
            lesson: {
                type: Object
            },
            related: {
                type: [Object, Array]
            },
            userId: {
                type: Number
            },
            token: {

            }
        },


        data() {
            return {

            }
        },

        mounted() {

        },

        methods: {
            sendUserMadeRequest: function() {
                this.$http.get(window.api+'user-lessons/'+this.userId+'/'+this.lesson.id)
            }
        }
    }



</script>
