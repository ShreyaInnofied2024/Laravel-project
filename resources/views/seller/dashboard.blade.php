@include('inc.header')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12 text-center mb-4">
            
            <h2 class="text-uppercase" style="color: #a27053;">Seller Dashboard</h2>
            
        </div>



        <div class="container-fluid mt-4">
            <div class="row">
                <!-- Summary Cards -->
                <div class="row text-center">
                    <!-- Total Orders Card -->
                    <div class="col-md-3 mb-4">
                        <div class="card text-white bg-primary shadow-lg hover-shadow-lg">
                            <div class="card-body py-4">
                                <h5 class="card-title mb-3">Total Orders</h5>
                                <h3 class="mb-0">{{ $data['totalOrders'] }}</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Total Revenue Card -->
                    <div class="col-md-3 mb-4">
                        <div class="card text-white bg-success shadow-lg hover-shadow-lg">
                            <div class="card-body py-4">
                                <h5 class="card-title mb-3">Total Revenue</h5>
                                <h3 class="mb-0">Rs {{ number_format($data['totalRevenue'], 2) }}</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Orders Card -->
                    <div class="col-md-3 mb-4">
                        <div class="card text-white bg-danger shadow-lg hover-shadow-lg">
                            <div class="card-body py-4">
                                <h5 class="card-title mb-3">Pending Orders</h5>
                                <h3 class="mb-0">{{ $data['orderStatusCounts']['Pending'] }}</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Paid Orders Card -->
                    <div class="col-md-3 mb-4">
                        <div class="card text-white bg-info shadow-lg hover-shadow-lg">
                            <div class="card-body py-4">
                                <h5 class="card-title mb-3">Paid Orders</h5>
                                <h3 class="mb-0">{{ $data['orderStatusCounts']['Paid'] }}</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Processing Orders Card -->
                    <div class="col-md-3 mb-4">
                        <div class="card text-white bg-warning shadow-lg hover-shadow-lg">
                            <div class="card-body py-4">
                                <h5 class="card-title mb-3">Processing Orders</h5>
                                <h3 class="mb-0">{{ $data['orderStatusCounts']['Processing'] }}</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Out For Delivery Orders Card -->
                    <div class="col-md-3 mb-4">
                        <div class="card text-white bg-info shadow-lg hover-shadow-lg">
                            <div class="card-body py-4">
                                <h5 class="card-title mb-3">Out For Delivery Orders</h5>
                                <h3 class="mb-0">{{ $data['orderStatusCounts']['Out For Delivery'] }}</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Completed Orders Card -->
                    <div class="col-md-3 mb-4">
                        <div class="card text-white bg-success shadow-lg hover-shadow-lg">
                            <div class="card-body py-4">
                                <h5 class="card-title mb-3">Completed Orders</h5>
                                <h3 class="mb-0">{{ $data['orderStatusCounts']['Completed'] }}</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Cancelled Orders Card -->
                    <div class="col-md-3 mb-4">
                        <div class="card text-white bg-danger shadow-lg hover-shadow-lg">
                            <div class="card-body py-4">
                                <h5 class="card-title mb-3">Cancelled Orders</h5>
                                <h3 class="mb-0">{{ $data['orderStatusCounts']['Cancelled'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- Customer Summary -->
        <div class="col-12 text-center" style="margin-top: 10px;">
            <div class="card shadow bg-light mb-4">
                <div class="card-body">
                    <h5 class="card-title">Total Customers</h5>
                    <h3>{{ $data['customer'] }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container my-5">
    <h1 class="text-center mb-4">Dashboard</h1>
    <div class="row gy-4">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header text-center bg-primary text-white">
                    <h5 class="mb-0">Sales by Date</h5>
                </div>
                <div class="card-body p-0">
                    <canvas id="lineChart" class="w-100" style="height: 350px;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header text-center bg-success text-white">
                    <h5 class="mb-0">Sales by Payment Method</h5>
                </div>
                <div class="card-body p-0">
                    <canvas id="pieChart" class="w-100" style="height: 350px;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-5">
    <h1 class="text-center mb-4">Products Sold by Date</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Date</th>
                    <th>Product</th>
                    <th>Total Quantity</th>
                    <th>Total Revenue</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data['productsSoldByDate'] as $row)
                <tr>
                    <td>{{ $row->sale_date }}</td>
                    <td>{{ $row->product_name }}</td>
                    <td>{{ $row->total_quantity }}</td>
                    <td>Rs {{ number_format($row->total_revenue, 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">No sales data available</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const lineLabels = @json($data['revenueByDate']->pluck('order_date')->toArray());
    const lineData = @json($data['revenueByDate'] -> pluck('total_revenue')-> toArray());
    const pieLabels = @json($data['revenueByPaymentMethod'] -> pluck('shipping_method') -> toArray());
    const pieData = @json($data['revenueByPaymentMethod'] -> pluck('total_revenue') -> toArray());


    const lineCtx = document.getElementById('lineChart').getContext('2d');
    new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: lineLabels,
            datasets: [{
                label: 'Total Sales by Date',
                data: lineData,
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderWidth: 2,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Order Date'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Total Sales'
                    },
                    beginAtZero: true
                }
            }
        }
    });

    const pieCtx = document.getElementById('pieChart').getContext('2d');
    new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: pieLabels,
            datasets: [{
                label: 'Sales by Payment Method',
                data: pieData,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(75, 192, 192, 0.6)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            }
        }
    });
</script>