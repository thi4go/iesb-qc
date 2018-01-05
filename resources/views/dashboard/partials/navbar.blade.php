
      <?php
      if(session()->has('user')){

          $firstName = explode(' ', session()->get('user')->name);
          $firstName = ucfirst($firstName[0]);

          $url       = session()->get('user')->avatar;

          $avatar =  $url;

      } else {
          $firstName = "";
          $avatar = "";
      }
      ?>

      <nav-bar-vue
              avatar="{{$avatar}}"
              name="{{$firstName}}"
              title="IESB - EXAME DA OAB"
              tabs='[
                        {"name": "Home", "url": "/dashboard/", "icon": "fa fa-home" , "activeClass": "Navbar-active"},
                        {"name": "Simulado",   "url": "/dashboard/simulado/landing", "icon": "fa fa-line-chart","activeClass": "Navbar-active" },
                        {"name": "Controle",   "url": "/dashboard/controle", "icon": "fa fa-calendar", "activeClass": "Navbar-active" },
                        {"name": "Teoria",     "url": "/dashboard/materias", "icon": "fa fa-book", "activeClass": "Navbar-active"},
                        {"name": "1ª Fase",    "url": "/dashboard/filtro", "icon": "fa fa-star-half-o", "activeClass": "Navbar-active"},
                        {"name": "2ª Fase", "url": "/dashboard/discursivas", "icon": "fa fa-star", "activeClass": "Navbar-active"}]'
      ></nav-bar-vue>
