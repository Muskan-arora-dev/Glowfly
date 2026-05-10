@extends('layouts.admin')

@section('title', 'Payment Dashboard')

@section('content')
<h2 class="text-3xl font-bold text-[#654321] mb-6">💰 Admin Payment Dashboard</h2>

<!-- Top Metric Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6 mb-8">
    <div class="bg-white p-4 rounded-lg shadow text-center hover:shadow-lg transition">
        <h3 class="text-gray-500 text-sm mb-2">Total Payment</h3>
        <p class="text-xl font-bold">₹ {{ $totalPayment }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center hover:shadow-lg transition">
        <h3 class="text-gray-500 text-sm mb-2">Delivered</h3>
        <p class="text-xl font-bold">₹ {{ $successPayment }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center hover:shadow-lg transition">
        <h3 class="text-gray-500 text-sm mb-2">Pending</h3>
        <p class="text-xl font-bold">₹ {{ $pendingPayment }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center hover:shadow-lg transition">
        <h3 class="text-gray-500 text-sm mb-2">Cancelled</h3>
        <p class="text-xl font-bold">₹ {{ $failedPayment }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center hover:shadow-lg transition">
        <h3 class="text-gray-500 text-sm mb-2">Monthly Avg</h3>
        <p class="text-xl font-bold">₹ {{ round(array_sum($monthlyPayments)/count($monthlyPayments),2) }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center hover:shadow-lg transition">
        <h3 class="text-gray-500 text-sm mb-2">Orders Count</h3>
        <p class="text-xl font-bold">{{ count($payments) }}</p>
    </div>
</div>

<!-- Dashboard: Charts + Filters -->
<div class="flex flex-col lg:flex-row gap-6">

    <!-- Charts Section -->
    <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-4 rounded-lg shadow">
            <canvas id="monthlyPaymentsChart"></canvas>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <canvas id="statusChart"></canvas>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <canvas id="recentOrdersChart"></canvas>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <canvas id="paymentsDynamicsChart"></canvas>
        </div>
    </div>

    <!-- Filters Sidebar -->
    <div class="w-full lg:w-64 bg-white p-4 rounded-lg shadow flex-shrink-0">
        <label class="block font-semibold text-gray-600 mt-2">Date From:</label>
        <input type="date" id="dateFrom" class="w-full border rounded px-2 py-1 mt-1">

        <label class="block font-semibold text-gray-600 mt-2">Date To:</label>
        <input type="date" id="dateTo" class="w-full border rounded px-2 py-1 mt-1">

        <label class="block font-semibold text-gray-600 mt-2">Source</label>
        <select id="source" class="w-full border rounded px-2 py-1 mt-1">
            <option>All</option>
        </select>

        <label class="block font-semibold text-gray-600 mt-2">Ad Type</label>
        <select id="adType" class="w-full border rounded px-2 py-1 mt-1">
            <option>All</option>
        </select>

        <label class="block font-semibold text-gray-600 mt-2">Campaign Type</label>
        <select id="campaignType" class="w-full border rounded px-2 py-1 mt-1">
            <option>All</option>
        </select>

        <label class="block font-semibold text-gray-600 mt-2">Campaign Name</label>
        <select id="campaignName" class="w-full border rounded px-2 py-1 mt-1">
            <option>All</option>
        </select>
    </div>

</div>

<!-- Recent Orders Table -->
<h3 class="text-xl font-bold text-gray-700 mt-8 mb-4">🧾 Recent Orders / Payments</h3>
<div class="overflow-x-auto">
    <table class="min-w-full bg-white rounded-lg shadow overflow-hidden">
        <thead class="bg-gradient-to-r from-purple-500 to-indigo-500 text-white">
            <tr>
                <th class="py-2 px-4">ID</th>
                <th class="py-2 px-4">User</th>
                <th class="py-2 px-4">Amount</th>
                <th class="py-2 px-4">Status</th>
                <th class="py-2 px-4">Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $pay)
            <tr class="text-center even:bg-gray-100 hover:bg-gray-200">
                <td class="py-2 px-4">{{ $pay->id }}</td>
                <td class="py-2 px-4">{{ $pay->user_name }}</td>
                <td class="py-2 px-4">₹ {{ $pay->amount }}</td>
                <td class="py-2 px-4">{{ ucfirst($pay->status) }}</td>
                <td class="py-2 px-4">{{ date('d-m-Y', strtotime($pay->created_at)) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Charts JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const months = {!! json_encode($months) !!};
    const monthlyPayments = {!! json_encode($monthlyPayments) !!};
    const successPayment = {{ $successPayment }};
    const pendingPayment = {{ $pendingPayment }};
    const failedPayment = {{ $failedPayment }};

    // Monthly Payments Line Chart
    new Chart(document.getElementById('monthlyPaymentsChart'), {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Monthly Payments',
                data: monthlyPayments,
                borderColor: '#4e54c8',
                backgroundColor: 'rgba(78,84,200,0.2)',
                fill: true,
                tension: 0.3,
                pointRadius: 5
            }]
        },
        options: { responsive: true }
    });

    // Payment Status Doughnut Chart
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: ['Delivered', 'Pending', 'Cancelled'],
            datasets: [{
                data: [successPayment, pendingPayment, failedPayment],
                backgroundColor: ['#34c759', '#ff9500', '#ff3b30']
            }]
        },
        options: { responsive: true }
    });

    // Recent Orders Bar Chart
    new Chart(document.getElementById('recentOrdersChart'), {
        type: 'bar',
        data: {
            labels: months,
            datasets: [{
                label: 'Orders',
                data: monthlyPayments,
                backgroundColor: '#4e54c8'
            }]
        },
        options: { responsive: true }
    });

    // Payments Dynamics Line Chart
    new Chart(document.getElementById('paymentsDynamicsChart'), {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Payments Dynamics',
                data: monthlyPayments,
                borderColor: '#ff9500',
                backgroundColor: 'rgba(255,149,0,0.2)',
                fill: true
            }]
        },
        options: { responsive: true }
    });
</script>
@endsection
