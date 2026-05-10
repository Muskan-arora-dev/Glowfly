@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <h2 class="text-2xl font-bold text-[#8f94fb] mb-4">Users</h2>

    @if($users->count() > 0)

    <!-- ================= DESKTOP / TABLE VIEW ================= -->
    <div class="hidden md:block bg-[#fdf9ef] shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gradient-to-r from-[#4e54c8] to-[#8f94fb] text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Action</th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-100">
                @foreach($users as $index => $user)
                <tr class="hover:bg-blue-50 hover:text-blue-600 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-black">
                        {{ $users->firstItem() + $index }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-black">
                        {{ $user->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-black">
                        {{ $user->email }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-black">
                        {{ ucfirst($user->status ?? 'active') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-black">
                        <a href="#"
                           class="px-2 py-1 bg-gradient-to-r from-[#4e54c8] to-[#8f94fb] text-white rounded hover:opacity-90 transition">
                            View
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- ================= MOBILE CARD VIEW ================= -->
    <div class="md:hidden space-y-4">
        @foreach($users as $index => $user)

        <div class="bg-white shadow rounded-lg border border-gray-100 p-4">
            <div class="flex justify-between items-center mb-2">
                <span class="text-sm font-semibold text-gray-600">
                    #{{ $users->firstItem() + $index }}
                </span>
                <span class="text-xs px-2 py-1 rounded bg-gray-100 text-gray-700">
                    {{ ucfirst($user->status ?? 'active') }}
                </span>
            </div>

            <div class="text-sm text-gray-700 mb-1">
                <strong>Name:</strong> {{ $user->name }}
            </div>

            <div class="text-sm text-gray-700 mb-3 break-all">
                <strong>Email:</strong> {{ $user->email }}
            </div>

            <a href="#"
               class="block text-center px-3 py-2 bg-gradient-to-r from-[#4e54c8] to-[#8f94fb] text-white rounded font-semibold hover:opacity-90 transition">
                View
            </a>
        </div>

        @endforeach
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>

    @else
    <div class="text-center p-6 bg-[#f7f2ea] rounded-lg text-[#8a6a52]">
        No users found.
    </div>
    @endif
</div>
@endsection
