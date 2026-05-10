// public/js/main.js
document.addEventListener('DOMContentLoaded', () => {

    // Mobile Menu Toggle
    const menuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    if (menuBtn && mobileMenu) {
        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }

    // Optional: Search Input Focus Effect
    const searchInput = document.querySelector('input[placeholder="Search products..."]');
    if (searchInput) {
        searchInput.addEventListener('focus', () => {
            searchInput.classList.add('ring-4', 'ring-[#F5DEB3]');
        });
        searchInput.addEventListener('blur', () => {
            searchInput.classList.remove('ring-4', 'ring-[#F5DEB3]');
        });
    }

});
