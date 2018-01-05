<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">Visitas e Pageviews</div>
    </div>
    <div class="panel-body">
        <div class="chart">
            <canvas id="visitors" width=1000 height=250></canvas>
        </div>
    </div>
</div>

@section('extraJS')
@parent
<script>
var ctx = document.getElementById("visitors").getContext("2d");
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode(array_map(function($date) {return $date->format('d/m');}, $visitorsData->pluck('date')->toArray())) !!},
        datasets: [
            {
                label: 'Visitas',
                fill: false,
                backgroundColor: "rgb(5, 141, 199)",
                borderColor: "rgb(5, 141, 199)",
                pointBorderColor: "rgb(5, 141, 199)",
                pointBackgroundColor: "#0090d9",
                pointBorderWidth: 1,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgb(5, 141, 199)",
                pointHoverBorderColor: "rgb(5, 141, 199)",
                pointHoverBorderWidth: 2,
                data: {!! json_encode($visitorsData->pluck('visitors')) !!},
            },
            {
                label: 'Pageviews',
                fill: false,
                backgroundColor: "rgb(170, 223, 243)",
                borderColor: "rgb(170, 223, 243)",
                pointBorderColor: "rgb(170, 223, 243)",
                pointBackgroundColor: "#fff",
                pointBorderWidth: 1,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgb(170, 223, 243)",
                pointHoverBorderColor: "rgb(170, 223, 243)",
                pointHoverBorderWidth: 2,
                data: {!! json_encode($visitorsData->pluck('pageViews')) !!},
            }
        ]
    }
});
</script>
@stop
