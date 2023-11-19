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

function togglePassword3() {
    const inputPassword = document.getElementById("inputPassword3");
    const eye3 = document.getElementById("eye3");
    if (inputPassword.type === "password") {
        console.log("input has password");
        inputPassword.type = "text";
        eye3.classList.remove('fa-eye');
        eye3.classList.add('fa-eye-slash');
    } else {
        console.log("input has no password");
        inputPassword.type = "password";
        eye3.classList.remove('fa-eye-slash');
        eye3.classList.add('fa-eye');
    }
}


function activateTextarea() {
    const textArea = document.getElementById("comment_commentaire");
    if (textArea.disabled) {
        textArea.disabled = false;
        textArea.focus();

    } else {
        textArea.disabled = true;
    }
}



function buttonActive() {
    const check_mes_commentaires = document.getElementById('check_mes_commentaires');
    const check_autres_commentaires = document.getElementById('check_autres_commentaires');
    const submitButton = document.getElementById('submitButton');
    if (check_mes_commentaires.checked && check_autres_commentaires.checked) {
        submitButton.removeAttribute('disabled');
        submitButton.classList.remove('button3');
        submitButton.classList.add('button2');
    } else {
        submitButton.setAttribute('disabled', 'true');
        submitButton.classList.remove('button2');
        submitButton.classList.add('button3');
    }
}

// note by star
/* 
When the DOM (page) is loaded, add event listeners to every radio buttons and to the #clear-filter button.
*/
document.addEventListener("DOMContentLoaded", function () {
    // div containing the radio buttons
    const clearButton = document.querySelector('#clear-filter');
    const radioButtons = document.querySelectorAll('.filtrer-note > input[type="radio"]');
    const hiddenInput = document.querySelector('#comment_note');

    if (hiddenInput) {
        radioButtons.forEach(button => {
            if (button.value <= hiddenInput.value) {
                button.nextElementSibling.setAttribute('data-selected', 'true');
            }
        });
    }

    if (clearButton) {
        clearButton.addEventListener("click", function () {
            const all_toillets = document.querySelectorAll('.note_filtre');
            all_toillets.forEach(toillet_div => {
                toillet_div.style.display = "flex";
            });
            radioButtons.forEach(button => {
                button.checked = false;
            });
        });
    }

    radioButtons.forEach(button => {
        button.addEventListener("change", function () {
            radioButtons.forEach(_button => {
                _button.nextElementSibling.setAttribute('data-selected', 'false');
            });
            const selectedValue = this.value;

            if (hiddenInput) {
                hiddenInput.value = selectedValue;
            }

            const all_toillets = document.querySelectorAll('.note_filtre');
            // display the toillets div that have the selected grade
            all_toillets.forEach(toillet_div => {
                if (toillet_div.dataset.note == selectedValue) {
                    toillet_div.style.display = "flex";
                } else {
                    toillet_div.style.display = "none";
                }
            });
        });
        // When a click is received on a radio button, 
        // don't send the event to the parent div that will clear buttons.
        button.addEventListener("click", function (event) {
            event.stopPropagation();
        });
    });


});

