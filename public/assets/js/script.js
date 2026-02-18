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

    const header = document.getElementById('header');
    const menuToggle = document.getElementById('menu-toggle');
    const navLinks = document.getElementById('navbar');
    if (menuToggle && navLinks) {
        menuToggle.addEventListener('click', (e) => {
            navLinks.classList.toggle('active');
        });
    }

    document.addEventListener("click", (e) => {
        if (!e.target.closest("#header")) {
            if (navLinks.classList.contains("active")) {
                navLinks.classList.remove("active");
            }
            return;
        }
    });

    let currentScroll = window.scrollY || document.documentElement.scrollTop;
    if (currentScroll <= 7) {
        header.classList.remove('scrolled');
    } else {
        header.classList.add('scrolled');
    }

    window.addEventListener('scroll', () => {
        if (header) {
            let currentScroll = window.scrollY || document.documentElement.scrollTop;
            if (currentScroll <= 7) {
                header.classList.remove('scrolled');
            } else {
                header.classList.add('scrolled');
            }
        }
    });

    const filterButtons = document.querySelectorAll('.filter-btn');
    const projectItems = document.querySelectorAll('.project-item');

    // Mapping من filter IDs إلى أسماء الـ tags الفعلية
    const tagFilterMap = {
        'website_design': 'Web Design',
        'graphic_design': 'Graphic Design'
    };

    // تهيئة جميع العناصر بـ fade-up و opacity 1
    projectItems.forEach(item => {
        item.classList.add('fade-up');
        item.style.opacity = '1';
    });

    if (filterButtons.length > 0) {
        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                const filter = button.getAttribute('data-filter');

                filterButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');

                projectItems.forEach(item => {
                    const tagsString = item.getAttribute('data-tags');
                    const tags = tagsString ? tagsString.split(',').map(tag => tag.trim()) : [];
                    const searchTag = filter === 'all' ? null : tagFilterMap[filter];

                    const shouldShow = filter === 'all' || (searchTag && tags.includes(searchTag));

                    if (shouldShow) {
                        // إظهار العنصر
                        item.style.display = 'block';
                        item.classList.remove('fade-down');
                        item.classList.add('fade-up');
                        item.style.opacity = '1';
                    } else {
                        // إخفاء العنصر
                        item.classList.remove('fade-up');
                        item.classList.add('fade-down');
                        item.style.opacity = '0';
                        setTimeout(() => {
                            if (item.classList.contains('fade-down')) {
                                item.style.display = 'none';
                            }
                        }, 300);
                    }
                });
            });
        });
    }
});
