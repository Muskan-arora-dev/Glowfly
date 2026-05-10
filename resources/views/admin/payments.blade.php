@extends('layouts.admin')

@section('content')
<div class="p-6 bg-[#fdf9ef]">

    <h2 class="text-3xl font-bold text-[#4e54c8] mb-6">💰 Admin Payment Dashboard</h2>

    <!-- Top Metric Cards -->
    <div class="top-cards flex flex-wrap gap-4 mb-8">
        <div class="card bg-white shadow-lg rounded-lg p-5 flex-1 min-w-[140px] hover:shadow-xl transition">
            <h3 class="text-gray-600 text-sm mb-2">Total Payment</h3>
            <p class="text-2xl font-bold text-[#4e54c8]">₹ {{ $totalPayment }}</p>
        </div>
        <div class="card bg-white shadow-lg rounded-lg p-5 flex-1 min-w-[140px] hover:shadow-xl transition">
            <h3 class="text-gray-600 text-sm mb-2">Delivered</h3>
            <p class="text-2xl font-bold text-[#34c759]">₹ {{ $successPayment }}</p>
        </div>
        <div class="card bg-white shadow-lg rounded-lg p-5 flex-1 min-w-[140px] hover:shadow-xl transition">
            <h3 class="text-gray-600 text-sm mb-2">Pending</h3>
            <p class="text-2xl font-bold text-[#ff9500]">₹ {{ $pendingPayment }}</p>
        </div>
        <div class="card bg-white shadow-lg rounded-lg p-5 flex-1 min-w-[140px] hover:shadow-xl transition">
            <h3 class="text-gray-600 text-sm mb-2">Cancelled</h3>
            <p class="text-2xl font-bold text-[#ff3b30]">₹ {{ $failedPayment }}</p>
        </div>
        <div class="card bg-white shadow-lg rounded-lg p-5 flex-1 min-w-[140px] hover:shadow-xl transition">
            <h3 class="text-gray-600 text-sm mb-2">Monthly Avg</h3>
            <p class="text-2xl font-bold text-[#4e54c8]">₹ {{ round(array_sum($monthlyPayments)/count($monthlyPayments),2) }}</p>
        </div>
        <div class="card bg-white shadow-lg rounded-lg p-5 flex-1 min-w-[140px] hover:shadow-xl transition">
            <h3 class="text-gray-600 text-sm mb-2">Orders Count</h3>
            <p class="text-2xl font-bold text-[#4e54c8]">{{ count($payments) }}</p>
        </div>
    </div>

    <!-- Dashboard -->
    <div class="dashboard flex flex-wrap gap-6">

        <!-- Charts Section -->
        <div class="charts flex-3 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="chart-box bg-white p-4 rounded-lg shadow-lg">
                <canvas id="monthlyPaymentsChart"></canvas>
            </div>
            <div class="chart-box bg-white p-4 rounded-lg shadow-lg">
                <canvas id="statusChart"></canvas>
            </div>
            <div class="chart-box bg-white p-4 rounded-lg shadow-lg">
                <canvas id="recentOrdersChart"></canvas>
            </div>
            <div class="chart-box bg-white p-4 rounded-lg shadow-lg">
                <canvas id="paymentsDynamicsChart"></canvas>
            </div>
        </div>

        <!-- Filters Sidebar -->
        <div class="filters flex-1 bg-white p-4 rounded-lg shadow-lg h-fit">
            <label class="block font-semibold text-gray-700 mt-3">Date From:</label>
            <input type="date" id="dateFrom" class="w-full border rounded px-2 py-1 mt-1">

            <label class="block font-semibold text-gray-700 mt-3">Date To:</label>
            <input type="date" id="dateTo" class="w-full border rounded px-2 py-1 mt-1">

            <label class="block font-semibold text-gray-700 mt-3">Source</label>
            <select id="source" class="w-full border rounded px-2 py-1 mt-1">
                <option>All</option>
            </select>

            <label class="block font-semibold text-gray-700 mt-3">Ad Type</label>
            <select id="adType" class="w-full border rounded px-2 py-1 mt-1">
                <option>All</option>
            </select>

            <label class="block font-semibold text-gray-700 mt-3">Campaign Type</label>
            <select id="campaignType" class="w-full border rounded px-2 py-1 mt-1">
                <option>All</option>
            </select>

            <label class="block font-semibold text-gray-700 mt-3">Campaign Name</label>
            <select id="campaignName" class="w-full border rounded px-2 py-1 mt-1">
                <option>All</option>
            </select>
        </div>

    </div>

    <!-- Recent Orders Table -->
    <h3 class="text-2xl font-bold text-[#4e54c8] mt-8 mb-4">🧾 Recent Orders / Payments</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-lg shadow-lg">
            <thead>
                <tr class="bg-gradient-to-r from-[#4e54c8] to-[#8f94fb] text-white">
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">User</th>
                    <th class="px-4 py-2">Amount</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $pay)
                <tr class="text-center even:bg-gray-100 hover:bg-[#e0e7ff]">
                    <td class="px-4 py-2">{{ $pay->id }}</td>
                    <td class="px-4 py-2">{{ $pay->user_name }}</td>
                    <td class="px-4 py-2">₹ {{ $pay->amount }}</td>
                    <td class="px-4 py-2">{{ ucfirst($pay->status) }}</td>
                    <td class="px-4 py-2">{{ date('d-m-Y', strtotime($pay->created_at)) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<script>
    // Monthly Payments Line Chart
    const ctxMonthly = document.getElementById('monthlyPaymentsChart').getContext('2d');
    new Chart(ctxMonthly, {
        type: 'line',
        data: {
            labels: {!! json_encode($months) !!},
            datasets: [{
                label: 'Monthly Payments',
                data: {!! json_encode($monthlyPayments) !!},
                borderColor: '#4e54c8',
                backgroundColor: 'rgba(78,84,200,0.2)',
                fill: true,
                tension: 0.3,
                pointRadius: 5
            }]
        },
        options: { responsive: true }
    });

    // Payment Status Pie Chart
    const ctxStatus = document.getElementById('statusChart').getContext('2d');
    new Chart(ctxStatus, {
        type: 'doughnut',
        data: {
            labels: ['Delivered', 'Pending', 'Cancelled'],
            datasets: [{
                data: [{{ $successPayment }}, {{ $pendingPayment }}, {{ $failedPayment }}],
                backgroundColor: ['#34c759', '#ff9500', '#ff3b30']
            }]
        }
    });

    // Recent Orders Chart
    const ctxRecent = document.getElementById('recentOrdersChart').getContext('2d');
    new Chart(ctxRecent, {
        type: 'bar',
        data: {
            labels: {!! json_encode($months) !!},
            datasets: [{ label: 'Orders', data: {!! json_encode($monthlyPayments) !!}, backgroundColor: '#4e54c8' }]
        }
    });

    // Payments Dynamics Chart
    const ctxDynamics = document.getElementById('paymentsDynamicsChart').getContext('2d');
    new Chart(ctxDynamics, {
        type: 'line',
        data: {
            labels: {!! json_encode($months) !!},
            datasets: [{
                label: 'Payments Dynamics',
                data: {!! json_encode($monthlyPayments) !!},
                borderColor: '#ff9500',
                backgroundColor: 'rgba(255,149,0,0.2)',
                fill: true
            }]
        }
    });
</script>
@endsection
