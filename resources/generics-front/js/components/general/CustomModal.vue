<!--
@Component:
    custom-modal
@Description:
    Component that displays a custom modal.
@CalledComponents:
@ApiRoutes:
@WebRoutes:
@Props:
    header      : header text
    icon        : icon displayed in modal
    closeButton : flag to show or not close button
    button-text : button text
    text        : text displayed on model body
@TODO:
    1 - Implement button
    2 - Implement close button
-->

<template xmlns:v-model="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div v-if="showModal" v-on:click="closeModal" >
        <transition name="Modal">
            <div class="Modal-mask">
                <div class="Modal-wrapper">
                    <div class="Modal-container">
                        <div class="Modal-header">
                               <h3>{{header}}</h3>
                        </div>
                        <div class="Modal-body">
                                {{text}}
                            <i v-bind:class="icon"></i>

                        </div>
                        <div class="Modal-footer">
                            <a v-if="closeButton" href="#" class="Button Button--default Button--defaultBlueFull"
                               v-on:click="closeModal">Fechar</a>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
    export default {
        props : [
            'header',
            'icon',
            'text',
            'closeButton',
            'button-text'
        ],

        data(){
            return {
                showModal: true
            }
        },
        mounted() {

        },
        methods:{
            closeModal(){
                this.showModal = false;
                this.$emit('close', this.showModal);
            }
        }


    }
</script>
