<!-- Start Sidebar -->
<div class="page-sidebar" data-pages="sidebar">
    <div class="sidebar-header">
        <img src="{{ asset('/brzbox/assets/img/brzLogoWhite.png') }}" alt="logo" class="brand" data-src="{{ asset('/brzbox/assets/img/brzLogoWhite.png') }}" data-src-retina="{{ asset('/brzbox/assets/img/brzLogoWhite2x.png') }}" width="94" height="22">
    </div>
    <div class="sidebar-menu">
        <ul class="menu-items">

            <li class="m-t-30 {{ AppHelper\setActive('painel') }}">
                <a href="{{ route('painel.dashboard.index') }}" title="Home">
                    <span class="title">Home</span>
                </a>
                <span class="icon-thumbnail "><i class="fa fa-home"></i></span>
            </li>

            @foreach(Config::get('brz.modules') as $module)
                @if(Permission::has("painel.{$module['alias']}.read"))
                <li class="{{ AppHelper\setActive("painel/{$module['path']}*") }}">
                    <a href="{{ route("painel.{$module['alias']}.index") }}" title="{{ $module['name'] }}">
                        <span class="title">{{ $module['name'] }}</span>
                    </a>
                    <span class="icon-thumbnail "><i class="{{ $module['icon'] }}"></i></span>
                </li>
                @endif
            @endforeach

        </ul>
        <div class="clearfix"></div>
    </div>
</div>
<!-- End Sidebar -->
