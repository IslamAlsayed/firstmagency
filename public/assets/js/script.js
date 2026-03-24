// Hero Gallery Slider
document.addEventListener('DOMContentLoaded', function () {
    $(document).ready(function () {
        let multiples = [
            document.querySelectorAll(".basic-multiple"),
            document.querySelectorAll(".basic-single"),
        ];
        if (multiples.length > 0) {
            multiples.forEach((multiple) => {
                multiple.forEach((select) => {
                    $(select).select2();
                });
            });
        }
    });
});

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
    const closeBtn = document.querySelector('.close');
    const ourServicesItems = document.querySelectorAll('.our_services');

    if (menuToggle && navLinks) {
        menuToggle.addEventListener('click', (e) => {
            document.body.style.overflow = navLinks.classList.contains('active') ? '' : 'hidden';

            navLinks.classList.toggle('active');
            ourServicesItems.forEach(item => item?.classList.remove('active'));
            document.querySelector('.our_services .services')?.classList.remove('active');
            navLinks?.classList.remove('scroll');
        });
    }

    if (closeBtn && navLinks) {
        closeBtn.addEventListener('click', (e) => {
            navLinks.classList.remove('active');
            document.body.style.overflow = '';
        });
    }

    // Handle services dropdown toggle on mobile
    ourServicesItems.forEach(item => {
        const toggleBtn = item.querySelector('.nav-link');

        if (toggleBtn) {
            toggleBtn.addEventListener('click', function (e) {
                // Check if screen is small (mobile/tablet)
                if (window.innerWidth <= 992) {
                    e.preventDefault();
                    e.stopPropagation();

                    // Close other open menus
                    ourServicesItems.forEach(otherItem => {
                        if (otherItem !== item) {
                            otherItem.classList.remove('active');
                        }
                    });

                    // Toggle current menu
                    item.classList.toggle('active');
                    navLinks.classList.toggle('scroll');
                }
            });
        }
    });

    document.addEventListener("click", (e) => {
        if (!e.target.closest("#header")) {
            if (navLinks.classList.contains("active")) {
                navLinks.classList.remove("active");
                document.body.style.overflow = '';
            }
            // Close services menu if clicking outside
            if (window.innerWidth <= 768) {
                ourServicesItems.forEach(item => {
                    if (!item.contains(e.target)) {
                        item.classList.remove('active');
                        document.body.style.overflow = '';
                    }
                });
            }
            return;
        }
    });

    let currentScroll = window.scrollY || document.documentElement.scrollTop;
    const forceScrolled = header.getAttribute('data-force-scrolled') === 'true';

    if (currentScroll <= 7 && !forceScrolled) {
        header.classList.remove('scrolled');
    } else {
        header.classList.add('scrolled');
    }

    window.addEventListener('scroll', () => {
        if (header) {
            const forceScrolled = header.getAttribute('data-force-scrolled') === 'true';
            let currentScroll = window.scrollY || document.documentElement.scrollTop;
            if (currentScroll <= 7 && !forceScrolled) {
                header.classList.remove('scrolled');
            } else {
                header.classList.add('scrolled');
            }
        }
    });

    const filterButtons = document.querySelectorAll('.section-with-filter .filter-btn');
    const projectItems = document.querySelectorAll('.project-item');

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
                    const searchTag = filter === 'all' ? null : filter;

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

    // Developer Section Auto-Switch and Magnetic Effect
    const effectSectionInners = document.querySelectorAll('.effect-section .inner');
    const magneticEffectImages = document.querySelectorAll('.magnetic-effect');
    if (effectSectionInners.length > 0) {
        let currentDevIndex = 0;

        // Auto-switch every 7 seconds
        setInterval(() => {
            effectSectionInners.forEach(inner => inner.classList.add('hidden'));
            currentDevIndex = (currentDevIndex + 1) % effectSectionInners.length;
            effectSectionInners[currentDevIndex].classList.remove('hidden');
        }, 7000);
    }

    // Magnetic effect on images
    if (magneticEffectImages.length > 0) {
        magneticEffectImages.forEach(img => {
            const parent = img.closest('.image');

            parent.addEventListener('mousemove', (e) => {
                const rect = parent.getBoundingClientRect();
                const centerX = rect.width / 2;
                const centerY = rect.height / 2;

                const mouseX = e.clientX - rect.left;
                const mouseY = e.clientY - rect.top;

                // Calculate distance from center
                const distX = (mouseX - centerX) / centerX;
                const distY = (mouseY - centerY) / centerY;

                // Apply magnetic effect (max 15px movement)
                const moveX = distX * 15;
                const moveY = distY * 15;

                img.style.transform = `translate(${moveX}px, ${moveY}px)`;
            });

            parent.addEventListener('mouseleave', () => {
                img.style.transform = 'translate(0, 0)';
            });
        });
    }

    const faqToggles = document.querySelectorAll('[data-faq-toggle]');
    if (faqToggles.length > 0) {
        faqToggles.forEach(toggle => {
            toggle.addEventListener('click', function () {
                const item = this.closest('[data-faq-item]');
                const answer = item.querySelector('[data-faq-answer]');
                const icon = this.querySelector('i');

                // Toggle active class
                item.classList.toggle('active');

                // Toggle icon
                if (item.classList.contains('active')) {
                    icon.classList.remove('fa-plus');
                    icon.classList.add('fa-minus');
                } else {
                    icon.classList.remove('fa-minus');
                    icon.classList.add('fa-plus');
                }
            });
        });
    }

    const imagesContainer = document.querySelector('[data-random-images]');

    if (imagesContainer) {
        const imageSlots = imagesContainer.querySelectorAll('[data-image-slot]');
        const totalImages = 4;
        const displayCount = 3;

        if (imageSlots.length > 0) {
            function getRandomImages() {
                const numbers = [];
                while (numbers.length < displayCount) {
                    const num = Math.floor(Math.random() * totalImages) + 1;
                    if (!numbers.includes(num)) {
                        numbers.push(num);
                    }
                }
                return numbers;
            }

            function updateImages() {
                const randomImages = getRandomImages();
                imageSlots.forEach((slot, index) => {
                    const img = slot.querySelector('img');
                    setTimeout(() => {
                        img.src = "/assets/images/website/categories/" + randomImages[index] + ".png";
                    }, 250);
                });
            }

            // تحديث عشوائي كل 3 ثوانٍ
            setInterval(updateImages, 3000);
        }
    }

    const buttons = document.querySelectorAll('.filter-btn-package');
    const priceButtons = document.querySelectorAll('.price-packages .filter-btn-price');
    const cards = document.querySelectorAll('.package-card');

    if (cards.length > 0) {
        if (priceButtons.length > 0) {
            priceButtons.forEach(btn => {
                btn.addEventListener('click', function () {
                    btn.classList.add('active');
                    priceButtons.forEach(b => {
                        if (b !== btn) b.classList.remove('active');
                    });
                    const datasetPrice = this.getAttribute('data-filter');
                    cards.forEach(card => {
                        const priceElement = card.querySelectorAll('.main-price');
                        priceElement.forEach(price => {
                            if (price.classList.contains(datasetPrice)) {
                                price.classList.remove('hidden');
                            } else {
                                price.classList.add('hidden');
                            }
                        });
                    });
                });
            });

            if (buttons.length > 0) {
                buttons.forEach(btn => {
                    btn.addEventListener('click', function () {
                        const target = this.getAttribute('data-target');

                        buttons.forEach(b => {
                            b.classList.remove('active', 'bg-blue-50', 'text-blue-600', 'shadow-inner');
                            b.classList.add('text-gray-600');
                        });
                        this.classList.add('active', 'bg-blue-50', 'text-blue-600', 'shadow-inner');
                        this.classList.remove('text-gray-600');

                        cards.forEach(card => {
                            setTimeout(() => {
                                if (card.getAttribute('data-category') === target) {
                                    card.classList.add('active');
                                    card.style.display = 'block';
                                } else {
                                    card.classList.remove('active');
                                    setTimeout(() => {
                                        card.style.display = 'none';
                                    }, 50);
                                }
                            }, 300);
                        });
                    });
                });
            }

            document.querySelector('[data-target="hosting"]').click();
        }
    }

    const filterOperatingSystems = document.querySelectorAll('.filter-operating-systems');
    const categories = document.querySelectorAll('[data-category]');

    if (filterOperatingSystems.length > 0) {
        filterOperatingSystems.forEach(button => {
            button.addEventListener('click', () => {
                const filter = button.getAttribute('data-filter');

                // Update active state of buttons
                filterOperatingSystems.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');

                // Show/hide categories
                if (categories.length > 0) {
                    categories.forEach(category => {
                        if (category.getAttribute('data-category') === filter) {
                            category.classList.remove('hidden');
                        } else {
                            category.classList.add('hidden');
                        }
                    });
                }
            });
        });
    }

    const officialToggles = document.querySelectorAll('[data-official-toggle]');
    if (officialToggles.length > 0) {
        const officialAnswers = document.querySelectorAll('[data-official-answer]');
        officialToggles.forEach(toggle => {
            toggle.addEventListener('click', () => {
                const item = toggle.closest('[data-official-item]');
                const answer = item.querySelector('[data-official-answer]');
                item.classList.toggle('active');

                if (officialAnswers.length > 0) {
                    officialAnswers.forEach(el => {
                        if (el !== answer) el.style.height = null;
                    });
                }

                if (answer.style.height) {
                    answer.style.height = null;
                } else {
                    answer.style.height = answer.scrollHeight + "px";
                }
            });
        });
    }

    const steps = document.querySelectorAll('.work-lines-sections .step');
    if (steps.length > 0) {
        const stepInterval = 1000; // 1000ms بين كل خطوة
        const totalDuration = stepInterval * steps.length + 1000; // المدة الكلية + 1 ثانية انتظار

        function animateSteps() {
            steps.forEach((step, index) => {
                step.classList.remove('active');
            });

            steps.forEach((step, index) => {
                setTimeout(() => {
                    step.classList.add('active');
                }, 500 + (index * stepInterval));
            });
        }

        // الحركة الأولى
        animateSteps();

        // تكرار لا نهائي
        setInterval(animateSteps, totalDuration);
    }

    const icons = document.querySelectorAll('.icon[data-color]');
    icons.forEach(icon => {
        const color = icon.getAttribute('data-color');
        if (color) icon.style.setProperty('--icon-color', color);
    });

    const viewer = document.getElementById('imageViewer');
    const viewerImg = document.getElementById('viewerImg');

    if (viewer && viewerImg) {
        document.querySelectorAll('.clickable-img').forEach(img => {
            img.addEventListener('click', () => {
                viewerImg.src = img.dataset.src;
                viewer.classList.add('active');
            });
        });

        viewer.addEventListener('click', (e) => {
            if (e.target === viewer) {
                viewer.classList.remove('active');
            }
        });
    }
});
