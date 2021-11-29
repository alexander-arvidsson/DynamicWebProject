const modal = document.getElementById('post_comment');
const submit = document.getElementById('sub');
const topic = document.getElementById('topic');
const comment = document.getElementById('comment');
const empt = "Topic and comment cannot be empty!";
const empt_topic = "Topic cannot be empty!";
const empt_comment = "Comment cannot be empty!";
var userId;

async function postComment() {
    const formData = new FormData();
    formData.append('topic', topic.value);
    formData.append('comment', comment.value);
    formData.append('time', getTime());
    formData.append('date', getDate());

    if (infoCheck(topic) && infoCheck(comment)) {
        printError(topic, empt);
    } else if (infoCheck(topic)) {
        printError(topic, empt_topic);
    } else if (infoCheck(comment)) {
        printError(topic, empt_comment);
    } else {
        fetch('php_calls/post_check.php', {
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

function getCommentForm() {
    modal.style.display = 'block';
    console.log(length);
}

window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
        removeInfo(topic, comment);
    }
}

function printError(input, message) {
    const containerControl = input.parentElement;
    const small = containerControl.querySelector('small');
    containerControl.className = 'container-control error';
    small.innerText = message;
}

function removeInfo(topic, comment) {
    var t = topic.parentElement;
    t.className = "container-control";
    topic.value = "";
    comment.value = "";
}

function infoCheck(input) {
    var val = input.value.trim();
    return val == "" ? true : false;
}

function runResultChecker(result) {

    var message = "";
    if (result == 'Ok') {
        loadSingle(id, 1);
        console.log("posted");
    } else {
        message = "Error: Something unexpected happened";
        console.log(result);
        printError(topic, message);
    }
}

function getTime() {
    var currentDate = new Date();
    var min = currentDate.getMinutes().toString();
    var hour = currentDate.getHours().toString();

    return zeroCheck(hour) + ":" + zeroCheck(min);
}

function zeroCheck(n) {
    return n < 10 ? '0' + n : n;
}

function getDate() {
    return (new Date()).toISOString().split('T')[0];
}