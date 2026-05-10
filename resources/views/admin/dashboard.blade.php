@extends('layouts.admin')

<style>
/* Container */
/* Container */
.container { max-width: 1200px; margin: 0 auto; padding: 20px; font-family: Inter, sans-serif; color: blue; }

/* Topbar */
.topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 15px; }
.topbar-left { display: flex; align-items: center; gap: 15px; flex-wrap: wrap; }
.topbar-title { font-size: 28px; font-weight: 700; }
.topbar-subtitle { font-size: 14px; color: black; }
.profile { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
.search input { padding: 6px 10px; border-radius: 6px; border: 1px solid #ccc; width: 200px; max-width: 100%; }
.avatar { width: 40px; height: 40px; background: #c07a35; color: #fff; font-weight: 700; border-radius: 50%; display: flex; align-items: center; justify-content: center; }

/* Top grid */
.top-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 30px; }
@media(max-width: 992px) { .top-grid { grid-template-columns: 1fr; } }

/* Cards */
.cards { display: flex; gap: 15px; margin-bottom: 15px; flex-wrap: wrap; }
.card { background: white; padding: 15px; border-radius: 10px; flex: 1 1 150px; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 2px 6px rgba(0,0,0,0.08); min-width: 150px; }
.card-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
.card-label { font-size: 14px; color: black; }
.card-num { font-size: 22px; font-weight: 700; margin-top: 3px; }
.card-icon { font-size: 24px; }
.card-footer { display: flex; justify-content: space-between; font-size: 12px; color: grey; margin-top: 5px; }

/* Tiles */
.tile-grid { display: grid; grid-template-columns: repeat(2,1fr); gap: 15px; }
@media(max-width: 768px){ .tile-grid { grid-template-columns: 1fr; } }
.tile { background: white; padding: 10px 15px; border-radius: 8px; display: flex; flex-direction: column; }
.tile-label { font-size: 13px; color: black; }
.tile-value { font-size: 18px; font-weight: 700; margin: 3px 0; }
.tile-sub { font-size: 11px; color: grey; }

/* Chart card */
.chart-card { background:white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); height: 100%; }
@media(max-width: 992px){ .chart-card { margin-top: 20px; } }
.chart-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; flex-wrap: wrap; gap: 10px; }
.chart-title { font-size: 16px; font-weight: 700; }
.chart-sub { font-size: 12px; color: grey; }
.chart-pill { display: flex; align-items: center; gap: 5px; margin-right: 10px; font-size: 12px; }
.chart-pill-dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; }
.chart-figure-main { font-size: 22px; font-weight: 700; }
.chart-figure-sub { font-size: 12px; color:gray; }
.chart-container { height: 250px; }

