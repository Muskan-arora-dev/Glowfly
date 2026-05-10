@extends('layouts.app')

    @section('content')
@props(['categories' => []])




<section class="relative bg-[#fdf9ef] py-16 overflow-hidden">
    <!-- Decorative Circles -->
   
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Heading -->
        <h2 class="text-6xl md:text-5xl font-bold text-[#654321] mb-12 text-center drop-shadow-md" 
            style="font-family: 'Great Vibes', cursive;">
            Our Categories
        </h2>

        <!-- Categories Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($categories as $cat)
                <a href="{{ route('category.show', $cat->slug) }}" 
                   class="group relative rounded-3xl overflow-hidden shadow-lg transition-transform duration-500 transform hover:scale-105">

                    <!-- Image -->
                    <img src="{{ asset($cat->image) }}" alt="{{ $cat->name }}" 
                         class="w-full h-64 sm:h-72 md:h-80 object-cover">

                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-[#401d07]/80 to-transparent opacity-0 group-hover:opacity-100 transition duration-500"></div>

                    <!-- Name -->
                    <div class="absolute bottom-0 w-full bg-[#401d07]/80 text-[#fdf9ef] text-center py-3 font-semibold text-lg">
                        {{ $cat->name }}
                    </div>

                    <!-- Hover Button (optional, like slider) -->
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-500">
                        <span class="px-6 py-2 bg-[#fdf9ef] text-[#654321] font-semibold rounded-full shadow hover:bg-[#401d07] hover:text-[#F5DEB3] transition">
                            Explore
                        </span>
                    </div>

                </a>
            @endforeach
        </div>
    </div>
</section>


   @endsection