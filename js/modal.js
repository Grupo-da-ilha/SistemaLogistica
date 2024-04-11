const button = document.getElementById("vermais")
const modal = document.getElementById("dialog")
const buttonClose = document.querySelector("dialog button")

button.onclick = function () {
  modal.showModal()
}

buttonClose.onclick = function () {
  modal.close()
}
