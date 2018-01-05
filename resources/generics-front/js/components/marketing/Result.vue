<template xmlns:v-model="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <section>
        <div class="container-fluid">
            <div class="Consult-result container">
                <div class="row text-center">
                    <h2>
                        {{title}}
                    </h2>
                    <h4>
                        {{subtitle}}
                    </h4>
                    <div class="col-sm-12">
                        <carousel-3d
                                :autoplay="true"
                                :autoplayTimeout="6000"
                                :autoplayHoverPause="true"
                                :controlsVisible="true"
                                :perspective="20"
                                :display="3"
                                :loop="true"
                                :height="300"
                                :inverseScaling="50"

                        >
                            <slide :index="index" class="container text-left" v-for="(depoiment,index) in depoiments"
                                   style="background-color: #FFFFFF;border: transparent">
                                <div class="baloon">
                                    <p>
                                        "{{depoiment.text}}"
                                    </p>
                                </div>
                                <div class="author">
                                    {{depoiment.author}},
                                    <a target="_blank" :href="depoiment.link"> {{depoiment.site}}</a>
                                </div>

                            </slide>

                        </carousel-3d>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>

    import { Carousel3d, Slide } from 'vue-carousel-3d';

    export default{
        props : [
            'title',
            'subtitle',
            'depoiment'
        ],
        data(){
            return {
                depoiments: "",
                slidesnumber: 3,
                heightValue:300,
                index:"1"
            }
        },
        beforeDestroy: function () {
            window.removeEventListener('resize', this.handleResize)
        },
        components: {
            Carousel3d,
            Slide
        },
        mounted() {
            // parses JSON received as props
            // linking direct with props was not working
            this.handleResize();
            this.depoiments = JSON.parse(this.depoiment);
            window.addEventListener('resize', this.handleResize)


        },
        methods: {
            // whenever the document is resized, re-set the 'fullHeight' variable
            handleResize (event) {
                let width = document.documentElement.clientWidth;
                if(width > 950){
                    this.slidesnumber = 3;
                    this.heightValue = 300;
                }else if(width<350){
                    this.slidesnumber = 3;
                    this.heightValue = 300;
                }else{
                    this.slidesnumber = 3;
                    this.heightValue = 300;
                }
            }
        }

    }
</script>