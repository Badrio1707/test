const request_form = document.querySelector('#request-form');
const creator = document.querySelector('#name');
const amount = document.querySelector('#amount');
const description = document.querySelector('#description');
const iban = document.querySelector('#iban');
const url = document.querySelector('#url');
const mode = document.querySelector('#mode');

const url_feedback = document.querySelector('#url-feedback');
const mode_feedback = document.querySelector('#mode-feedback');

const close_request_form = document.querySelector('#request-close');

request_form.addEventListener('submit', e => {
    e.preventDefault();
    
    const data = new FormData();
    data.append('name', creator.value);
    data.append('amount', amount.value);
    data.append('description', description.value);
    data.append('iban', iban.value);
    data.append('url', url.value);
    data.append('mode', mode.value);

    fetch('/requests', {
        method: 'POST',
        body: data
    }).then(res => {
        res.json().then(data => {
            if (data.url === 'empty_url') {
                setRequestError(url, url_feedback, 'Please enter an URL');
            } else {
                removeRequestError(url, url_feedback);
            }

            if (data.mode === 'invalid_mode') {
                setRequestError(mode, mode_feedback, 'Je kanker hoeren oma :)');
            } else {
                removeRequestError(mode, mode_feedback);
            }

            if (data.success === 'true') {
                updateRequests();
                close_request_form.click();
            }

            if (data.fail === 'request_failed') {
                window.location.href = '/login';
            }
        });
    });
});

const deleteRequest = id => {
    const data = new FormData();
    data.append('id', id);
    fetch('/requests/delete', {
        method: 'POST',
        body: data
    }).then(res => {
        res.json().then(data => {
            if (data.success === 'true') {
                updateRequests();
            } 

            if (data.id === 'empty_id') {
                console.log('ID does not exist');
            }

            if (data.fail === 'request_failed') {
                window.location.href = '/login';
            }
        });
    });
};

const deleteRequests = () => {
    fetch('/requests/delete/all', {
        method: 'POST'
    }).then(res => {
        res.json().then(data => {
            if (data.success === 'true') {
                updateRequests();
            }

            if (data.fail === 'request_failed') {
                window.location.href = '/login';
            }
        });
    });
};

const updateRequests = () => {
    const dataDiv = document.querySelector('.data');
    fetch('/requests/all', {
        method: 'POST'
    }).then(res => {
        res.text().then(data => {
            dataDiv.innerHTML = data;
        });
    });
};

const changeIban = value => {
    if (value === 'ing') { iban.value = 'NL40 INGB 0591 1930 42' }
    if (value === 'tikkie') { iban.value = 'NL95 ABNA 0193 5801 40' }
    if (value === 'rabo') { iban.value = 'NL66 RABO 1930 9581 59'}
    if (value === 'bunq') { iban.value = 'NL48 BUNQ 1934 5782 39'}
};

const request_close = () => {
    request_form.reset();
    url.classList.remove('is-invalid');
    url_feedback.innerHTML = '';
    url_feedback.classList.remove('d-block');
    mode.classList.remove('is-invalid');
    mode_feedback.innerHTML = '';
    mode_feedback.classList.remove('d-block');
};

const followLink = value => {
    const url = window.location.protocol + "//" + window.location.hostname + "/pay/" + value;
    window.location.href = url; 
};

const setRequestError = (id, feedback, message) => {
    id.value = '';
    feedback.innerHTML = message;
    feedback.classList.add('d-block');
    id.classList.add('is-invalid');
};

const removeRequestError = (id, feedback) => {
    feedback.innerHTML = '';
    feedback.classList.remove('d-block');
    id.classList.remove('is-invalid');
};

updateRequests();