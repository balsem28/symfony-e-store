console.clear();

document.addEventListener('DOMContentLoaded', function () {


    const loginBtn = document.getElementById('login');
    const signupBtn = document.getElementById('signup');

    if (loginBtn && signupBtn) {
        loginBtn.addEventListener('click', function () {
            window.history.pushState("","","/login")


            const signupForm = document.querySelector('.signup');
            const loginForm = document.querySelector('.login');

            signupForm.classList.toggle('slide-up');
            loginForm.classList.toggle('slide-up');
        });

        signupBtn.addEventListener('click', function () {
            const signupForm = document.querySelector('.signup');
            const loginForm = document.querySelector('.login');
            window.history.pushState("","","/create")


            signupForm.classList.toggle('slide-up');
            loginForm.classList.toggle('slide-up');
        });
    } else {
        console.error('Login or signup button not found.');
    }
});

