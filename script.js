const slides = document.querySelectorAll('.slide');
let current = 0;
if (slides.length > 0) {
    slides[current].style.display = 'block';
    setInterval(() => {
        slides[current].style.display = 'none';
        current = (current + 1) % slides.length;
        slides[current].style.display = 'block';
    }, 4000);
}
