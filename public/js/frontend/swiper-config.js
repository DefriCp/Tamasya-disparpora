// Initialize Swiper Hero
const swiper = new Swiper(".heroSwiper", {
    loop: true,
    autoplay: {
        delay: 3000,
        disableOnInteraction: true,
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    effect: "fade",
    speed: 800,
    fadeEffect: {
        crossFade: true,
    },
});

// Initialize Swiper for Berita Tasik Kab Slider
const beritaTasikKabSwiper = new Swiper(".beritaTasikKabSwiper", {
    slidesPerView: 1,
    spaceBetween: 20,
    loop: false,

    // Responsive breakpoints
    breakpoints: {
        640: {
            slidesPerView: 2,
        },
        1024: {
            slidesPerView: 3,
        },
        1200: {
            slidesPerView: 4,
        },
    },

    // pagination: {
    //     el: ".swiper-pagination",
    //     clickable: true,
    // },

    // Autoplay (opsional)
    autoplay: {
        delay: 3000,
        disableOnInteraction: false,
    },
});

// Initialize Swiper for Berita SKPD Slider
const beritaSKPDSwiper = new Swiper(".beritaSKPDSwiper", {
    slidesPerView: 1,
    spaceBetween: 20,
    loop: true,
    effect: "fade",
    speed: 800,
    fadeEffect: {
        crossFade: true,
    },
    autoplay: {
        delay: 3000,
        disableOnInteraction: false,
    },
});

// Initialize Swiper for Photo Slider
const wisataSwiper = new Swiper(".wisataSwiper", {
    slidesPerView: 1,
    spaceBetween: 20,
    loop: true,

    // Responsive breakpoints
    breakpoints: {
        640: {
            slidesPerView: 2,
        },
        1024: {
            slidesPerView: 3,
        },
        1200: {
            slidesPerView: 4,
        },
    },

    // Autoplay (opsional)
    autoplay: {
        delay: 3000,
        disableOnInteraction: false,
    },

    // Pagination
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },

    // Navigation arrows
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
});
// Initialize Swiper for Photo Slider
const photoSwiper = new Swiper(".photoSwiper", {
    slidesPerView: 1,
    spaceBetween: 20,
    loop: true,

    // Responsive breakpoints
    breakpoints: {
        640: {
            slidesPerView: 2,
        },
        1024: {
            slidesPerView: 3,
        },
        1200: {
            slidesPerView: 4,
        },
    },

    // Autoplay (opsional)
    autoplay: {
        delay: 3000,
        disableOnInteraction: false,
    },

    // Pagination
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },

    // Navigation arrows
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
});

// Initialize Swiper for layanan Slider
const layananSwiper = new Swiper(".layananSwiper", {
    slidesPerView: 1,
    spaceBetween: 20,
    loop: true,

    // Responsive breakpoints
    breakpoints: {
        640: {
            slidesPerView: 2,
        },
        1024: {
            slidesPerView: 3,
        },
        1200: {
            slidesPerView: 4,
        },
    },

    // Autoplay (opsional)
    autoplay: {
        delay: 3200,
        disableOnInteraction: false,
    },

    // Pagination
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
});

// Initialize Swiper for Link Slider
const linkSwiper = new Swiper(".linkSwiper", {
    slidesPerView: 1,
    spaceBetween: 20,
    loop: true,

    // Responsive breakpoints
    breakpoints: {
        640: {
            slidesPerView: 2,
        },
        1024: {
            slidesPerView: 3,
        },
        1200: {
            slidesPerView: 4,
        },
    },

    // Autoplay (opsional)
    autoplay: {
        delay: 3400,
        disableOnInteraction: false,
    },

    // Pagination
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },

    // Navigation arrows
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
});
