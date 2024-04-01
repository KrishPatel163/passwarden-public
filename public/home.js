function decryptAndCopy(encryptedPassword) {
    const csrf_token = document.querySelector('meta[name = "csrf-token"]').getAttribute('content')
    fetch('http://127.0.0.1:8000/decrypt', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrf_token, // Laravel CSRF token
        },
        body: JSON.stringify({
            pass: encryptedPassword
        }),
    })
    .then(response => response.json())
    .then(data => {
        // console.log(data)
        navigator.clipboard.writeText(data.password).then(() => {
            alert("password copied successfully!")
        }, (err) => {
            alert("error: ", err)
        })
    })
    .catch(error => console.error('Error:', error));
}

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('generatePasswordButton').addEventListener('click', function() {
        var length = document.getElementById("inputLength").value; 
        var result = '';
        var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_+-={}[]|?/><';
        var charactersLength = characters.length;
        for (var i = 0; i < length; i++) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        document.getElementById("inputPassword").value = result;
        return result;
    });
});
