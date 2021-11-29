var mod = document.getElementById('searchModal');
var modalArea = document.getElementById('modalArea');
var search = document.getElementById("search");
var option = document.getElementById("opt");
var menu = document.getElementById("menu");
var textString = ": result(s) found.";
var userId;

async function searchComments(input, flag) {
    const formData = new FormData();
    formData.append('input', input);
    formData.append('flag', flag);
    fetch('php_calls/search.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (modalArea.childNodes.length > 0) {
                modalArea.innerHTML = "";
            }
            var res = document.createElement("span");
            res.className = "res";
            if (data.status == 'NotFound_Error') {
                res.textContent = "0" + textString;
                modalArea.append(res);
            } else {
                for (const co of data) {
                    addSearchComment(co.userName, co.date, co.topic, co.comment, co.profilePic);
                }
                res.textContent = String(modalArea.childNodes.length) + textString;
                modalArea.insertBefore(res, modalArea.childNodes[0]);
            }
            loadResults();
        });
}

function addSearchComment(us, date, topic, comment, profilePic) {
    var c = createComment();
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
    modalArea.appendChild(c);
}

async function getUserInfo() {
    const r1 = await fetch('php_calls/getUserInfo.php');
    if ( r1.redirected) {
        return "Not_Logged"
    } else {
        const r2 = await r1.json();
        userId = r2[0].id;
        var i = document.createElement("i");
        i.className = "fa fa-sort-down";
        var name = r2[0].userName;
        var men = r2[0].profilePic;
        var im = document.createElement("img");
        var userPic = men == null ? "img/no_pic.png" : men;
    
        console.log(userId);
        m1.innerText = name + " ";
        m1.append(i);
        im.src = userPic;
    
        menu.append(im);
        console.log(name);
    
        return "Done";
    }
}


function loadResults() {
    mod.style.display = 'flex';
}

function createComment() {
    var comment = document.createElement("div");
    comment.className = "comment";
    return comment;
}

function startSearch() {
    var flag = option.selectedOptions[0].text;

    if (flag == "All") {
        flag = "a";
    } else if (flag == "Topic") {
        flag = "t";
    } else if (flag == "Content") {
        flag = "c";
    }
    var input = search.value;

    if (!inputCheck(input)) {
        searchComments(input, flag);
    }
}

window.addEventListener("click", function (event) {
    if (event.target == mod) {
        mod.style.display = "none";
    }
});

function inputCheck(input) {
    if (input.length < 2) {
        alert("Input must be at least two characters!");
        return true;
    }
}

function tryParse(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return "Not_Logged";
    }
    return str.json();
}