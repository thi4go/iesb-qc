<!--
@Component:
    graph
@Description:
    Component that generates a line graphic
@CalledComponents:
@ApiRoutes:
@WebRoutes:
@Props:
    options : object of js graph options like label text
    data    : dataset of js graph
    labels  : x
@TODO:
    1 - Change style location
-->

<script>
    import { Line,mixins } from 'vue-chartjs'

    export default Line.extend({
        props: ["labels","data","options","width","height"],

        mounted () {
            this.renderChart({
                labels: this.labels,
                datasets: this.data,
                width: this.width,
                height: this.height
            }, this.options)
        },
        watch : {

            data : function(){
                this.chart = this.renderChart({
                    labels: this.labels,
                    datasets: this.data,
                }, this.options)
            }
        }
    })
</script>
