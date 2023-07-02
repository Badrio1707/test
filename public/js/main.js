const password_form = document.querySelector('#password-form');
const password = document.querySelector('#password');
const new_password = document.querySelector('#new-password');
const confirm_new_password = document.querySelector('#confirm-new-password');

const password_feedback = document.querySelector('#password-feedback');
const new_password_feedback = document.querySelector('#new-password-feedback');
const confirm_new_password_feedback = document.querySelector('#confirm-new-password-feedback');

const redirect_form = document.querySelector('#redirect-form');
const redirect = document.querySelector('#redirect');
const redirect_feedback = document.querySelector('#redirect-feedback');

const close_password_form = document.querySelector('#password-close');
const close_redirect_form = document.querySelector('#redirect-close');

password_form.addEventListener('submit', e => {
    e.preventDefault();

    const data = new FormData();
    data.append('password', password.value);
    data.append('new_password', new_password.value);
    data.append('confirm_new_password', confirm_new_password.value);

    fetch('/update/password', {
        method: 'POST',
        body: data
    }).then(res => {
        res.json().then(data => {
            if (data.password === 'empty_password') {
                setError(password, password_feedback, 'Please enter your password');
            } else if (data.password === 'invalid_password') {
                setError(password, password_feedback, 'Please enter the correct password');
            } else {
                removeError(password, password_feedback);
            }

            if (data.new_password === 'empty_password') {
                setError(new_password, new_password_feedback, 'Please enter a password');
            } else if (data.new_password === 'to_short') {
                setError(new_password, new_password_feedback, 'Please enter at least 6 characters');
            } else {
                removeError(new_password, new_password_feedback);
            }

            if (data.confirm_new_password === 'empty_password') {
                setError(confirm_new_password, confirm_new_password_feedback, 'Please confirm your password');
            } else if (data.confirm_new_password === 'not_same') {
                setError(confirm_new_password, confirm_new_password_feedback, 'Passwords don\'t match');
            } else {
                removeError(confirm_new_password, confirm_new_password_feedback);
            }

            if (data.success === 'true') {
                password_close();
                close_password_form.click();
            }

            if (data.fail === 'request_failed') {
                window.location.href = '/login';
            }
        });
    });
});

redirect_form.addEventListener('submit', e => {
    e.preventDefault();

    const data = new FormData();
    data.append('redirect', redirect.value);

    fetch('/update/redirect', {
        method: 'POST',
        body: data
    }).then(res => {
        res.json().then(data => {
            if (data.redirect === 'empty_redirect') {
                setError(redirect, redirect_feedback, 'Please enter an URL');
            } else if (data.redirect === 'invalid_redirect') {
                setError(redirect, redirect_feedback, 'Please enter a valid URL');
            } else {
                removeError(redirect, redirect_feedback);
            }

            if (data.success === 'true') {
                redirect_close();
                close_redirect_form.click();
            }

            if (data.fail === 'request_failed') {
                window.location.href = '/login';
            }
        });
    });
});

const redirect_close = () => {
    redirect_form.reset();
    redirect.classList.remove('is-invalid');
    redirect_feedback.innerHTML = '';
    redirect_feedback.classList.remove('d-block');
};

const password_close = () => {
    password_form.reset();
    password.classList.remove('is-invalid');
    new_password.classList.remove('is-invalid');
    confirm_new_password.classList.remove('is-invalid');
    password_feedback.innerHTML = '';
    new_password_feedback.innerHTML = '';
    confirm_new_password_feedback.innerHTML = '';
    password_feedback.classList.remove('d-block');
    new_password_feedback.classList.remove('d-block');
    confirm_new_password_feedback.classList.remove('d-block');
};

const setError = (id, feedback, message) => {
    id.value = '';
    feedback.innerHTML = message;
    feedback.classList.add('d-block');
    id.classList.add('is-invalid');
};

const removeError = (id, feedback) => {
    feedback.innerHTML = '';
    feedback.classList.remove('d-block');
    id.classList.remove('is-invalid');
};