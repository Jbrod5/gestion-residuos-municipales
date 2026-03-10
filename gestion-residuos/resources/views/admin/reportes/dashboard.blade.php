@extends('layouts.admin')

@section('title', 'Dashboard de reportes')

@section('content')
<div class="container-fluid">
    <h4 class="mb-4">Reportes municipales</h4>
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">Toneladas recolectadas por zona</div>
                <div class="card-body">
                    <canvas id="chart-basura-zona"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">Material reciclado por tipo</div>
                <div class="card-body">
                    <canvas id="chart-material"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">Denuncias recibidas vs atendidas (último mes)</div>
                <div class="card-body">
                    <canvas id="chart-denuncias"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    fetch('{{ route('admin.reportes.api') }}')
        .then(r => r.json())
        .then(data => {
            const ctx1 = document.getElementById('chart-basura-zona').getContext('2d')
            new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: data.basuraPorZona.map(z => z.zona),
                    datasets: [{
                        label: 'Toneladas',
                        data: data.basuraPorZona.map(z => z.toneladas),
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    }]
                }
            })

            const ctx2 = document.getElementById('chart-material').getContext('2d')
            new Chart(ctx2, {
                type: 'pie',
                data: {
                    labels: data.materialReciclado.map(m => m.material),
                    datasets: [{
                        data: data.materialReciclado.map(m => m.kg),
                        backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545', '#17a2b8'],
                    }]
                }
            })

            const ctx3 = document.getElementById('chart-denuncias').getContext('2d')
            new Chart(ctx3, {
                type: 'line',
                data: {
                    labels: data.denunciasSerie.fechas,
                    datasets: [
                        {
                            label: 'Recibidas',
                            data: data.denunciasSerie.recibidas,
                            borderColor: '#007bff',
                            fill: false,
                        },
                        {
                            label: 'Atendidas',
                            data: data.denunciasSerie.atendidas,
                            borderColor: '#28a745',
                            fill: false,
                        }
                    ]
                }
            })
        })
})
</script>
@endsection

