@extends('layouts.app')

@section('content')


<section class="bg-[#f7deae] min-h-screen flex items-center justify-center py-20">
    <div class="text-center px-6 md:px-0">
        <!-- Category Name -->
        <h1 class="text-6xl md:text-7xl font-bold text-[#401d07] mb-4" 
            style="font-family: 'Great Vibes', cursive;">
            {{ $category->name }} Collection
        </h1>

        <!-- Collection Subheading -->
        <p class="text-2xl md:text-3xl text-[#401d07] font-semibold tracking-wide">
            Collection
        </p>
    </div>
</section>
@endsection
