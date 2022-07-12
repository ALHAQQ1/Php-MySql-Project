var modal = document.getElementById('modalBox')
var btn = document.getElementById('myBtn')
var modalChild = document.getElementById('modal')

async function ShowModal (content,CarId) {
  $('#primary-nav-button').click()

  modal.setAttribute('class', 'modalMainBox')
  modalChild.setAttribute('class', 'showModaal')

  let c = await fetch(content + '.php')
  modalChild.innerHTML = await c.text()
}
modal.onclick = function (event) {
  if (event.target == modal) {
    modalChild.setAttribute('class', 'hideModal')
    setTimeout(() => {
      modal.setAttribute('class', 'disp-none')
    }, 500)
  }
}
