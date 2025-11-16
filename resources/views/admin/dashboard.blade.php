@extends(backpack_view('blank'))

@section('content')
<div class="container-fluid">

    {{-- KPI Cards --}}
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card text-white bg-primary shadow">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <h3 class="card-text">{{ count($completedTasksCount) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card text-white bg-success shadow">
                <div class="card-body">
                    <h5 class="card-title">Completed Tasks</h5>
                    <h3 class="card-text">{{ $completedCount }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card text-white bg-warning shadow">
                <div class="card-body">
                    <h5 class="card-title">Pending Tasks</h5>
                    <h3 class="card-text">{{ $pendingCount }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card text-white bg-info shadow">
                <div class="card-body">
                    <h5 class="card-title">Average Productivity</h5>
                    @php
                        $avgProd = count($productivity) ? round(array_sum($productivity)/count($productivity), 2) : 0;
                    @endphp
                    <h3 class="card-text">{{ $avgProd }}%</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts --}}
    <div class="row">

        {{-- Tasks Completed per User --}}
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    Tasks Completed per User
                </div>
                <div class="card-body">
                    <canvas id="tasksPerUser" height="200"></canvas>
                </div>
            </div>
        </div>

        {{-- Pending vs Completed --}}
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    Pending vs Completed
                </div>
                <div class="card-body">
                    <canvas id="pendingCompleted" height="200"></canvas>
                </div>
            </div>
        </div>

        {{-- Productivity --}}
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    Productivity (%)
                </div>
                <div class="card-body">
                    <canvas id="productivityChart" height="200"></canvas>
                </div>
            </div>
        </div>

        {{-- Burn-down Chart --}}
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card shadow">
                <div class="card-header bg-danger text-white">
                    Burn-down Chart
                </div>
                <div class="card-body">
                    <canvas id="burnDownChart" height="200"></canvas>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('after_scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Tasks Completed per User
    new Chart(document.getElementById('tasksPerUser').getContext('2d'), {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($completedTasksCount)) !!},
            datasets: [{
                label: 'Completed Tasks',
                data: {!! json_encode(array_values($completedTasksCount)) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    // Pending vs Completed
    new Chart(document.getElementById('pendingCompleted').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'Completed'],
            datasets: [{
                data: [{{ $pendingCount }}, {{ $completedCount }}],
                backgroundColor: ['#f0ad4e', '#5cb85c'],
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    // Productivity
    new Chart(document.getElementById('productivityChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($productivity)) !!},
            datasets: [{
                label: 'Productivity (%)',
                data: {!! json_encode(array_values($productivity)) !!},
                backgroundColor: 'rgba(255, 99, 132, 0.7)',
            }]
        },
        options: {
            scales: { y: { max: 100, beginAtZero: true } },
            responsive: true, maintainAspectRatio: false
        }
    });

    // Burn-down
    new Chart(document.getElementById('burnDownChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: {!! json_encode($dates) !!},
            datasets: [{
                label: 'Tasks Left',
                data: {!! json_encode($tasksLeft) !!},
                borderColor: 'rgba(255, 99, 132, 1)',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                fill: true,
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });
</script>
@endsection
