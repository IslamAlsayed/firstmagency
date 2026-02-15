// Hero Gallery Slider
document.addEventListener('DOMContentLoaded', function () {
    const gallery = document.querySelector('.hero-section .gallery');
    if (gallery) {
        const items = gallery.querySelectorAll('.item');
        const dots = gallery.querySelectorAll('.dot');
        let currentSlide = 0;
        let slideInterval;

        // Swipe/Drag variables
        let startX = 0;
        let currentX = 0;
        let isDragging = false;
        const swapper = gallery.querySelector('.swapper');

        function goToSlide(index) {
            // Remove active class from all items and dots
            items.forEach(item => item.classList.remove('active'));
            dots.forEach(dot => dot.classList.remove('active'));

            // Add active class to current item and dot
            items[index].classList.add('active');
            dots[index].classList.add('active');
            currentSlide = index;
        }

        function nextSlide() {
            const next = (currentSlide + 1) % items.length;
            goToSlide(next);
        }

        function prevSlide() {
            const prev = (currentSlide - 1 + items.length) % items.length;
            goToSlide(prev);
        }

        // Auto play
        function startAutoPlay() {
            slideInterval = setInterval(nextSlide, 3000);
        }

        function stopAutoPlay() {
            clearInterval(slideInterval);
        }

        // Dots click event
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                stopAutoPlay();
                goToSlide(index);
                startAutoPlay();
            });
        });

        // Touch/Mouse events for swipe/drag
        function handleStart(e) {
            isDragging = true;
            startX = e.type.includes('mouse') ? e.pageX : e.touches[0].pageX;
            stopAutoPlay();
            swapper.style.cursor = 'grabbing';
        }

        function handleMove(e) {
            if (!isDragging) return;
            e.preventDefault();
            currentX = e.type.includes('mouse') ? e.pageX : e.touches[0].pageX;
        }

        function handleEnd() {
            if (!isDragging) return;
            isDragging = false;
            swapper.style.cursor = 'grab';

            const diffX = startX - currentX;
            const threshold = 50; // Minimum swipe distance

            if (Math.abs(diffX) > threshold) {
                if (diffX > 0) {
                    // Swiped left - show next slide
                    nextSlide();
                } else {
                    // Swiped right - show previous slide
                    prevSlide();
                }
            }

            startAutoPlay();
        }

        // Mouse events
        swapper.addEventListener('mousedown', handleStart);
        swapper.addEventListener('mousemove', handleMove);
        swapper.addEventListener('mouseup', handleEnd);
        swapper.addEventListener('mouseleave', handleEnd);

        // Touch events
        swapper.addEventListener('touchstart', handleStart, { passive: true });
        swapper.addEventListener('touchmove', handleMove, { passive: false });
        swapper.addEventListener('touchend', handleEnd);

        // Prevent image dragging
        items.forEach(item => {
            const img = item.querySelector('img');
            if (img) {
                img.addEventListener('dragstart', (e) => e.preventDefault());
            }
        });

        // Set cursor style
        swapper.style.cursor = 'grab';

        // Start auto play
        startAutoPlay();

        // Pause on hover
        gallery.addEventListener('mouseenter', stopAutoPlay);
        gallery.addEventListener('mouseleave', () => {
            if (!isDragging) startAutoPlay();
        });
    }

    const menuToggle = document.getElementById('menu-toggle');
    const navLinks = document.getElementById('navbar');

    if (menuToggle && navLinks) {
        menuToggle.addEventListener('click', (e) => {
            navLinks.classList.toggle('active');
        });
    }

    document.addEventListener("click", (e) => {
        if (!e.target.closest("#header")) {
            navLinks.classList.remove("active");
            return;
        }
    });

    window.addEventListener("scroll", (e) => {
        navLinks.classList.remove("active");
    });

    // onscroll = function () {
    //     // Scroll Background

    //     if (scrollY <= 125) {
    //         // 0%
    //         header.style.background = "#005d4e00";
    //     } else if (scrollY <= 300) {
    //         // 25%
    //         header.style.background = "#005d4e61";
    //     } else if (scrollY <= 665) {
    //         // 75%
    //         header.style.background = "#005d4ebf";
    //     } else {
    //         // 100%
    //         header.style.background = "var(--main-color)";
    //     }

    //     // Start Scroll Up
    //     this.scrollY >= 1480 ? up.classList.add("show") : up.classList.remove("show");

    //     bars.classList.remove("active");
    //     nav.classList.add("show");
    // };
});
