setInterval(() => { 
    const data = new FormData();
    data.append('id', document.querySelector('#user_id').value);
    fetch('/user/online', {
        method: 'POST',
        body: data
    });
}, 3000);