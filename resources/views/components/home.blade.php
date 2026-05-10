
<!-- Feature Section with Typing Effect -->  
<section class="bg-[#fdf9ef] pt-20 pb-4">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center md:space-x-12">
         <!-- Left: Text --> 
        <div class="md:w-1/2 mb-10 md:mb-0"> 
            <!-- Single-Line Heading --> 
             <h1 class="text-4xl md:text-5xl font-extrabold text-[#654321] drop-shadow-[2px_4px_6px_rgba(0,0,0,0.2)] mb-4"> GlowFly – Radiance Unlocked </h1> 
             <!-- First Fixed Line -->
               <p class="text-[#401d07] text-3xl md:text-2xl font-semibold mb-2" style="font-family: 'Great Vibes', cursive;"> Feel the glow that's your confidence and </p> 
              <!-- Second Typing Line -->
                <p id="typingText" class="text-[#401d07] text-xl md:text-2xl font-semibold h-10 overflow-hidden whitespace-nowrap border-r-4 border-[#654321] pr-2" style="font-family: 'Great Vibes', cursive;"> </p>
        </div>




        <!-- Right: Top Image + Bottom 2 Images -->
        <div class="md:w-1/2 flex flex-col items-center">

          <!-- Top Big Image -->
            <div class="w-3/4 mx-auto rounded-xl overflow-hidden bg-[#f7deae] border-8 border-[#654321]">
                 <img src="{{ asset('images/head2.jpg') }}" class="w-full h-80 object-cover" alt="Top Image" /> 
             </div> 
                <!-- Bottom Row --> 
                <div class="flex justify-between mt-[-30px] px-0 gap-2">
                    <div class="w-[49%] rounded-xl overflow-hidden bg-[#f7deae] border-8 border-[#654321] shadow-lg"> 
                        <img src="{{ asset('images/head1.jpg') }}" class="w-full h-64 object-cover" alt="Bottom Left Image" />
                    </div> 
                    <div class="w-[49%] rounded-xl overflow-hidden bg-[#f7deae] border-8 border-[#654321] shadow-lg">
                        <img src="{{ asset('images/head.jpg') }}" class="w-full h-64 object-cover" alt="Bottom Right Image" />
                    </div>
                </div>

        </div>
    </div>
</section>

<style>
    .floating {
    animation: float 6s ease-in-out infinite;
    opacity: 0.9;

    :root {
  --bg-color: #ffffff; /* Light mode background */
  --text-color: #000000; /* Light mode text */
}

[data-theme="dark"] {
  --bg-color: #121212; /* Dark mode background */
  --text-color: #f0f0f0; /* Dark mode text */
}

}

@keyframes float {
    0%   { transform: translateY(0px); }
    50%  { transform: translateY(-20px); }
    100% { transform: translateY(0px); }
}

    </style>

<!-- Typing Effect Script -->
<script>
    const text = " Your Glow, Your Way";
    const typingText = document.getElementById("typingText");
    let index = 0;

    function typeEffect() {
        if (index < text.length) {
            typingText.innerHTML += text.charAt(index);
            index++;
            setTimeout(typeEffect, 90);
        }
    }

    document.addEventListener("DOMContentLoaded", typeEffect);
</script>
