function toggleSignup () {
  document.getElementById('login-toggle').style.backgroundColor = '#fff'
  document.getElementById('login-toggle').style.color = '#222'
  document.getElementById('signup-toggle').style.backgroundColor = '#4883FF'
  document.getElementById('signup-toggle').style.color = '#fff'
  document.getElementById('login-form').style.display = 'none'
  document.getElementById('signup-form').style.display = 'block'
}

function toggleLogin () {
  document.getElementById('login-toggle').style.backgroundColor = '#4883FF'
  document.getElementById('login-toggle').style.color = '#fff'
  document.getElementById('signup-toggle').style.backgroundColor = '#fff'
  document.getElementById('signup-toggle').style.color = '#222'
  document.getElementById('signup-form').style.display = 'none'
  document.getElementById('login-form').style.display = 'block'
}

async function login () {
  let email = document.getElementById('lgnEmail').value
  let password = document.getElementById('lgnPass').value

  let data = {
    email: email,
    password: password,
    action: 'login'
  }

  $.ajax({
    type: 'POST',
    url: 'LoginAndSingup.php',
    data: data,
    success: function (response) {
      alert(response)
    }
  })
}

async function signup () {
  let email = document.getElementById('signEmail').value
  let username = document.getElementById('signUsername').value
  let password = document.getElementById('signPass').value
  //get image

  var files = $('#signProfilePicture')[0].files

  //use form data
  let formData = new FormData()
  formData.append('email', email)
  formData.append('username', username)
  formData.append('password', password)
  formData.append('action', 'signup')

  formData.append('image', files[0])

  $.ajax({
    type: 'POST',
    url: 'LoginAndSingup.php',
    data: formData,
    contentType: false,
    processData: false,
    success: function (response) {
      alert(response)
    }
  })
  //ajax with jquery
}
