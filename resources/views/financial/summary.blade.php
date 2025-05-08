@extends('dashboard.body.main')

@section('container')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Financial Summary</h3>
                    </div>
                    <div class="card-body">
                        <!-- Date Range Filter -->
                        <form method="GET" action="{{ route('financial.summary') }}" class="mb-4">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <button type="submit" class="btn btn-primary btn-block">Filter</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Summary Cards -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card bg-success text-white">
                                    <div class="card-body">
                                        <h5 class="card-title">Total Sales</h5>
                                        <h3 class="card-text">$ {{ number_format($totalSales, 2, '.', ',') }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-danger text-white">
                                    <div class="card-body">
                                        <h5 class="card-title">Total Expenses</h5>
                                        <h3 class="card-text">$ {{ number_format($totalExpenses, 2, '.', ',') }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-info text-white">
                                    <div class="card-body">
                                        <h5 class="card-title">Net Income</h5>
                                        <h3 class="card-text">$ {{ number_format($netIncome, 2, '.', ',') }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Chart -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div id="financial-chart" style="min-height: 360px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const chartData = @json($chartData);
                const dates = Object.keys(chartData);
                const revenueData = dates.map(date => chartData[date].revenue);
                const costData = dates.map(date => chartData[date].cost);

                const options = {
                    series: [{
                        name: 'Income',
                        data: revenueData
                    }, {
                        name: 'Expenses',
                        data: costData
                    }],
                    chart: {
                        type: 'bar',
                        height: 360,
                        stacked: false,
                        toolbar: {
                            show: true
                        },
                        zoom: {
                            enabled: true
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '55%',
                            endingShape: 'rounded'
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ['transparent']
                    },
                    xaxis: {
                        categories: dates,
                    },
                    yaxis: {
                        title: {
                            text: 'Amount ($)'
                        },
                        labels: {
                            formatter: function (value) {
                                return '$ ' + value.toLocaleString('en-US', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                });
                            }
                        }
                    },
                    fill: {
                        opacity: 1
                    },
                    tooltip: {
                        y: {
                            formatter: function (value) {
                                return '$ ' + value.toLocaleString('en-US', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                });
                            }
                        }
                    },
                    colors: ['#28a745', '#dc3545']
                };

                const chart = new ApexCharts(document.querySelector("#financial-chart"), options);
                chart.render();
            });
        </script>
    @endpush
@endsection