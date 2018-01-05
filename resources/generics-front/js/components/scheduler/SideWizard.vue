<!--
@Component:
    select-subject
@Description:
    Control page side wizard component.
@CalledComponents:
@ApiRoutes:
@WebRoutes:
@Props:
@Constants:
@TODO:
-->



<template xmlns:v-model="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div>
        <aside class="Sidebar col-md-2 col-sm-3 u-m-t-40">
            <ul class="Sidebar-menu">
                <li class="Sidebar-item Sidebar-item--title">
                    <h4 class="Sidebar-title" style="color: #292929;">Controle</h4>
                </li>
                <li v-bind:class="'Sidebar-item ' + (tab == 2 ? 'active' : (tab > 2 ? 'disabled':'')) ">
                    <span class="Sidebar-link" title="Tempo Disponível">Tempo Disponível</span>
                </li>
                <li v-bind:class="'Sidebar-item ' + (tab == 3 ? 'active' : (tab > 3 ? 'disabled':''))">
                    <span class="Sidebar-link" title="Disciplinas">Disciplinas</span>
                </li>
                <li v-bind:class="'Sidebar-item ' + (tab == 4 ? 'active' : (tab > 4 ? 'disabled':''))">
                    <span class="Sidebar-link" title="Ciclo">Ciclo</span>
                </li>

                <div style="text-align: center">
                    <div v-if="returnToCycle">
                        <button  v-on:click="function(){updateStep(-tab +4)}" type="submit"
                                 class="Button Button--default btn-block Button--defaultGreen">
                            Retornar Para Ciclo
                        </button>
                    </div>

                    <li v-if="tab==4" class="Sidebar-item">
                        <a href="#" v-on:click="function(){ updateStep(-3)}"
                           class="Button Button--default Button--defaultGreen">Refazer Ciclo</a>
                    </li>

                    <div v-if="tab==4" class="Sidebar-item">
                        <a href="#" v-on:click="resetCycle = true"
                           class="Button Button--default btn-block Button--defaultBlueFull ">Zerar Ciclo</a>
                    </div>
                </div>
            </ul>
        </aside>
        <transition name="modal" v-if="resetCycle">
            <div class="Modal-mask">
                <div class="Modal-wrapper">
                    <div class="Modal-container">

                        <div class="Modal-body">
                            <slot name="body">
                                Tem certeza que deseja Zerar Seu ciclo?
                            </slot>
                        </div>
                        <div class="Modal-footer">
                            <slot name="footer">
                                <button class="Button Button--default Button--defaultBlueFull" v-on:click="$emit('child-reset-cycle')">
                                    OK
                                </button>
                                <button class="Button Button--default Button--defaultDanger" v-on:click="resetCycle = false">
                                    Cancelar
                                </button>
                            </slot>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>

    export default {
        props:{
            tab:{
                default: 0
            },
            returnToCycle: {
                default : false
            }
        },
        data(){
            return{
                resetCycle : false
            }
        },
        methods:{

            updateStep(amt){
                let data = {}

                this.$emit('child-update-step',data,amt)
            },

        }

    }
</script>
