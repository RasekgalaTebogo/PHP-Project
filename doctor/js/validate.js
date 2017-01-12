/*
*This function validate the admin search, block and delete form.
*It main purpose is to ensure doctor code is entered before submiting the form.
*/
function validateAdmin()
{
	//get the doctor_code from the page.
	var doctor_code = document.getElementById('id').value;
	var letters = /^[A-Za-z]+$/;//sort of expression that validate numbers.
	
	//test if its not null and its in the right format
	if((doctor_code == "") || (doctor_code.match(letters)) || doctor_code.length != 9)
    {
		alert("Enter valid doctor code..");
		return false;
    }
}

/*
*This function validate the login form.
*/
function validateLogin()
{ 
	//get username and password via IDs
    var password = document.getElementById('password').value;
	var username = document.getElementById('username').value;
	
	//test if they are not  null before submiting the form.
	if((password == ""))
    {
		alert("Enter a password to continue..");
		return false;
    }else if((username == ""))
	{
		alert("Enter a username to continue..");
		return false;
	}
}

/*
*This function validate the change password form form.
*/
function changePassword()
{ 
	//get username and password via IDs
    var password = document.getElementById('password').value;
	var newPassword = document.getElementById('newPassword').value;
	var rePassword = document.getElementById('reNewPass').value;
	
	//test if they are not  null before submiting the form.
	if((password == ""))
    {
		alert("Enter an old password to continue..");
		return false;
    }else if((rePassword == "")){
		
		alert("Re-Enter a new password again..");
		return false;
	}else if((newPassword == "") || (newPassword.length < 7))
	{
		alert("Enter a new password and please create a complex one with characters and numbers..");
		return false;
	}else if(!(newPassword == rePassword))
	{
		alert("Passwords do not match..");
		return false;
	}
}

/*
*This function validate the post news form.
*.
*/
function validatePost()
{
	//get the message from the page.
	var message = document.getElementById('message').value;
	var title = document.getElementById('title').value;
	var letters = /^[A-Za-z]+$/;//sort of expression that validate numbers.
	
	//test if message is not null and its in the right format
	if((message == "") || !(message.match(letters)))
    {
		alert("Enter message to send to patients..");
		return false;
    }else if((title == "") || !(title.match(letters)))
	{
		alert("Enter message title.");
		return false;
	}
}

/*
*This function validate the doctor chat form.
*.
*/
function validateUpdateDetails()
{
	//get the message from the page.
	var name = document.getElementById('docname').value;
	var surname = document.getElementById('docsurname').value;
	var cell = document.getElementById('docphone').value;
	var specialty = document.getElementById('docspecialty').value;
	var street = document.getElementById('docStreet').value;
	var city = document.getElementById('doccity').value;
	var code = document.getElementById('docPostalcode').value;
	
	var letters = /^[A-Za-z]+$/;//sort of expression that validate numbers.
	
	//test if message is not null and its in the right format
	if((name == "") || !(message.match(letters)))
    {
		alert("Enter new name to update");
		return false;
    }else if((code == "") || (code.match(letters)) || (code.length != 4))
	{
		alert("Enter new postal code to update");
		return false;
	}else if((surname == "") || !(surname.match(letters)))
	{
		alert("Enter new surname to update");
		return false;
	}else if((cell == "") || (cell.match(letters)) || (cell.length != 10))
	{
		alert("Enter new cell phone to update");
		return false;
	}else if((specialty == "") || !(specialty.match(letters)))
	{
		alert("Enter new specialization to update");
		return false;
	}else if((street == "") || !(street.match(letters)))
	{
		alert("Enter new street name to update");
		return false;
	}else if((city == "") || !(city.match(letters)))
	{
		alert("Enter new city to update");
		return false;
	}
}


/*
*This function validate the doctor chat form.
*.
*/
function validateChat()
{
	//get the message from the page.
	var message = document.getElementById('message').value;
	var numbers = /^\d{10}$/;	//sort of expression that validate numbers.
	
	//test if message is not null and its in the right format
	if((message == "") || (message.match(numbers)))
    {
		alert("Enter message to send to patient..");
		return false;
    }
}

function deleteChat()
{
	var r = confirm("Are you sure to delete all message?\n(You can't undo this)");
	
	if(r == true)
	{
		return true;
	}else{
		return false;
	}
}

function deletePatient()
{
	var r = confirm("Are you sure to delete the patient?\n(You can't undo this)");
	
	if(r == true)
	{
		return true;
	}else{
		return false;
	}
}