/* Orders section */
.section { margin-top: 30px; }
.section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; flex-wrap: wrap; gap: 10px; }
.section-title { font-size: 18px; font-weight: 700; }
.section-link { text-decoration: none; font-size: 13px; color: #c07a35; }
.order-card { display: flex; justify-content: space-between; background: white; padding: 15px; border-radius: 10px; margin-bottom: 10px; align-items: center; text-decoration: none; color: #654321; transition: all 0.2s; flex-wrap: wrap; gap: 10px; }
.order-card:hover { background: white; }
.order-info { display: flex; flex-direction: column; }
.order-id { font-weight: 700; margin-bottom: 4px; }
.order-meta { font-size: 12px; color: grey; display: flex; align-items: center; gap: 5px; flex-wrap: wrap; }
.order-right { text-align: right; display: flex; flex-direction: column; align-items: flex-end; gap: 3px; }

/* Status */
.status { display: flex; align-items: center; gap: 5px; font-size: 12px; font-weight: 600; text-transform: capitalize; }
.status-dot { width: 8px; height: 8px; border-radius: 50%; display: inline-block; background: black; }
.status.delivered .status-dot { background: green; }
.status.pending .status-dot { background: orange; }
.status.cancelled .status-dot { background: red; }

.order-amount { font-weight: 700; }
.order-tag { font-size: 10px; color:black; }
.empty-box { text-align: center; color: black; padding: 20px; background:white; border-radius: 8px; }

/* Make chart canvas responsive */
@media(max-width: 576px){
    .chart-container { height: 200px; }
}
</style>

@section('content')
<div class="container">
    <main class="main">
        <!-- TOPBAR -->
        <div class="topbar">
            <div class="topbar-left">
                <div>
                    <div class="topbar-title">Dashboard</div>
                    <div class="topbar-subtitle">Quick overview of orders & revenue</div>
                </div>
            </div>
            <div class="profile">
                <div class="search"><input placeholder="Search orders, users, products..." /></div>
                <div class="profile-text">
                    <div class="profile-name">{{ auth()->user()->name ?? 'Admin' }}</div>
                    
                </div>
                <div class="avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A',0,2)) }}</div>
            </div>
        </div>

        <!-- TOP GRID -->
        <div class="top-grid">
            <div>
                <!-- CARDS -->
                <div class="cards">
                    <div class="card">
                        <div class="card-top">
                            <div>
                                <div class="card-label">Total Orders</div>
                                <div class="card-num">{{ $totalOrders }}</div>
                            </div>
                            <div class="card-icon">📊</div>
                        </div>
                        <div class="card-footer">
                            <span class="strong">All-time total</span>
                            <span>{{ now()->format('d M Y') }}</span>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-top">
                            <div>
                                <div class="card-label">Delivered</div>
                                <div class="card-num">{{ $deliveredOrders ?? 0 }}</div>
                            </div>
                            <div class="card-icon">✅</div>
                        </div>
                        <div class="card-footer">
                            <span class="strong">₹{{ number_format($deliveredAmount ?? 0,2) }}</span>
                            <span>Delivered value</span>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-top">
                            <div>
                                <div class="card-label">Total Revenue</div>
                                <div class="card-num">₹{{ number_format($totalRevenue ?? 0,2) }}</div>
                            </div>
                            <div class="card-icon">💰</div>
                        </div>
                        <div class="card-footer">
                            <span class="strong">Pending + Delivered</span>
                            <span>In all statuses</span>
                        </div>
                    </div>
                </div>

                <!-- TILES -->
                <div class="tile-grid">
                    <div class="tile">
                        <div class="tile-label">Pending Orders</div>
                        <div class="tile-value">{{ $pendingOrders ?? 0 }}</div>
                        <div class="tile-sub">Awaiting processing</div>
                    </div>
                    <div class="tile">
                        <div class="tile-label">Cancelled Orders</div>
                        <div class="tile-value">{{ $cancelledOrders ?? 0 }}</div>
                        <div class="tile-sub">Removed by customer/admin</div>
                    </div>
                    <div class="tile">
                        <div class="tile-label">Pending Amount</div>
                        <div class="tile-value">₹{{ number_format($pendingAmount ?? 0,2) }}</div>
                        <div class="tile-sub">Due on completion</div>
                    </div>
                    <div class="tile">
                        <div class="tile-label">Cancelled Amount</div>
                        <div class="tile-value">₹{{ number_format($cancelAmount ?? 0,2) }}</div>
                        <div class="tile-sub">Lost revenue</div>
                    </div>
                </div>
            </div>

            <!-- CHART -->
            <aside class="chart-card">
                <div class="chart-header">
                    <div>
                        <div class="chart-title">Earnings & Orders</div>
                        <div class="chart-sub">Revenue vs Orders (Monthly)</div>
                        <div class="chart-legend-inline">
                            <div class="chart-pill"><span class="chart-pill-dot" style="background:#c07a35;"></span>Revenue</div>
                            <div class="chart-pill"><span class="chart-pill-dot" style="background:#8a6a52;"></span>Orders</div>
                        </div>
                    </div>
                    <div class="chart-figure">
                        <div class="chart-figure-main">₹{{ number_format($totalRevenue ?? 0,0) }}</div>
                        <div class="chart-figure-sub">Latest month: ₹{{ number_format(($monthlyRevenue[0] ?? 0),0) }}</div>
                    </div>
                </div>
                <div class="chart-container"><canvas id="earningsChart"></canvas></div>
            </aside>
        </div>

        <!-- LATEST ORDER -->
        <div class="section">
            <div class="section-header">
                <h3 class="section-title">Latest Order</h3>
                <a href="{{ route('admin.orders') }}" class="section-link">See all orders →</a>
            </div>

            @if($recentOrders && count($recentOrders) > 0)
                @php $order = $recentOrders->first(); @endphp
                <a href="" class="order-card">
                    <div class="order-info">
                        <div class="order-id">Order #{{ $order->order_number ?? $order->id }}</div>
                        <div class="order-meta">{{ $order->user->name ?? 'Guest' }}<span class="dot"></span>{{ $order->created_at->format('d M, Y · H:i') }}</div>
                    </div>
                    <div class="order-right">
                        @php $status = strtolower($order->status ?? 'unknown'); @endphp
                        <div class="status {{ $status }}"><span class="status-dot"></span>{{ ucfirst($order->status) }}</div>
                        <div class="order-amount">₹{{ number_format($order->total,2) }}</div>
                        <div class="order-tag">Latest activity</div>
                    </div>
                </a>
            @else
                <div class="empty-box">No recent orders yet. Once the first order comes in, you’ll see a live notification here.</div>
            @endif
        </div>
    </main>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const chartEl = document.getElementById('earningsChart');
if(chartEl){
    const ctx = chartEl.getContext('2d');
    const months = @json($months ?? []);
    const revenueData = @json($monthlyRevenue ?? []);
    const ordersData = @json($monthlyOrders ?? []);

    const revenueGradient = ctx.createLinearGradient(0,0,0,250);
    revenueGradient.addColorStop(0,'rgba(192,122,53,0.85)');
    revenueGradient.addColorStop(1,'rgba(243,233,221,0.15)');

    new Chart(ctx,{
        type:'bar',
        data:{
            labels: months,
            datasets:[
                {
                    label:'Revenue',
                    data: revenueData,
                    backgroundColor: revenueGradient,
                    borderColor:'#c07a35',
                    borderWidth:1,
                    borderRadius:6,
                    barPercentage:0.6
                },
                {
                    label:'Orders',
                    data: ordersData,
                    type:'line',
                    tension:0.35,
                    borderColor:'#8a6a52',
                    pointBackgroundColor:'#8a6a52',
                    pointRadius:3,
                    pointHitRadius:8
                }
            ]
        },
        options:{
            responsive:true,
            maintainAspectRatio:false,
            plugins:{
                legend:{display:false},
                tooltip:{
                    callbacks:{
                        label:function(context){
                            if(context.dataset.label==='Revenue'){
                                return ' Revenue: ₹'+(context.parsed.y||0).toLocaleString();
                            } else {
                                return ' Orders: '+(context.parsed.y||0).toLocaleString();
                            }
                        }
                    }
                }
            },
            scales:{
                x:{grid:{display:false},ticks:{font:{family:'Inter',size:11},color:'#7c726d'}},
                y:{grid:{color:'rgba(209,188,161,0.55)',drawBorder:false},ticks:{beginAtZero:true,font:{family:'Inter',size:11},color:'#7c726d'}}
            }
        }
    });
}

// Optional sidebar toggle
const menuBtn = document.getElementById('menuBtn');
const sidebar = document.querySelector('.sidebar');
if(menuBtn && sidebar){
    menuBtn.addEventListener('click', () => sidebar.classList.toggle('open'));
}
</script>
@endpush
