<!--
@Component:
    nav-bar-vue
@Description:
    Simple collapsible and toggleable top navbar to paginate through tabs.
    'Entrar' and 'Sair' buttons included according to name and avatar info
    passed by props
@CalledComponents:
@ApiRoutes:
@WebRoutes:
@Props:
    avatar: string of the user image url. If it is null or man.jpg, a default
        avatar icon is shown
    name:   string containing users name
    tabs:   JSON passed as string, containing tab name and link that goes to.
            Ex: tabs = '[{"name": "home", "url": "/home"},
                         {"name": "exit", "url": "/exit"}]'
@TODO:
    1 - Pass background color by props;
    2 - Pass style by props
    3 - Top or bottom option by props
    4 - Toggleable option by props
    5 - Pass logo by props
-->

<template xmlns:v-model="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <!-- Navbar main container div -->
    <div class="" >
        <!-- Navbar main position and style -->
        <nav v-bind:class="['Navbar navbar navbar-default', !dropMenu ? 'navbar-fixed-top' :' ']" style="background-color: #f2f2f2;">
            <!-- Navbar default container (When not collapsed)-->
            <div class="container text-center">
                <!-- Navbar right and left content -->
                <div class="Navbar-header navbar-header">
                    <!-- Menu options button -->
                    <button v-on:click="dropMenu = !dropMenu"  type="button" class="navbar-toggle offcanvas-toggle"
                            data-toggle="offcanvas" data-target="#menu" aria-expanded="false">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!-- Navbar logo -->
                    <a class="Navbar-brand navbar-brand" href="/dashboard/" :title="title">
                        <img src="/assets/images/logo.png" :alt="title" class="img-responsive">
                    </a>
                </div>
                <!-- Navbar middle and left content -->
                <div class="Navbar-offcanvas navbar-offcanvas navbar-offcanvas-touch" id="menu" style="text-align: center;background-color: #f2f2f2;" >
                    <!-- Check if user was passed by props. If yes render its name and avatar.
                         'Entrar' or 'Sair' buttons rendered too. -->
                    <ul v-if="user" class="Navbar-nav nav navbar-nav navbar-right">
                        <li class="Navbar-item">
                            <a href="/dashboard/perfil" class="Navbar-link Navbar-link--user" title= "Acesse seu Perfil">
                                <img v-bind:src="localAvatar" class="Navbar-avatar" data-no-retina="true">
                                <span>Perfil</span></a>
                        </li>
                        <li class="Navbar-item Navbar-item--bg">
                            <a href="/dashboard/logout" class="Navbar-link" title="Sair">Sair</a>
                        </li>
                    </ul>
                    <ul v-else class="Navbar-nav nav navbar-nav navbar-right">
                        <li class="Navbar-item Navbar-item--bg">
                            <a href="/dashboard/login" class="Navbar-link" title="Entrar">Entrar</a>
                        </li>
                    </ul>
                    <!-- Tabs rendering -->
                    <ul class="Navbar-list nav navbar-nav ">
                        <li v-for="tab in parsedTabs">
                            <a :href="tab.url"  :class="[tab.isActive ? tab.activeClass : '' ]"
                               class="Navbar-link" :title="tab.name">
                                <i :class="tab.icon" aria-hidden="true"></i>
                                {{tab.name}}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!--Droppdown menu-->
            <div v-if="dropMenu" class="container" style="background-color:#f2f2f2;">
                <ul class="nav navbar-nav">
                    <hr>
                    <!--Tabs rendering-->
                    <li v-for="tab in parsedTabs" >
                        <a v-bind:href="tab.url" class="nav-link" active-class="active"
                           v-bind:title="tab.name">
                           <i :class="tab.icon" aria-hidden="true"></i>
                            {{tab.name}}
                        </a>
                        <hr>
                    </li>
                    <!-- 'Sair' and 'Entrar' redering -->
                    <li v-if="user">
                        <a href="/dashboard/perfil" class="nav-link" active-class="active"
                           title="Perfil">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            Perfil
                        </a>
                        <hr>
                        <a href="/dashboard/logout" class="nav-link" active-class="active"
                           title="Sair">
                            <i class="fa fa-sign-out" aria-hidden="true"></i>
                            Sair
                        </a>
                        <hr>
                    </li>
                    <li v-else>
                        <a href="/dashboard/login" class="nav-link" active-class="active"
                           title="Entrar">
                            Entrar
                        </a>
                        <hr>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</template>


<script>
    export default {
        props : [
            'avatar',
            'name',
            'tabs',
            'title'
        ],

        data(){
            return {
                user:false,
                localAvatar: "",
                dropMenu: false,
                parsedTabs: ""
            }
        },

        mounted() {
            // parses JSON received as props
            // linking direct with props was not working
            this.parsedTabs = JSON.parse(this.tabs)
            // check if username was passed
            if(this.name != null){
                if(this.name.length > 1)
                    this.user = true;
            }

            // check if avatar link exists
            if(this.avatar != null){
                if(this.avatar.length <= 1 || this.avatar.slice(-7) == "man.jpg")
                    this.localAvatar = "/assets/images/avatar_user.png"
                else
                    this.localAvatar = this.avatar
            }

            //set activated link
            for(let i in this.parsedTabs){
                if(this.parsedTabs[i].url == window.location.pathname)
                    this.parsedTabs[i].isActive = true;
            }

        },
    }
</script>
