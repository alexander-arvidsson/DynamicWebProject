var modal = document.getElementById('login');
const form = document.getElementById('form');
const submit = document.getElementById('sub');
const username = document.getElementById('uname');
const password = document.getElementById('psw');
const empt_user = "Username cannot be empty";
const empt_pass = "Password cannot be empty";
const empt = "Username & Password cannot be empty";

async function login() {
    const formData = new FormData();
    formData.append('uname', username.value);
    formData.append('psw', password.value);

    if (infoCheck(username) && infoCheck(password)) {
        printError(username, empt);
    } else if (infoCheck(username)) {
        printError(username, empt_user)
    } else if (infoCheck(password)) {
        printError(username, empt_pass)
    } else {
        fetch('php_calls/login_check.php', {
            method: 'POST',
            body: formData
        })
            .then(function (response) {
                return response.json();
            })
            .then((result) => {
                var stat = result.status;
                runResultChecker(stat);

            }).catch(error => console.log(error));
    }
}

function registr() {
    window.location.href = 'register.php';
}

function getLogin() {
    modal.style.display = 'block';
}

function cancelLogin() {
    removeInfo(username, password);
    modal.style.display = "none";
}

window.onclick = function (event) {
    if (event.target == modal) {
        removeInfo(username, password);

        modal.style.display = "none";
    }
}

function removeInfo(user, pass) {
    var remUs = user.parentElement;
    var remPass = pass.parentElement;
    remUs.className = "container-control";
    remPass.className = "container-control";
    form.reset();

}

function infoCheck(input) {
    var val = input.value.trim();
    if (val == "") {
        return true;
    } else {
        return false;
    }
}

function runResultChecker(result) {
    var message = "";
    if(result == 'Ok') {
        window.location.reload();
    } else {
        message = "Incorrect username or password";
        printError(username, message);
    }
}

function printError(input, message) {
    const containerControl = input.parentElement;
    const small = containerControl.querySelector('small');
    containerControl.className = 'container-control error';
    small.innerText = message;
}