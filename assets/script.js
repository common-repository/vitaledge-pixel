function success() {
    if (document.getElementById("ve-pixelid").value === "") {
        document.getElementById('submit-btn').disabled = true;
    } else {
        document.getElementById('submit-btn').disabled = false;
    }
}

var modal = document.getElementById('warning-modal');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

function closeModal(){
    document.getElementById('warning-modal').style.display='none';
}

function openModal(){
    document.getElementById('warning-modal').style.display='block';
}