const login_form = document.querySelector('#login-form');
const username = document.querySelector('#username');
const password = document.querySelector('#password');

const username_feedback = document.querySelector('#username-feedback');
const password_feedback = document.querySelector('#password-feedback');

login_form.addEventListener('submit', e => {
    e.preventDefault();
    const data = new FormData();
    data.append('username', username.value);
    data.append('password', password.value);

    fetch('/login', {
        method: 'POST',
        body: data
    }).then(res => {
        res.json().then(data => {
            if (data.username === 'empty_username') {
                setError(username, username_feedback, 'Please enter an username');
            } else if (data.username === 'invalid_username') {
                setError(username, username_feedback, 'Please enter a valid username');
            } else {
                removeError(username, username_feedback);
            }

            if (data.password === 'empty_password') {
                setError(password, password_feedback, 'Please enter a password');
            } else if (data.password === 'invalid_password') {
                setError(password, password_feedback, 'Please enter a valid password');
            } else {
                removeError(password, password_feedback);
            }

            if (data.success === 'true') {
                window.location.href = '/dashboard';
            }
        });
    });
});

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