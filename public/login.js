const tl = gsap.timeline();
tl.from("#container", {
    y: -900,
    scale: 0,
    opacity: 0,
    delay: 1,
    duration: 0.7,
});

tl.from(".form, .form-header, .form-inp, .form-footer, #error,.err-content", {
    y: 100,
    opacity: 0,
    duration: 0.5,
    stagger: 0.2,
});
