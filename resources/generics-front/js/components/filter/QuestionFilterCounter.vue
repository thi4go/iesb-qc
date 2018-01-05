<!--
@Component:
    question-filter-counter
@Description:
    Display number of questions.
@CalledComponents:
@ApiRoutes:
@WebRoutes:
@Props:
    n        : number displayed
    loading  : flag to show loading spinner or not
@TODO:
-->

<template xmlns:v-model="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <p v-if="!showLoader" class="Widget-text Widget-text--count Widget-text--color30 u-bold">
        <span v-if="n != 0 ">{{ n }}</span>
        <span v-else>Em Breve!</span>
    </p>
    <moon-loader v-else style="margin: 15px" color="#eb2341"></moon-loader>
</template>

<script>
    import MoonLoader from 'vue-spinner/src/MoonLoader.vue'
    export default {

        props: [
            'n',
            'loading'
        ],

        components: {
            MoonLoader
        },

        data() {
            return {
                showLoader: false
            }
        },

        watch:  {
            loading: function() {
                if(this.loading)
                    this.showLoader = true
                else
                    this.showLoader = false
            },
            n: function() {
                this.$emit('child-count-changed')
            }
        }



    }
</script>
