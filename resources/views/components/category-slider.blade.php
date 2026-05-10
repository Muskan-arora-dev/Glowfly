@props(['categories' => []])

<section class="pt-4 pb-12 bg-[#fdf9ef]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-6xl font-bold text-[#654321] mb-6 text-center" style="font-family: 'Great Vibes', cursive;">
            Our Categories
        </h2>

        <div class="overflow-hidden relative">
            <div id="hoverSlider" class="flex gap-6 overflow-x-auto scrollbar-hide transition-all duration-300">
                @foreach($categories as $cat)
                    <a href="{{ route('category.show', $cat->slug) }}" class="min-w-[16.66%] flex-shrink-0 rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-300 block">
                        <img src="{{ asset($cat->image) }}" alt="{{ $cat->name }}" class="w-full h-80 object-cover">
                        <div class="bg-[#401d07] text-[#fdf9ef] text-center py-3 font-semibold">
                            {{ $cat->name }}
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>

<style>
.scrollbar-hide::-webkit-scrollbar { display: none; }
.scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<script>
const slider = document.getElementById('hoverSlider');
slider.addEventListener('mousemove', e => {
    const rect = slider.getBoundingClientRect();
    const mouseX = e.clientX - rect.left;
    const width = rect.width;
    const scrollAmount = slider.scrollWidth - width;
    slider.scrollLeft = (mouseX / width) * scrollAmount;
});
</script>
