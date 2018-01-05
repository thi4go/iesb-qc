<template>
    <aside class="Sidebar col-sm-3">
        <ul class="Sidebar-menu">
            <li class="Sidebar-item Sidebar-item--title">
                <h4 class="Sidebar-title">Configurações</h4>
            </li>
            <li v-bind:class="[step == 0 ? 'active':'','Sidebar-item']">
                <a v-on:click="updateStep(0)" class="Sidebar-link" title="Perfil">Perfil</a>
                <!--<a href="/dashboard/perfil" class="Sidebar-link" title="Perfil">Perfil</a>-->
            </li>
            <li v-bind:class="[step == 1 ? 'active':'','Sidebar-item']">
                <a v-on:click="updateStep(1)" class="Sidebar-link" title="Segurança">Segurança</a>
                <!--<a href="/dashboard/perfil/senha" class="Sidebar-link" title="Segurança">Segurança</a>-->
            </li>
            <li class="Sidebar-item Sidebar-item--title">
                <h4 class="Sidebar-title">Faturamento</h4>
            </li>
            <li v-bind:class="[step == 2 ? 'active':'','Sidebar-item']">
                <a v-on:click="updateStep(2)" class="Sidebar-link" title="Histórico">Histórico</a>
                <!--<a href="/dashboard/perfil/historico" class="Sidebar-link" title="Histórico">Histórico</a>-->
            </li>
        </ul>
    </aside>
</template>
<script>
    export default{
        data(){
            return{
                step : 0
            }
        },
        methods:{
            updateStep(step){
                this.step = step;
                this.$emit('update-step',step);
            }
        }
    }
</script>
<style scoped>
    .Sidebar-link{
        cursor:pointer ;
    }
</style>
