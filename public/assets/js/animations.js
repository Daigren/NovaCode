document.addEventListener("DOMContentLoaded", function() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1 
    });

    const hiddenElements = document.querySelectorAll('.fade-element');
    hiddenElements.forEach((el) => observer.observe(el));
});