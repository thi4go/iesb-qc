<!--
@Component:
    timer
@Description:
    Displays a timer, that can emmit current time for parent.
@CalledComponents:
    vue-spinner
@ApiRoutes:
@WebRoutes:
    dashboard/reportar
@Props:
    feedBackTime    : flag that when is true emits the current time to parent
    automatedReset  : flag that reset timer when its feedbacktime
@TODO:
    1 - Receive initial time seed from server
-->

<template xmlns:v-model="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div class="Widget-bgBlue Widget-padding text-center">
        <div class="Counter">
            <h3 class="Widget-title Widget-title--color10 Widget-title--tiny u-bold">
                Meu tempo
            </h3>

            <div id="clock">{{ ("0" + hours).slice(-2)}} :
                {{ ("0" + minutes).slice(-2)}} :
                {{("0" + seconds).slice(-2)}}</div>

            <div v-if="!isPaused">
                <button id="pause"
                        class="Button Button--default Button--defaultWhiteBlue"
                        title="Pausar"
                        v-on:click="isPaused = true" >Pausar</button>
            </div>
            <div v-else>
                <button id="play"
                        class="Button Button--default Button--defaultWhiteBlue"
                        title="Iniciar"
                        v-on:click="isPaused = false" >Iniciar</button>
            </div>

        </div>
    </div>

</template>

<script>
    export default {
        props : {
            feedBackTime:{
                default: false
            },
            automatedReset: {
                default: false
            },
            pauseTimer:{
                default:false
            }
        },

        data(){
            return {
                hours: 0,
                minutes: 0,
                seconds: 0,
                isPaused: false,
            }
        },
        mounted() {
            let scope = this;

            setInterval(function(){
                if(!scope.isPaused){
                    scope.seconds += 1;
                    if(scope.seconds > 59){
                        scope.seconds = 0;
                        scope.minutes += 1;
                    }
                    if(scope.minutes > 59){
                        scope.minutes = 0;
                        scope.hours += 1;
                    }
                }



            }, 1000);
        },

        methods:{
            resetTimer: function(){
                this.hours = 0;
                this.minutes = 0;
                this.seconds = 0;
                this.isPaused = false;
            }
        },


        watch:{
            feedBackTime: function() {
                if(this.feedBackTime){
                    this.$emit('child-msg', ("0" + this.hours).slice(-2) + ":" +
                        ("0" + this.minutes).slice(-2) + ":" +
                        ("0" + this.seconds).slice(-2))

                    if(this.automatedReset){
                        this.resetTimer()

                    }
                }
            },
            pauseTimer(){
                this.isPaused = this.pauseTimer
            }
        }


    }
</script>
