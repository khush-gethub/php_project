// Smooth scrolling with Lenis
const lenis = new Lenis()

function raf(time) {
    lenis.raf(time)
    requestAnimationFrame(raf)
}

requestAnimationFrame(raf)


// GSAP Scroll-triggered animations
gsap.registerPlugin(ScrollTrigger);

gsap.from(".card", {
    scrollTrigger: {
        trigger: ".card",
        start: "top 80%",
        end: "bottom 20%",
        toggleActions: "play none none none",
    },
    opacity: 0,
    y: 50,
    duration: 1,
    stagger: 0.2,
});

// Underline animation on hover for nav links
const navLinks = document.querySelectorAll('.menu a');

navLinks.forEach(link => {
    link.addEventListener('mouseenter', () => {
        gsap.to(link, {
            duration: 0.3,
            css: {
                textDecoration: 'underline'
            }
        });
    });
    link.addEventListener('mouseleave', () => {
        gsap.to(link, {
            duration: 0.3,
            css: {
                textDecoration: 'none'
            }
        });
    });
});