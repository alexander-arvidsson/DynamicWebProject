var modal = document.getElementById('modal');
const form = document.getElementById('form');
const uname = document.getElementById('uname');
const email = document.getElementById('email');
const pass = document.getElementById('pass');
const pass2 = document.getElementById('pass2');
const emptyValue = 'No empty values allowed!';


async function register(name, email, pass) {
    const formData = new FormData();
    formData.append('uname', name);
    formData.append('email', email);
    formData.append('pass', pass);

    fetch('php_calls/register_check.php', {
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

function checkInput() {
    ;
    const usernameValue = uname.value.trim();
    const emailValue = email.value.trim();
    const passValue = pass.value.trim();
    const passValue2 = pass2.value.trim();
    var u = inputCheck(usernameValue, uname);
    var e = inputCheck(emailValue, email, "e");
    var p = passCheck(passValue, passValue2, pass, pass2);

    if (u && e && p) {
        register(usernameValue, emailValue, passValue);
    }
}

function inputCheck(input, element, type = "n") {
    let pattern = '@[A-Za-z]*\\.[A-Za-z]*';
    if (type == "n") {
        if (input == '') {
            printError(element, emptyValue);
        } else {
            doSuccess(element);
            return true;
        }
    } else {
        if (input == '') {
            printError(element, emptyValue);
        } else if (input.search(pattern) == -1) {
            printError(element, 'Incorrect email format!');
        } else {
            doSuccess(element);
            return true;
        }
    }
}

function passCheck(p1, p2, e1, e2) {
    var p;
    var p_2;

    if (p1 == '') {
        printError(e1, emptyValue);
        p = true;
    } else {
        doSuccess(e1);
        p = false;
    }

    if (p2 == '') {
        printError(e2, emptyValue);
        p_2 = true;
    } else {
        doSuccess(e2);
        p_2 = false;
    }

    if(p || p_2) {
        return false;
    }
     else if (p2 != p1) {
        printError(e2, "Password doesn't match!");
        return false;
    } else {
        doSuccess(e1);
        doSuccess(e2);
        return true;
    }
}

function runResultChecker(result) {
    var message = "";
    if (result == 'Ok') {
        modal.style.display = "block";
        setTimeout(function() {
            window.location.href = "index.php";
        }, 2000); 
    } else if (result == 'Name_Taken') {
        console.log(result);
        message = "Username is already taken!";
        printError(uname, message);
    } else if (result == 'Email_Taken') {
        console.log(result);
        message = "Email is already taken!";
        printError(email, message);
    } else {
        printError(uname, "Error: something went wrong");
    }
}

function printError(input, message) {
    const formControl = input.parentElement;
    const small = formControl.querySelector('small');
    formControl.className = 'form-control error';
    small.innerText = message;
}

function doSuccess(input) {
    const formControl = input.parentElement;
    formControl.className = 'form-control success';
}