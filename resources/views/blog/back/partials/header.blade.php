<!-- Header -->
<div class="header ">

    <!-- Start Mobile -->
    <div class="container-fluid relative">
        <div class="pull-left full-height visible-sm visible-xs">
            <div class="header-inner">
                <a href="#" class="btn-link toggle-sidebar visible-sm-inline-block visible-xs-inline-block padding-5" data-toggle="sidebar">
                    <span class="fa fa-bars fs-16"></span>
                </a>
            </div>
        </div>
        <div class="pull-center hidden-md hidden-lg">
            <div class="header-inner">
                <div class="brand inline">
                    <img src="{{ asset('/brzbox/assets/img/brzLogo.png') }}" alt="logo" data-src="{{ asset('/brzbox/assets/img/brzLogo.png') }}" data-src-retina="{{ asset('/brzbox/assets/img/brzLogo2x.png') }}" width="94" height="22">
                </div>
            </div>
        </div>
        <div class="pull-right full-height visible-sm visible-xs">
            <div class="header-inner">
                <a href="{{ route('painel.auth.logout') }}" class="btn-link visible-sm-inline-block visible-xs-inline-block padding-5 text-danger" title="Sair">
                    <i class="fa fa-power-off fs-16"></i>
                </a>
            </div>
        </div>
    </div>
    <!-- End Mobile -->

    <!-- Start Desktop -->
    <div class=" pull-left sm-table hidden-xs hidden-sm">
        <div class="header-inner">
            <div class="brand inline">
                <img src="{{ asset('/brzbox/assets/img/brzLogo.png') }}" alt="logo" data-src="{{ asset('/brzbox/assets/img/brzLogo.png') }}" data-src-retina="{{ asset('/brzbox/assets/img/brzLogo2x.png') }}" width="94" height="22">
            </div>
        </div>
    </div>
    <div class=" pull-right">
        <div class="header-inner">
            <a href="{{ route('painel.auth.logout') }}" class="btn-link m-l-20 sm-no-margin hidden-sm hidden-xs text-danger" title="Sair">
                <i class="fa fa-power-off fs-16"></i>
            </a>
        </div>
    </div>
    <div class=" pull-right">
        <div class="visible-lg visible-md m-t-10">
            <div class="pull-left p-r-10 p-t-10 fs-16 font-heading">
                <span class="semi-bold">Olá</span>
                <span class="bold">{{ Sentinel::getUser()->first_name }}</span>
            </div>
            <div class="dropdown pull-right">
                <button class="profile-dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="thumbnail-wrapper d32 circular inline m-t-5">
                        <img src="{{ Sentinel::getUser()->avatar }}" alt="Foto de perfil" data-src="{{ Sentinel::getUser()->avatar }}" width="32" height="32">
                    </span>
                </button>
                <ul class="dropdown-menu profile-dropdown" role="menu">
                    <li>
                        <a href="{{ route('painel.account.index') }}" title="Meu Perfil">
                            <i class="pg-user"></i> Meu Perfil
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- End Desktop -->

</div>
<!-- End Header -->
