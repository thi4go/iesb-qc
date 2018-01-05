<!--
@Component:
    availability
@Description:
    Page in which user selects the study time availability
@CalledComponents:
    1 - vue2-timepicker
@ApiRoutes:
@WebRoutes:
@Props:
@Constants:
@TODO:
    1 - Bind enter to select timepicker time
-->


<template xmlns:v-model="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div class="Dashboard-content Cycle">
        <div class="Widget">
            <div class="Widget-bgWhite Widget--border Widget-padding">
                <div class="Widget-header col-sm-10 u-m-t-40 u-m-b-20">
                    <h3 class="Widget-title Widget-title--min Widget-title--color40 u-bold">Qual seu tempo disponível para estudo?</h3>
                </div>
                <div class="Widget-content col-sm-10">
                    <p class="Widget-text Widget-text--tiny">Insira o tempo que planeja estudar abaixo, e inicie seu ciclo</p>
                    <div class="row">

                        <div id="time_week_group" class="col-sm-3 u-m-t-20">
                            <div class="form-group col-sm-12">
                                <label for="time_week" class="Form-label u-m-b-10">Dias da semana: </label>
                                <vue-timepicker id="time_week"  :minute-interval="25" v-model="allWeekDays"></vue-timepicker>
                            </div>
                            <div class="col-sm-12 Cycle">
                                <div class="link-collapse">
                                    <a href="#" v-on:click="changeManually" type="button" data-toggle="collapse" data-target="#days_of_week" aria-expanded="false"  aria-controls="collapseDays">
                                        Definir Diariamente
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 u-m-t-20">
                            <div class="form-group col-sm-12">
                                <label for="time_sat" class="Form-label u-m-b-10">Sábado:</label>
                                <vue-timepicker id="time_sat"  :minute-interval="25" v-model="sat"></vue-timepicker>
                            </div>
                        </div>
                        <div class="col-sm-3 u-m-t-20">
                            <div class="form-group col-sm-12">
                                <label for="time_sun" class="Form-label u-m-b-10">Domingo:</label>
                                <vue-timepicker id="time_sun"  :minute-interval="25" v-model="sun"></vue-timepicker>
                            </div>
                        </div>

                        <!--Collapse items of the week-->
                        <div class="collapse text-center col-sm-12 u-m-b-30" id="days_of_week">
                            <div class="row">
                                <div class="col-sm-3 u-m-t-20">
                                    <div class="form-group col-sm-12">
                                        <label for="time_mon" class="Form-label u-m-b-10">Segunda:</label>
                                        <vue-timepicker id="time_mon"  :minute-interval="25" v-model="mon"></vue-timepicker>
                                    </div>
                                </div>
                                <div class="col-sm-3 u-m-t-20">
                                    <div class="form-group col-sm-12">
                                        <label for="time_tue" class="Form-label u-m-b-10">Terça:</label>
                                        <vue-timepicker id="time_tue"  :minute-interval="25" v-model="tue"></vue-timepicker>
                                    </div>
                                </div>
                                <div class="col-sm-3 u-m-t-20">
                                    <div class="form-group col-sm-12">
                                        <label for="time_wed" class="Form-label u-m-b-10">Quarta:</label>
                                        <vue-timepicker id="time_wed"  :minute-interval="25" v-model="wed"></vue-timepicker>
                                    </div>
                                </div>
                                <div class="col-sm-3 u-m-t-20">
                                    <div class="form-group col-sm-12">
                                        <label for="time_thu" class="Form-label u-m-b-10">Quinta:</label>
                                        <vue-timepicker id="time_thu"  :minute-interval="25" v-model="thu"></vue-timepicker>
                                    </div>
                                </div>
                                <div class="col-sm-3 u-m-t-20">
                                    <div class="form-group col-sm-12">
                                        <label for="time_fri" class="Form-label u-m-b-10">Sexta:</label>
                                        <vue-timepicker id="time_fri"  :minute-interval="25" v-model="fri"></vue-timepicker>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--End collapse-->
                    </div>
                    <!--Buttons of navigation-->
                    <div class="row u-m-t-40 col-sm-offset-3">
                        <div class="col-xs-6 col-sm-3">
                            <button v-on:click="updateStep(1)" id="availability-submit-btn" type="submit" class="Button Button--small  text-center
                            Button--default Button--defaultGreen" title="Próximo">
                                Próximo
                            </button>
                        </div>
                    </div>
                        <!-- end navigation buttons -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import VueTimepicker from 'vue2-timepicker'

    export default {
        components: { VueTimepicker },
        data(){
            return{
                weekManually : false,
                allWeekDays: {
                    HH: "04",
                    mm: "00",
                },
                sat: {
                    HH: "00",
                    mm: "00",
                },
                sun: {
                    HH: "00",
                    mm: "00",
                },
                mon: {
                    HH: "04",
                    mm: "00",
                },
                tue: {
                    HH: "04",
                    mm: "00",
                },
                wed: {
                    HH: "04",
                    mm: "00",
                },
                thu: {
                    HH: "04",
                    mm: "00",
                },
                fri: {
                    HH: "04",
                    mm: "00",
                },
            }
        },
        methods : {
            changeManually(){
                this.weekManually = !this.weekManually
            },
            updateStep(amt){

                let data = {};

                let totalTime = 0;
                if(this.weekManually){
                    data = {
                        sat : this.sat,
                        sun : this.sun,
                        mon : this.mon,
                        tue : this.tue,
                        wed : this.wed,
                        thu : this.thu,
                        fri : this.fri
                    }
                }
                else {
                    data = {
                        sat : this.sat,
                        sun : this.sun,
                        mon : this.allWeekDays,
                        tue : this.allWeekDays,
                        wed : this.allWeekDays,
                        thu : this.allWeekDays,
                        fri : this.allWeekDays
                    };

                }

                for(let i in data){

                    data[i].HH = parseInt(data[i].HH)
                    data[i].mm = parseInt(data[i].mm)

                    data[i] = (data[i].HH*60) + data[i].mm

                    totalTime += data[i];

                }
                data.totalTime = totalTime
                this.$emit('child-update-availability',data,amt)
            },


        }
    }
</script>
