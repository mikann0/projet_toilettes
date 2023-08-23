function openSidebar() {
    document.getElementById("sidebar").style.display = "block";
}
function closeSidebar() {
    document.getElementById("sidebar").style.display = "none";
}

function togglePassword1() {
    const inputPassword = document.getElementById("inputPassword1");
    const eye1 = document.getElementById("eye1");
    if (inputPassword.type === "password") {
        console.log("input has password");
        inputPassword.type = "text";
        eye1.classList.remove('fa-eye');
        eye1.classList.add('fa-eye-slash');
    } else {
        console.log("input has no password");
        inputPassword.type = "password";
        eye1.classList.remove('fa-eye-slash');
        eye1.classList.add('fa-eye');
    }
}

function togglePassword2() {
    const inputPassword = document.getElementById("inputPassword2");
    const eye2 = document.getElementById("eye2");
    if (inputPassword.type === "password") {
        console.log("input has password");
        inputPassword.type = "text";
        eye2.classList.remove('fa-eye');
        eye2.classList.add('fa-eye-slash');
    } else {
        console.log("input has no password");
        inputPassword.type = "password";
        eye2.classList.remove('fa-eye-slash');
        eye2.classList.add('fa-eye');
    }
}


function activateTextarea() {
    const textArea = document.getElementById("commentaire");
    if (!check) {
        textArea.classList.remove("inactive");
        textArea.classList.add("active");
        textArea.disabled = false;
        textArea.focus();

    } else {
        textArea.classList.add("inactive");
        textArea.classList.remove("active");
        textArea.disabled = true;
    }
    check = !check;

}

