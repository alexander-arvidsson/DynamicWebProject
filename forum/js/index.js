const contentArea = document.getElementById("content");
const load = document.getElementById("load");
const m1 = document.getElementById("m1");
const dropdown = document.getElementById("dropdown");
var id;
var max;

window.onload = getUserInfo().then((result) => {
    console.log(result);
    getComments();
    
});

async function getComments(offset = 0, limit = 12) {
    const formData = new FormData();
    formData.append('offset', offset);
    formData.append('limit', limit);
    fetch('php_calls/getComments.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (data.status == 'NotFound_Error') {
                console.log("Error");
            } else {
                max = data.length - 1;
                id = data[max].id;
                console.log(id);
                for (const co of data) {
                    addComment(co.id, co.userName, co.userId, co.date, co.topic, co.comment, co.profilePic, limit);
                }

                displayLoad(limit);
            }
        });
}

async function loadSingle(offset, limit) {
    const formData = new FormData();
    formData.append('offset', offset);
    formData.append('limit', limit);
    fetch('php_calls/getComments.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (data.status == 'NotFound_Error') {
                console.log("Error");
            } else {
                var co = data[0];
                addComment(co.id, co.userName, co.userId, co.date, co.topic, co.comment, co.profilePic, limit);
                removeInfo(topic, comment);
            }
        });
}

async function deleteComment(commentId, comId) {
    const formData = new FormData();
    formData.append('commentId', commentId);
    fetch('php_calls/deleteComment.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (data.status == 'NotFound_Error') {
                console.log("Error");
            } else {
                removeComment(comId);
            }
        });
}


function removeComment(coId) {
    let child = document.getElementById(String(coId));
    console.log(child);
    contentArea.removeChild(child);
}

function addComment(coId, us, usId, date, topic, comment, profilePic, limit) {
    var com = "d" + String(coId);
    var c = createComment(com);
    console.log(c);
    var im = profilePic == null ? "img/no_pic.png" : profilePic;

    var u_cont = document.createElement("div");
    var img = document.createElement("img");
    var auth = document.createElement("span");
    var stamp = document.createElement("small")
    var top = document.createElement("h4");
    var post = document.createElement("p");

    u_cont.className = "us";
    img.src = im;
    auth.textContent = us + " ";
    stamp.textContent = date;
    top.textContent = topic;
    post.textContent = comment;

    u_cont.appendChild(img);
    u_cont.appendChild(auth);
    u_cont.appendChild(stamp);
    c.appendChild(u_cont);
    c.appendChild(top);
    c.appendChild(post);

    if (!noUserId() && userId == usId) {
        var delBtn = document.createElement("button");
        delBtn.className = "btn";
        delBtn.setAttribute("id", coId);
        delBtn.textContent = "Remove";
        console.log(delBtn);
        c.appendChild(delBtn);
    }

    if (limit == 1) {
        contentArea.insertBefore(c, contentArea.childNodes[0]);
        if (!noUserId() && userId == usId) {
            createDeleteBtn(coId, com);
        }       

    } else {
        contentArea.appendChild(c);
        if (!noUserId() && userId == usId) {
            createDeleteBtn(coId, com);
        }
    }
}

function createDeleteBtn(coId, comId) {
    const button = document.getElementById(String(coId));
    button.addEventListener("click", function () {
        deleteComment(coId, comId);
    });
}

function createComment(coId) {
    var comment = document.createElement("div");
    comment.className = "comment";
    comment.setAttribute("id", coId);
    return comment;
}

load.addEventListener("click", function () {
    getComments(id);
})

function displayLoad(limit) {
    console.log(limit);
    if (max == limit - 1) {
        load.style.display = "block";
    } else {
        load.style.display = "none";
    }
}

function showMenu() {
    if (dropdown == null) {
        getLogin();
    } else {
        dropdown.classList.toggle("show");
    }
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

function noUserId() {
    if (userId == null) {
        return true;
    }
}