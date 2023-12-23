
window.addEventListener('scroll', function() {

    var navbar = document.querySelector('.n');
    navbar.classList.toggle('transparent', window.scrollY > 0);
});
