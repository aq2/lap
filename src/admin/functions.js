// load url into DOM element, ask for confirmation if confirmMsg
function loadDoc(url, el, confirmMsg) {
  if (!confirmMsg || confirm(confirmMsg)) {
    var xhttp = new XMLHttpRequest()
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById(el).innerHTML = this.responseText
      }
    }
    xhttp.open('GET', url, true)
    xhttp.send()
  }
}

function showMessage(msg) {
  var msgDiv = document.getElementById('messages')
  msgDiv.innerHTML += msg
  msgDiv.scrollTop = msgDiv.scrollHeight
}

