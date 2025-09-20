// navbar.js

window.addEventListener("scroll", function () {
    const navbar = document.querySelector(".navbar");
    if (!navbar) return;

    let scrollThreshold = 400; // Default untuk desktop

    // Jika layar <= 768px (mobile), gunakan threshold lebih kecil
    if (window.matchMedia("(max-width: 768px)").matches) {
        scrollThreshold = 800;
    }

    // Jika layar <= 425px (mobile), gunakan threshold lebih kecil
    if (window.matchMedia("(max-width: 425px)").matches) {
        scrollThreshold = 300;
    }

    if (window.scrollY >= scrollThreshold) {
        navbar.classList.add("navbar-scrolled");
    } else {
        navbar.classList.remove("navbar-scrolled");
    }
});

// Toggle mobile menu
function toggleMobileMenu() {
    const mobileMenu = document.getElementById("mobileMenu");
    mobileMenu.classList.toggle("hidden");

    // Optional: reset dropdown saat menu ditutup
    if (!mobileMenu.classList.contains("hidden")) {
        closeDropdown();
    }
}

// Close mobile menu when clicking outside
document.addEventListener("click", function (event) {
    const mobileMenu = document.getElementById("mobileMenu");
    const menuButton = event.target.closest('[onclick="toggleMobileMenu()"]');
    const isDropdownButton = event.target.closest("#dropdownProfilBtn");

    if (
        !menuButton &&
        !isDropdownButton &&
        !mobileMenu.contains(event.target)
    ) {
        mobileMenu.classList.add("hidden");
        closeDropdown(); // Tutup dropdown jika terbuka
    }
});

function toggleMobileDropdown() {
    const dropdownContent = document.getElementById("mobileDropdown");
    const dropdownArrow = document.getElementById("dropdownArrow");

    if (dropdownContent.classList.contains("max-h-0")) {
        // Buka dropdown
        dropdownContent.classList.remove("max-h-0", "opacity-0");
        dropdownContent.classList.add("max-h-screen", "opacity-100");
    } else {
        // Tutup dropdown
        dropdownContent.classList.remove("max-h-screen", "opacity-100");
        dropdownContent.classList.add("max-h-0", "opacity-0");
    }

    dropdownArrow.classList.toggle("rotate-180");
}

function closeDropdown() {
    const dropdownContent = document.getElementById("mobileDropdown");
    const dropdownArrow = document.getElementById("dropdownArrow");

    dropdownContent.classList.remove("max-h-screen", "opacity-100");
    dropdownContent.classList.add("max-h-0", "opacity-0");

    dropdownArrow.classList.remove("rotate-180");
}
