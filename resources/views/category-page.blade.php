@extends('layouts.app')

@section('content')


<!-- Category Header Section -->
<section class="w-full bg-[#fdf9ef] py-16 flex flex-col items-center justify-center">
    <div class="text-center px-6">
        <h1 class="text-6xl md:text-7xl font-bold mb-4 text-[#401d07]" style="font-family: 'Great Vibes', cursive;">
            {{ $category->name }} Collection
        </h1>
        <p class="text-2xl md:text-3xl text-[#401d07] font-semibold tracking-wide mb-4">
            Explore Our Products
        </p>
        <div class="w-24 h-1 bg-[#401d07] mx-auto rounded-full"></div>
    </div>
</section>

<!-- Subcategory Cards Section -->
<section class="pt-12 pb-12 bg-[#fdf9ef]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
            @foreach($category->subcategories as $sub)
            <div class="rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 flex flex-col h-full bg-[#fdf9ef]">
            
            <!-- Image -->
            <img src="{{ asset($sub->image) }}" alt="{{ $sub->name }}" class="w-full h-60 object-cover">

            <!-- Content -->
            <div class="flex-1 flex flex-col justify-between">
                <!-- Description -->
                <p class="text-sm text-[#654321] p-4">
                    {{ $sub->description }}
                </p>

                <!-- Subcategory Name -->
                <h3 class="w-full bg-[#654321] text-[#fdf9ef] text-center font-semibold text-lg py-3">
    <a href="{{ route('subcategory.show', $sub->slug) }}">
        {{ $sub->name }}
    </a>
</h3>

            </div>
        </div>

         @endforeach
    </div>
            </div>
</section>


@endsection
