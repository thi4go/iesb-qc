<!--
@Component:
    count-down
@Description:
    Component that shows a countdown to the end day passed by props. Called for promotion purposes
@CalledComponents:
@ApiRoutes:
@WebRoutes:
@Props:
    weekDay     : start weekday received by server
    hours       : start hours received by server
    minutes     : start minutes received by server
    seconds     : start seconds received by server
    endDay      : day that promotion ends
@TODO:
    1 - Change style location
-->

<style type="text/css">
    .Countdown {
        text-align: center;
        background-color: #016db9;
        color: #ffffff;
        padding: 15px 10px;
        margin-bottom: 30px;
        overflow: hidden;
    }

    .Countdown-title {
        margin-top: 0;
        font-size: 0.688em;
        text-transform: uppercase;
        font-weight: 700;
    }

    .Countdown-divisor {
        font-size: 1.375em;
        font-weight: 700;
        height: 100%;
    }

    .Countdown-counter {
        display: inline-block;
        margin: 0 auto;
        width: 195px;
    }

    .Countdown-day, .Countdown-hour, .Countdown-minute, .Countdown-second, .Countdown-divisor {
        float: left;
        display: inline-block;
        margin: 0 3px;
    }

    .Countdown-day {
        margin: 0 12px 0 0;
    }

    .Countdown-number {
        display: block;
        font-size: 1.725em;
        font-weight: 700;
        line-height: 1em;
    }

    .Countdown-text {
        font-size: 0.750em;
    }

    .Counter-time {
        font-weight: 700;
        font-size: 3.125em;
        color: #ffffff;
    }

    @media screen and (max-width: 767px) {
        .Brand{
            text-align: center;
        }

    }

</style>

<template xmlns:v-model="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">

    <!-- Timer -->
    <div>
        <div class="col-xs-12 col-sm-6 col-md-3">
            <div class="Countdown">
                <h4 class="Countdown-title"><span id="message"></span></h4>
                <div class="Countdown-counter" style="padding-left: 17px;">
                    <!-- Dias -->
                    <div class="Countdown-day">
                        <span class="Countdown-number" id="days"></span>
                        <span class="Countdown-text">dias</span>
                    </div>
                    <!-- End Dias -->
                    <!-- Horas -->
                    <div class="Countdown-hour">
                        <span class="Countdown-number" id="hours"></span>
                        <span class="Countdown-text">horas</span>
                    </div>
                    <!-- End Horas -->
                    <div class="Countdown-divisor">:</div>
                    <!-- Minutos -->
                    <div class="Countdown-minute">
                        <span class="Countdown-number" id="minutes"></span>
                        <span class="Countdown-text">mins</span>
                    </div>
                    <!-- End Minutos -->
                    <div class="Countdown-divisor">:</div>
                    <!-- Segundos -->
                    <div class="Countdown-second">
                        <span class="Countdown-number" id="seconds"></span>
                        <span class="Countdown-text">segs</span>
                    </div>
                    <!-- End Segundos -->
                    <div id="subscribe_text"></div>
                </div>
            </div>
        </div>
        <!-- End Timer -->
    </div>
</template>

<script>
    export default {
        props : [
            'weekDay',
            'hours',
            'minutes',
            'seconds',
            'endDay',
        ],

        data(){
            return {
                daysDisplay: 0,
                hoursDisplay: 0,
                minutesDisplay: 0,
                secondsDisplay: 0,
            }
        },
        mounted() {
            let weekDay = parseInt(this.weekDay);
            let hours = parseInt(this.hours);
            let minutes = parseInt(this.minutes);
            let seconds = parseInt(this.seconds);
            let displayDays, displayHours , displayMinutes , displaySeconds, message;


            setInterval(function(){

                seconds += 1;

                if(seconds > 59){
                    seconds = 0;
                    minutes += 1
                }
                if(minutes > 59){
                    minutes = 0;
                    hours += 1
                }
                if(hours > 23){
                    hours = 0;
                    if(weekDay == 6)
                        weekDay = 0;
                    else
                        weekDay += 1
                }

                if(weekDay == 6 || weekDay == 0){
                    displayDays = (weekDay == 0 ? 0 : (7 - weekDay));
                    message = "A promoção começa em:";

                    // if to change the subscribe text once
                    if(document.getElementById("subscribe_text").innerHTML == "" ){
                        document.getElementById("subscribe_text").innerHTML = ""
                    }
                }else{
                    displayDays = 5 - weekDay;
                    message = "A promoção acaba em:";
                    if(document.getElementById("subscribe_text").innerHTML == "" ){
                        document.getElementById("subscribe_text").innerHTML = ""
                    }

                }

                displayHours = 23 -  hours;
                displayMinutes = 59  -  minutes;
                displaySeconds = 59  -  seconds;

                document.getElementById("seconds").innerHTML    = ("0" +
                displaySeconds).slice(-2);
                document.getElementById("minutes").innerHTML    = ("0" +
                displayMinutes).slice(-2);
                document.getElementById("hours").innerHTML      = ("0" +
                displayHours).slice(-2);
                document.getElementById("days").innerHTML       = ("0" +
                displayDays).slice(-2);
                document.getElementById("message").innerHTML    = message;


            }, 1000);
        },


    }
</script>
