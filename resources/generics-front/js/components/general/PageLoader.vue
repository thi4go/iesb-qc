<!--
@Component:
    graph
@Description:
    Loading spinner component
@CalledComponents:
    vue-spinner
@ApiRoutes:
@WebRoutes:
@Props:
    options : object of js graph options like label text
    data    : dataset of js graph
    labels  : x
@TODO:
-->

<template xmlns:v-model="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div class="container" style="margin-top:10em">
        <clip-loader :color="color" ></clip-loader>
    </div>
</template>

<script>

    import ClipLoader from 'vue-spinner/src/ClipLoader.vue'
    import MoonLoader from 'vue-spinner/src/MoonLoader.vue'
    import SyncLoader from 'vue-spinner/src/SyncLoader.vue'
    import BeatLoader from 'vue-spinner/src/BeatLoader.vue'


    export default {
        props:[],
        components: {
            ClipLoader,
            MoonLoader,
            BeatLoader,
            SyncLoader
        },
        data () {
            return {
                loading : true,
                color: '#EB2341',
                height: '35px',
                width: '4px',
                margin: '2px',
                radius: '2px'
            }
        },
        mounted(){
        },

        methods:{

        }
    }
</script>
