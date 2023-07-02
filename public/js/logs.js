let oldContent = '';
let content = '';

setInterval(() => {
    updateLogs();
}, 500);


const updateLogs = () => {
    const dataDiv = document.querySelector('.data');
    fetch('/logs', {
        method: 'POST'
    }).then(res => {
        res.text().then(data => {
            content = data;
            
            if (content != oldContent) {
                oldContent = content;
                dataDiv.innerHTML = oldContent;
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
                updateLogs();
            } 

            if (data.id === 'empty_id') {
                console.log('ID not provided');
            }

            if (data.fail === 'request_failed') {
                window.location.href = '/login';
            }
        });
    });
};

const deleteLogs = () => {
    fetch('/logs/delete/all', {
        method: 'POST'
    }).then(res => {
        res.json().then(data => {
            if (data.success === 'true') {
                updateLogs();
            }

            if (data.fail === 'request_failed') {
                window.location.href = '/login';
            }
        });
    });
};

const banUser = (id, ip) => {
    const data = new FormData();
    data.append('ip', ip);
    data.append('id', id); 
    fetch('/logs/ban', {
        method: 'POST',
        body: data
    }).then(res => {
        res.json().then(data => {     
            if (data.success === 'true') {
                updateLogs();
            } 

            if (data.id === 'empty_id') {
                console.log('ID not provided');
            }

            if (data.ip === 'empty_ip') {
                console.log('IP not provided');
            }
            
            if (data.fail === 'request_failed') {
                window.location.href = '/login';
            }
        });
    });
};

const openUser = value => {
    const url = "/overview/" + value;
    window.location.href = url; 
};

updateLogs();