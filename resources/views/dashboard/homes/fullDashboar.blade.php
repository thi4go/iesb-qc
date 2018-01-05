@extends('dashboard.templates.default')
<body class='dashboard fulldashBoard'>
@section('content')

    <section class="Dashboard Dashboard--section u-m-t-40 u-m-b-40">
        <div class="container">
            <div class="row">
                <header class="Dashboard-header col-sm-12 u-m-b-20">
                    <h2 class="Dashboard-title Dashboard-title--color30">Sua evolução</h2>
                </header>
                <div class="Dashboard-content col-sm-12">
                    <div class="Widget">
                        <div class="Widget-bgWhite Widget--border Widget-padding">
                            <canvas id="resultChart" width="600" height="400"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="Dashboard Dashboard--section u-m-t-40 u-m-b-40">
        <div class="container">
            <div class="row">
                <header class="Dashboard-header col-sm-12 u-m-b-20">
                    <h2 class="Dashboard-title Dashboard-title--color30">Seu tempo de estudo em horas líquidas</h2>
                </header>
                <div class="Dashboard-content col-sm-12">
                    <div class="Widget">
                        <div class="Widget-bgWhite Widget--border Widget-padding">
                            <canvas id="cycle-history" width="600" height="400"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('dashboard.homes.subject')

    @include('dashboard.partials.steps')

    <script>

    </script>

@endsection
