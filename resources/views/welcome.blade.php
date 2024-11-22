@extends('layouts.user-layout')
@section('content')
    <div class="content-wrapper pb-4">
        <div class="container-fluid pt-5">
            {{-- Stats Section --}}
            <div class="row g-3">
                @role('admin|cityManager|gymManager')
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="card text-white bg-info shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h3 class="mb-0">{{ $revenueInDollars }}</h3>
                                        <p>Total Revenue</p>
                                    </div>
                                    <i class="fas fa-dollar-sign fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                @endrole
                @role('admin')
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="card text-white bg-success shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h3 class="mb-0">{{ $cities }}</h3>
                                        <p>Cities</p>
                                    </div>
                                    <i class="fas fa-city fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="card text-white bg-secondary shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h3 class="mb-0">{{ $citiesManagers }}</h3>
                                        <p>Cities Managers</p>
                                    </div>
                                    <i class="fas fa-user-tie fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                @endrole
                @role('admin|cityManager')
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="card text-white bg-danger shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h3 class="mb-0">{{ $gyms }}</h3>
                                        <p>Gyms</p>
                                    </div>
                                    <i class="fas fa-dumbbell fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="card text-dark bg-warning shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h3 class="mb-0">{{ $gymsManagers }}</h3>
                                        <p>Gyms Managers</p>
                                    </div>
                                    <i class="fas fa-user fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                @endrole
                @role('admin|cityManager|gymManager')
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="card text-dark bg-light shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h3 class="mb-0">{{ $coaches }}</h3>
                                        <p>Coaches</p>
                                    </div>
                                    <i class="fas fa-user-ninja fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="card text-white bg-dark shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h3 class="mb-0">{{ $users }}</h3>
                                        <p>Users</p>
                                    </div>
                                    <i class="fas fa-users fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                @endrole
            </div>

            {{-- Chart Section --}}
            <div class="mt-5">
                <h3 class="text-left-align">Revenue Details</h3>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart.js Script --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');

    
    const gradient = ctx.createLinearGradient(0, 0, 0, 400); // Adjust gradient height
    gradient.addColorStop(0, 'rgba(54, 162, 235, 0.4)'); // Start with a semi-transparent blue
    gradient.addColorStop(1, 'rgba(54, 162, 235, 0)'); // Fade to transparent

    const revenueChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55, 60], // X-axis values
            datasets: [{
                label: 'Revenue',
                data: [20, 40, 60, 100, 80, 50, 60, 70, 50, 60, 55, 60], // Y-axis values
                borderColor: 'rgba(54, 162, 235, 1)', 
                backgroundColor: gradient, 
                borderWidth: 2, 
                pointRadius: 4, 
                pointBackgroundColor: 'rgba(54, 162, 235, 1)', 
                tension: 0.4, 
                fill: true  
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: true }, // Show legend
                tooltip: { enabled: true } // Enable tooltips
            },
            scales: {
                x: {
                    grid: { display: false } // Hide grid lines on the X-axis
                },
                y: {
                    beginAtZero: true, // Start the Y-axis at zero
                    grid: { color: '#f3f3f3' }, // Light gray grid lines
                    ticks: { stepSize: 20 } // Set step size for Y-axis ticks
                }
            }
        }
    });
</script>
@endsection

