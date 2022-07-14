function Edit () {
  const carMake = document.querySelector('select[name="CarMake"]')
  const carModel = document.querySelector('input[name="CarModel"]')
  const carYear = document.querySelector('select[name="CarYear"]')
  const carColor = document.querySelector('select[name="CarColor"]')
  const carPrice = document.querySelector('input[name="CarPrice"]')
  const elanid = document.querySelector('input[name="elanid"]')
  const IsSalon = document.querySelector('input[name="IsSalon"]')
  const UserId = document.querySelector('input[name="UserId"]')
  const CarId = document.querySelector('input[name="CarId"]')
  const carMillage = document.querySelector('input[name="carMillage"]')
  const carType = document.querySelector('select[name="CarType"]')
  const gearbox = document.querySelector('select[name="GearBox"]')
  const CarCity = document.querySelector('select[name="CarCity"]')
  const carEngineSize = document.querySelector('select[name="carEngineSize"]')
  const fuel = document.querySelector('select[name="Fuel"]')
  const carEnginePower = document.querySelector('input[name="carEnginePower"]')
  const CarPriceType = document.querySelector('select[name="CarPriceType"]')
  const car_description = document.querySelector(
    'textarea[name="car_description"]'
  )
  const car_image = document.querySelector('input[name="Img"]')
  const car_seller_name = document.querySelector('input[name="SellerName"]')
  const car_seller_phone = document.querySelector('input[name="PhoneNumber"]')
  const status = document.getElementById('status')
  let extras = document.getElementById('extras')

  var ExtraSelected = []
  for (var option of extras.options)
    if (option.selected) ExtraSelected.push(option.value)

  if (carMake.value == 'All') {
    carMake.focus()
    alert('Please Select Car Make')
    return
  }
  if (carModel.value == '') {
    carModel.focus()
    alert('Please Select Car Model')
    return
  }
  if (carYear.value == 'All') {
    carYear.focus()
    alert('Please Select Car Year')
    return
  }
  if (carPrice.value == '') {
    carPrice.focus()
    alert('Please Enter Car Price')
    return
  }
  if (carEngineSize.value == 'All') {
    carEnginePower.focus()
    alert('Please Enter Car EngineSize')
    return
  }
  if (carEnginePower.value.length == 0) {
    carEnginePower.focus()
    alert('Please Enter Car EnginePower')
    return
  }
  if (carMillage.value.length == 0) {
    carMillage.focus()
    alert('Please Select Car Millage')
    return
  }
  if (carColor.value == 'All') {
    carColor.focus()
    alert('Please Select Car Color')
    return
  }

  if (gearbox.value == 'All') {
    gearbox.focus()
    alert('Please Select Gear Box')
    return
  }
  if (fuel.value == 'All') {
    fuel.focus()
    alert('Please Select Fuel Type')
    return
  }
  if (carType.value == 'All') {
    carType.focus()
    alert('Please Select Car Type')
    return
  }
  if (CarCity.value == 'All') {
    CarCity.focus()
    alert('Please Select City')
    return
  }
  if (car_seller_name.value.length < 3) {
    car_seller_name.focus()
    alert('Please Enter Car Seller Name')
    return
  }
  console.log(car_seller_phone.value.length)
  let reg = /^([0-9]{3}-)[0-9]{3}-[0-9]{2}-[0-9]{2}/
  if (!reg.test(car_seller_phone.value)) {
    car_seller_phone.focus()
    alert('Please Enter Valid Phone Number')
    return
  }
  if (car_description.value == '') {
    car_description.focus()
    alert('Please Enter Car Description')
    return
  }

  let SendStatus = 0
  console.log(status.checked)
  if (status.checked == true) SendStatus = 1

  console.log(SendStatus)

  let formData = new FormData()
  formData.append('CarId', CarId.value)
  formData.append('IsSalon', IsSalon.value)
  formData.append('UserId', UserId.value)
  formData.append('elanid', elanid.value)
  formData.append('CarMake', carMake.value)
  formData.append('CarModel', carModel.value)
  formData.append('CarYear', carYear.value)
  formData.append('CarColor', carColor.value)
  formData.append('CarPrice', carPrice.value)
  formData.append('CarPriceType', CarPriceType.value)
  formData.append('CarMillage', carMillage.value)
  formData.append('CarType', carType.value)
  formData.append('GearBox', gearbox.value)
  formData.append('Status', SendStatus)
  formData.append('CarCity', CarCity.value)
  formData.append('carEngineSize', carEngineSize.value)
  formData.append('Fuel', fuel.value)
  formData.append('carEnginePower', carEnginePower.value)
  formData.append('car_description', car_description.value)
  formData.append('car_seller_name', car_seller_name.value)
  formData.append('car_seller_phone', car_seller_phone.value)
  formData.append('ExtraSelected', ExtraSelected)

  $.ajax({
    type: 'POST',
    url: 'EditCar.php',
    data: formData,
    contentType: false,
    processData: false,
    success: function (response) {
      if (response == 'Success') {
        window.location.reload()
      } else alert(response)
    }
  })
}
