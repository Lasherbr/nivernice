const carrossel = document.getElementById('carrossel');
const slides = document.querySelectorAll('.slide');
let current = 0;

if (slides.length > 0) {
    setInterval(() => {
        current = (current + 1) % slides.length;
        carrossel.style.transform = `translateX(-${current * 100}%)`;
    }, 4000);
}
