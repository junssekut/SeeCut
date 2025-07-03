import Swiper from 'swiper/bundle';
import { Navigation, Pagination, EffectCoverflow, Autoplay } from 'swiper/modules';

// import Swiper and modules styles
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/effect-coverflow';
import 'swiper/css/bundle';

// Initialize Swiper only if the element exists
const initStylingDetailSwiper = () => {
    const swiperElement = document.querySelector('.styling-detail-swiper');
    if (swiperElement) {
        const swiper = new Swiper(".styling-detail-swiper", {
            effect: "coverflow",
            grabCursor: true,
            centeredSlides: true,
            spaceBetween: '10',
            slidesPerView: "auto",
            coverflowEffect: {
                rotate: 10,
                stretch: 2,
                depth: 100,
                modifier: 1,
                slideShadows: true,
            },
            loop: true,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
        });
    }
};

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', initStylingDetailSwiper);

// Initialize when Livewire updates
document.addEventListener('livewire:initialized', initStylingDetailSwiper);
document.addEventListener('livewire:navigated', initStylingDetailSwiper); 