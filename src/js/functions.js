// function loadDoc(url, el, confirmMsg) {
//   // load url into DOM element, ask for confirmation if confirmMsg
//   // el is div name without #
//   if (!confirmMsg || confirm(confirmMsg)) {
//     var xhttp = new XMLHttpRequest()
//     xhttp.onreadystatechange = function() {
//       if (this.readyState == 4 && this.status == 200) {
//         document.getElementById(el).innerHTML = this.responseText
//       }
//     }
//     xhttp.open('GET', url, true)
//     xhttp.send()
//   }
// }


// load url into DOM element
function loadDoc(url, div) {
  var xhr = new XMLHttpRequest()
  xhr.open('GET', url, true)
  xhr.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById(div).innerHTML = this.responseText
    }
  }
  xhr.send(null)

  // fetch(url)
  // .then((res) => {
  // alert(res)
  // res.text()
  // })
  // .then((data) => {console.log(data)})
}


function showMessage(msg) {
  var msgDiv = document.getElementById('messages')
  msgDiv.innerHTML += msg
  msgDiv.scrollTop = msgDiv.scrollHeight
}


function bling() {
  // this gives us some jquery $ selector functionality
  // thanks bling.js
  window.$ = document.querySelectorAll.bind(document)

  Node.prototype.on = window.on = function (name, fn)
    {this.addEventListener(name, fn)}

  NodeList.prototype.__proto__ = Array.prototype

  NodeList.prototype.on = NodeList.prototype.addEventListener = function (name, fn)
    {this.forEach(function (elem, i) {elem.on(name, fn)})}
}


function aqax(url, paramString) {
  var xhr = new XMLHttpRequest()
  xhr.open("POST", url, true)
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onreadystatechange = function() {
    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
        // Request finished. Do processing here.
    }
  }
  xhr.send(paramString);
}