function deleteDoctor()
{
	var r = confirm("Are you sure to delete the doctor?\n(You can't undo this)");
	
	if(r == true)
	{
		return true;
	}else{
		return false;
	}
}

function deletePatient()
{
	var result = confirm("Are you sure to delete a patient?\n(You can't undo this)");
	
	if(result == true)
	{
		return true;
	}else{
		return false;
	}
}

/*
*This function validate the doctor alternative chat with patient.
*.
*/
function validateAlternativeEmail()
{
	//get the message from the page.
	var message = document.getElementById('body').value;
	var letters = /^[A-Za-z]+$/;//sort of expression that validate numbers.
	
	//test if message is not null and its in the right format
	if((message == "") || !(message.match(letters)))
    {
		alert("Enter message to send to patient..");
		return false;
    }
}


/*
*This function validate the email form.
*.
*/
function validateContact()
{
	//get the elements(email-address, name, message) from the page.
	var message = document.getElementById('message').value;
	var name = document.getElementById('name').value;
	var email = document.getElementById('email').value;
	
	var letters = /^[A-Za-z]+$/;
	var numbers = /^\d{10}$/;	
	var emailFormat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;//sort of expression that validate email.
	
	//test if message is not null and its in the right format
	if((message == "") || (message.match(numbers)))
    {
		alert("Enter email body to send..");
		return false;
    }else if(name == "" || (name.match(numbers)))
	{
		alert("Enter your name..");
		return false;
	}else if(email == "" || (email.match(email)))
	{
		alert("Enter email address..");
		return false;
	}
}

/*
*This function validate the registration form.
*.
*/

function validateRegistration()
{
	//get all elements from the registration form
	
	var name = document.getElementById('txtFname').value;
	var city_ = document.getElementById('txtCity_').value;
	var surname = document.getElementById('txtSurname').value;
	var address_line1 = document.getElementById('txtAddress1').value;
	var idNumber = document.getElementById('txtPassport').value;
	var gender = document.getElementById('txtGender').value;
	var cell = document.getElementById('txtTel').value;
	var email = document.getElementById('txtEmail').value;
	var posta_code = document.getElementById('txtPostCode').value;
	var doctor_code = document.getElementById('txtDoctorCode').value;
	var password = document.getElementById('txtPassword').value;
	var special = document.getElementById('txtSpecial').value;
	var rePassword = document.getElementById('txtRePassword').value;
	
    var letters = /^[A-Za-z]+$/;
	var numbers = /^\d{10}$/;
	var emailFormat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
      
	if(!(name.match(letters)) || name == "")
    {
		alert("Enter a name..");
		return false;
    }else if(!(surname.match(letters)) || surname == "")
	{
		alert("Enter a surname");
		return false;
	}else if(address_line1 == "")
	{
		alert("Enter a address line 1(This is street name and house number)");
		return false;
	}else if((city_.match(numbers)) || city_ == "")
	{
		alert("Enter the city name");
		document.form1.txtCity.value = "";
		document.form1.txtCity.focus();
		return false;
		
	}else if((special.match(letters)) || special == "")
	{
		alert("Enter doctor specialization");
		return false;
	}else if(cell == "" || !(cell.match(numbers)) || cell.length != 10)
	{
		alert("Enter valid phone numbers");
		return false;
	}else if( email == "" || !(email.match(emailFormat)))
	{
		alert("Enter valid email");
		document.form1.txtEmail.value = "";
		document.form1.txtEmail.focus();
		return false;
	}else if(posta_code == "" || (posta_code.match(letters)) || posta_code.length != 4)
	{
		alert("Enter valid postal code");
		document.form1.txtPostCode.value = "";
		document.form1.txtPostCode.focus();
		return false;
	}else if(gender == "Unknown")
	{
		alert("Select doctor gender");
		return false;
		
	}else if(idNumber == "" || (idNumber.match(letters)) || idNumber.length != 13)
	{
		alert("Enter ID Number");
		return false;
		
	}else if(password == "" || password.length <= 7)
	{
		alert("Enter password longer than 7 characters.");
		return false;
	}else if(!(rePassword == password))
	{
		alert("Password and Re-Password doesnt match..");
		return false;
	}else if(doctor_code == "" || (doctor_code.match(letters)) || doctor_code.length != 9)
	{
		alert("Please enter valid doctor code.");
		return false;
	}
}

function onDelete(){
	confirm("Are you sure you want to delete the patient?");
	return false;
}