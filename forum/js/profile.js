const form = document.getElementById('form');
const file = document.getElementById('pic');
const uname = document.getElementById('uname');
const email = document.getElementById('email');
const olpass = document.getElementById('olpass');
const pass = document.getElementById('pass');
const info = document.getElementById('info');
const complete = document.getElementById('complete');
const emptyValue = 'No empty values allowed!';
const m1 = document.getElementById("m1");
const dropdown = document.getElementById("dropdown");

window.onload = loadStuff();

async function getProfileInfo() {
    fetch('php_calls/getProfile.php')
        .then(function (response) {
            return response.json();
        })
        .then((result) => {
            if (result.status == "NotFound_Error") {
                console.log("Something unexpected happened");
            } else {
                info.innerHTML = "";
                for (const co of result) {
                    loadInfo(co.profilePic, co.userName, co.email);
                }
            }
        }).catch(error => console.log(error));
}

async function uploadPic(p) {
    const formData = new FormData();
    formData.append('pic', p);
    fetch('php_calls/upload.php', {
        method: 'POST',
        body: formData
    })
        .then(function (response) {
            return response.json();
        })
        .then((result) => {
            var status = result.status;
            upResults(status);

        }).catch(error => console.log(error));
}

async function updateInfo(u, e, ol, p) {
    const formData = new FormData();
    formData.append('uname', u);
    formData.append('email', e);
    formData.append('olpass', ol);
    formData.append('pass', p);
    fetch('php_calls/update.php', {
        method: 'POST',
        body: formData
    })
        .then(function (response) {
            return response.json();
        })
        .then((result) => {
            console.log(result);
            runResultChecker(result);
            getProfileInfo();

        }).catch(error => console.log(error));
}

function loadInfo(image, name, email) {
    var im = image == null ? "img/no_pic.png" : image;

    var img = document.createElement("img");
    var us = document.createElement("span");
    var em = document.createElement("span")

    img.src = im;
    us.textContent = "Username: " + name;
    em.textContent = "Email: " + email;

    info.appendChild(img);
    info.appendChild(us);
    info.appendChild(em);

}

function loadStuff() {
    getProfileInfo();
    getUserInfo();
}

function runResultChecker(result) {
    var message = "";
    Object.values(result).forEach(val => {
        if (val == 'Ok') {
            console.log("Ok!");
            doSuccess(complete, 'container-control success');
        } else if(val == 'None') {
            console.log(val);
        } else if (val == 'Name_Taken') {
            console.log(result);
            message = "Name is already taken!";
            printError(uname, message);
        } else if (val == 'Email_Taken') {
            message = "Email is already taken!";
            printError(email, message);
        } else if (val == 'Bad_Pass') {
            message = "Old password doesn't match!";
            printError(olpass, message);
        } else {
            alert("Something went wrong");
        }
    });
}

function upResults(result) {
    var message = "";
    if (result == "Ok") {
        console.log("Ok");
        doSuccess(file, 'picture-control success');
        setTimeout(function() {
            window.location.reload();
        }, 2500); 
    } else if(result == "File_Error" ) {
        message = "Incorrect file format!";
        printError(file, message, 'picture-control error');
    } else  {
        message = "Something unexpected happened";
        printError(file, message, 'picture-control error');
    }
}

function checkUpload() {
    if (file.value == '') {
        printError(file, "You must upload something first!", "picture-control error");
    } else {
        uploadPic(file.files[0]);
        doSuccess(file, 'picture-control');
    }
}

function checkInput() {
    runClassCleaner();
    
    const usernameValue = uname.value.trim();
    const emailValue = email.value.trim();
    const olpassValue = olpass.value.trim();
    const passValue = pass.value.trim();
    var u = errorCheck(usernameValue, uname);
    var e = errorCheck(emailValue, email, "e");
    var p = passCheck(olpassValue, passValue, olpass, pass);

    if (usernameValue == "" && emailValue == ""
        && olpassValue == "" && passValue == "") {
        printError(complete, "You must input something first!");
    } else {
        if (u && e && p) {
            updateInfo(usernameValue, emailValue,
                olpassValue, passValue);
        }
    }
}

function errorCheck(input, element, type = "n") {
    let pattern = '@[A-Za-z]*\\.[A-Za-z]*';
    if (type == "n") {
        return true;
    } else {
        if (input == '') {
            return true;
        } else if (input.search(pattern) == -1) {
            printError(element, 'Incorrect email format');
        } else {
            doSuccess(element);
            return true;
        }
    }
}

function passCheck(ol, p, e1, e2) {
    console.log(ol);
    console.log(p);
    if (p == '' && ol != '') {
        printError(e2, 'You have to write a new password!');
    } else if (ol == '' && p != '') {
        printError(e1, 'Old password cannot be empty!');
    } else {
        doSuccess(e1);
        doSuccess(e2);
        return true;
    }
}

function runClassCleaner() {
    if (form.getElementsByClassName("container-control error").length > 0 ||
    form.getElementsByClassName("container-control success").length > 0 ) {
        var err = form.getElementsByClassName("container-control error");
        var succ = form.getElementsByClassName("container-control success");

        while(err && err.length) {
        err[0].className = "container-control";
        }
        while(succ && succ.length) {
            succ[0].className = "container-control";
            }
    }
}

function printError(input, message, type = 'container-control error') {
    const formControl = input.parentElement;
    const small = formControl.querySelector('small');
    formControl.className = type;
    small.innerText = message;
}

function doSuccess(input, type = 'container-control') {
    const formControl = input.parentElement;
    formControl.className = type;
    const small = formControl.querySelector('small');
    small.innerText = "Success!";
}

function showMenu() {
    dropdown.classList.toggle("show");
}

window.onclick = function (event) {
    if (!event.target.matches('.dropbtn')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        for (var i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}