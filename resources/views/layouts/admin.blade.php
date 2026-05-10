<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Admin')</title>

<script src="https://cdn.tailwindcss.com"></script>

<script>
function toggleSidebar(){
    document.getElementById('sidebar').classList.toggle('-translate-x-full');
    document.getElementById('overlay').classList.toggle('hidden');
}
</script>
</head>

<body class="bg-[#f8fafc] font-sans">

<!-- ===== Mobile Topbar ===== -->
<div class="lg:hidden flex items-center justify-between px-4 py-3 bg-white shadow fixed w-full z-40">
    <h1 class="text-xl font-bold text-gray-800">GlowFly</h1>
    <button onclick="toggleSidebar()" class="text-2xl">☰</button>
</div>

<!-- Overlay -->
<div id="overlay"
onclick="toggleSidebar()"
class="hidden fixed inset-0 bg-black/40 z-40 lg:hidden"></div>

<div class="flex pt-14 lg:pt-0">

<!-- ===== Sidebar ===== -->
<aside id="sidebar"
class="w-72 fixed min-h-screen z-50 bg-white
shadow-[0_10px_40px_rgba(0,0,0,0.08)]
transform -translate-x-full lg:translate-x-0
transition-transform duration-300">

    <!-- Logo -->
    <div class="p-6 border-b">
        <h1 class="text-2xl font-bold text-gray-800">GlowFly</h1>
        <p class="text-sm text-gray-400">Admin Dashboard</p>
    </div>

    <!-- Menu -->
    <nav class="mt-6 px-3 space-y-1">

        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}"
        class="flex items-center gap-4 px-4 py-3 rounded-xl
        {{ request()->routeIs('admin.dashboard')
            ? 'bg-blue-50 text-blue-600 shadow-sm'
            : 'text-gray-600 hover:bg-blue-50 hover:text-blue-600' }}">
            <span class="text-xl">📊</span>
            Dashboard
        </a>

        <!-- Orders -->
        <a href="{{ route('admin.orders') }}"
        class="flex items-center gap-4 px-4 py-3 rounded-xl
        {{ request()->routeIs('admin.orders')
            ? 'bg-indigo-50 text-indigo-600 shadow-sm'
            : 'text-gray-600 hover:bg-indigo-50 hover:text-indigo-600' }}">
            <span class="text-xl">📦</span>
            Orders
        </a>

        <!-- Users -->
        <a href="{{ route('admin.users') }}"
        class="flex items-center gap-4 px-4 py-3 rounded-xl
        {{ request()->routeIs('admin.users')
            ? 'bg-purple-50 text-purple-600 shadow-sm'
            : 'text-gray-600 hover:bg-purple-50 hover:text-purple-600' }}">
            <span class="text-xl">👥</span>
            Users
        </a>

        <!-- Payments -->
        <a href="{{ route('admin.payments') }}"
        class="flex items-center gap-4 px-4 py-3 rounded-xl
        {{ request()->routeIs('admin.payments')
            ? 'bg-emerald-50 text-emerald-600 shadow-sm'
            : 'text-gray-600 hover:bg-emerald-50 hover:text-emerald-600' }}">
            <span class="text-xl">💳</span>
            Payments
        </a>

        <!-- Products -->
        <a href="{{ route('admin.products.index') }}"
        class="flex items-center gap-4 px-4 py-3 rounded-xl
        {{ request()->routeIs('admin.products*')
            ? 'bg-pink-50 text-pink-600 shadow-sm'
            : 'text-gray-600 hover:bg-pink-50 hover:text-pink-600' }}">
            <span class="text-xl">🛍</span>
            Products
        </a>

        <!-- Suppliers -->
<a href="{{ route('admin.suppliers_panel') }}"
   class="flex items-center gap-4 px-4 py-3 rounded-xl
   {{ request()->routeIs('admin.suppliers*')
       ? 'bg-pink-50 text-pink-600 shadow-sm'
       : 'text-gray-600 hover:bg-pink-50 hover:text-pink-600' }}">
    <span class="text-xl">👤</span>
    Suppliers
</a>

        <!-- Delivery Partner Requests -->
<a href="{{ route('admin.delivery.requests') }}"
   class="flex items-center gap-4 px-4 py-3 rounded-xl
   {{ request()->routeIs('admin.delivery.requests')
       ? 'bg-yellow-50 text-yellow-600 shadow-sm'
       : 'text-gray-600 hover:bg-yellow-50 hover:text-yellow-600' }}">
    <span class="text-xl">🚴‍♂️</span>
    Delivery Partners
</a>


        <div class="my-4 border-t"></div>

        <!-- Logout -->
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
            class="w-full flex items-center gap-4 px-4 py-3 rounded-xl
            text-red-500 hover:bg-red-50 transition">
                <span class="text-xl">⏻</span>
                Logout
            </button>
        </form>

    </nav>
</aside>

<!-- ===== Main Content ===== -->
<main class="lg:ml-72 w-full p-4 sm:p-6 lg:p-10">

    <div class="mb-8">
        <h1 class="text-3xl sm:text-4xl font-bold text-gray-800">
            @yield('page-title')
        </h1>
        <div class="h-1 w-24 bg-gradient-to-r from-blue-500 to-purple-500 mt-2 rounded"></div>
    </div>

    @yield('content')

</main>

</div>

</body>
</html>
