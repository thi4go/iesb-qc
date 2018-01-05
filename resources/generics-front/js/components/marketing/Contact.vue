<!--
@Component:
    contact-info
@Description:
    Component with EduQC contact info and location map.
@CalledComponents:
@ApiRoutes:
@WebRoutes:
@Props:
@TODO:
-->

<template>
    <div class="container">
        <div class="contact col-sm-12" style="text-align: center;">
            <h2>Contate-nos:</h2>
            <p><span class="fa fa-whatsapp"></span> +55 (61) 99646 7887 </p>
            <p v-if="typeof contactEmail !== 'undefined'"><span class="fa fa-envelope"></span> {{contactEmail}}</p>
            <p><span class="fa fa-location-arrow"></span> SHIS QI 29 CL, Bloco C, Ed. Dom Bosco, Sala 103</p>
            <div>
                <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1919.3266076240675!2d-47.80506409177407!3d-15.82222924725849!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x935a231d94f0bff3%3A0x4c68a0e8707293d1!2sSt.+de+Habita%C3%A7%C3%B5es+Individuais+Sul+QI+29+Conj.+4+-+Lago+Sul%2C+Bras%C3%ADlia+-+DF!5e0!3m2!1spt-BR!2sbr!4v1489067144141"
                        width="40%" height="100%" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            contactEmail:{
                type:String
            }
        },
        data(){
            return {
            }
        },

        mounted() {
        },
    }
</script>
