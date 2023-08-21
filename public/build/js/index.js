function openSidebar() {
    document.getElementById("sidebar").style.display = "block";
    }
function closeSidebar() {
    document.getElementById("sidebar").style.display = "none";
    }
 
function showPasseword(){    
     var inputPassword = document.getElementById("#inputPassword1");
     var eye1 = document.getElementById("#eye1")
     if(inputPassword.type === "password"){
        inputPassword.type = "text";
        eye1.icon = "mdi:eye-off"
    } else {
        inputPassword.type="password";
        eye1.icon = "mdi:eye"
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

      const radioButtons = document.getElementsByName('review');

radioButtons.forEach(radioButton => {
    radioButton.addEventListener('change', () => {
        const selectedOption = document.querySelector('input[name="review"]:checked').value;
        sendDataToBackend(selectedOption);
    });
});

function sendDataToBackend(option) {
  const xhr = new XMLHttpRequest();
  xhr.open('POST', '/process-radio', true); // バックエンドのエンドポイントを指定
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
              console.log('Data sent successfully');
          } else {
              console.error('Failed to send data');
          }
      }
  };

  const data = 'selectedOption=' + encodeURIComponent(option);
  xhr.send(data);}