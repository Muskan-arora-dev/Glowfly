<!-- @extends('layout.app') <!-- Assuming your navbar and footer are in layout.app -->

@section('content')
<x-category-slider :sliders="$sliders" />

<!-- Hero Slider -->
<!-- <div class="relative w-full overflow-hidden">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            
            <div class="swiper-slide relative">
                <img src="https://images.unsplash.com/photo-1586201375761-83865001e5d4?auto=format&fit=crop&w=1400&q=80" 
                     alt="Slide 1" class="w-full h-96 object-cover">
                <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center">
                    <h2 class="text-4xl md:text-5xl font-bold text-white">Glow Like Never Before</h2>
                </div>
            </div>
           
            <div class="swiper-slide relative">
                <img src="https://images.unsplash.com/photo-1618354691644-9c9a1ef84a16?auto=format&fit=crop&w=1400&q=80" 
                     alt="Slide 2" class="w-full h-96 object-cover">
                <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center">
                    <h2 class="text-4xl md:text-5xl font-bold text-white">Natural Skincare Products</h2>
                </div>
            </div>
            
            <div class="swiper-slide relative">
                <img src="https://images.unsplash.com/photo-1600180758895-41fc92c7d6b1?auto=format&fit=crop&w=1400&q=80" 
                     alt="Slide 3" class="w-full h-96 object-cover">
                <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center">
                    <h2 class="text-4xl md:text-5xl font-bold text-white">Makeup for Every Occasion</h2>
                </div>
            </div>
        </div>
        
        <div class="swiper-button-next text-white"></div>
        <div class="swiper-button-prev text-white"></div>
        <div class="swiper-pagination"></div>
    </div>
</div> -->


<!-- Featured Products -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h2 class="text-3xl font-bold text-[#654321] mb-6">Featured Products</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <!-- Product Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
            <img src="{{ asset('images/product1.jpg') }}" alt="Product 1" class="w-full h-48 object-cover">
            <div class="p-4">
                <h3 class="font-semibold text-[#654321]">Natural Face Cream</h3>
                <p class="text-[#401d07] font-medium mt-2">$29.99</p>
                <button class="mt-3 w-full bg-[#654321] text-[#F5DEB3] py-2 rounded-full hover:bg-[#401d07] transition">Add to Cart</button>
            </div>
        </div>
        <!-- Repeat product cards -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
            <img src="{{ asset('images/product2.jpg') }}" alt="Product 2" class="w-full h-48 object-cover">
            <div class="p-4">
                <h3 class="font-semibold text-[#654321]">Lipstick Set</h3>
                <p class="text-[#401d07] font-medium mt-2">$19.99</p>
                <button class="mt-3 w-full bg-[#654321] text-[#F5DEB3] py-2 rounded-full hover:bg-[#401d07] transition">Add to Cart</button>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
            <img src="{{ asset('images/product3.jpg') }}" alt="Product 3" class="w-full h-48 object-cover">
            <div class="p-4">
                <h3 class="font-semibold text-[#654321]">Herbal Shampoo</h3>
                <p class="text-[#401d07] font-medium mt-2">$24.99</p>
                <button class="mt-3 w-full bg-[#654321] text-[#F5DEB3] py-2 rounded-full hover:bg-[#401d07] transition">Add to Cart</button>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
            <img src="{{ asset('images/product4.jpg') }}" alt="Product 4" class="w-full h-48 object-cover">
            <div class="p-4">
                <h3 class="font-semibold text-[#654321]">Face Wash Gel</h3>
                <p class="text-[#401d07] font-medium mt-2">$14.99</p>
                <button class="mt-3 w-full bg-[#654321] text-[#F5DEB3] py-2 rounded-full hover:bg-[#401d07] transition">Add to Cart</button>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="bg-[#F5DEB3] py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-[#654321] mb-6">Shop by Category</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                <img src="{{ asset('images/category1.jpg') }}" alt="Skincare" class="w-full h-48 object-cover">
                <h3 class="text-center py-2 font-semibold text-[#654321]">Skincare</h3>
            </div>
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                <img src="{{ asset('images/category2.jpg') }}" alt="Makeup" class="w-full h-48 object-cover">
                <h3 class="text-center py-2 font-semibold text-[#654321]">Makeup</h3>
            </div>
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                <img src="{{ asset('images/category3.jpg') }}" alt="Haircare" class="w-full h-48 object-cover">
                <h3 class="text-center py-2 font-semibold text-[#654321]">Haircare</h3>
            </div>
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                <img src="{{ asset('images/category4.jpg') }}" alt="Fragrance" class="w-full h-48 object-cover">
                <h3 class="text-center py-2 font-semibold text-[#654321]">Fragrance</h3>
            </div>
        </div>
    </div>
</section>

@endsection

<!-- Swiper JS -->
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
<script>
    const swiper = new Swiper('.swiper-container', {
        loop: true,
        autoplay: { delay: 3000, disableOnInteraction: false },
        pagination: { el: '.swiper-pagination', clickable: true },
        navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
    });
</script>
@endpush 
