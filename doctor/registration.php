<?php
   //check if the admin has logged in
	session_start();
	if(!empty($_SESSION['logged']))
	{

?>

<!doctype html>
<html>
	
	<head>
		<title>Register a doctor</title>
		<meta charset="utf-8">
		<script src="js/validate.js"></script>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width, initial-scale=1.0"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<script src="js/adminApp.js"></script>
		
		 <link rel="stylesheet" type="text/css" href="css/registerStyle.css" />
	</head>
	
	<body>
	
		<h1><strong>Registration Form For Doctors</strong></h1>
			<p  id="error"><?php echo $_SESSION['status']; ?></p>
			<div id="wrapper">
				<form  action="inc/register.php" name="form1"  method="post" onsubmit="return validateRegistration()">
					<fieldset>
						<legend class="title"><strong>Doctor Personal Info</strong></legend>
						
						
					<div id="labeling" class="fields">
						
					<div class="fields" id="field">
					
						<p class="align">							
							<label for="txtFname"><strong class="mark">*</strong>First Name:</label>
						</p>
						<p class="align">
							<input class="align" type="text" name="txtFname" id="txtFname" style="height: 20px" size="30" maxlength="35" />
						</p>
						
						<p class="align">	
							<label for="txtSurname"><strong class="mark">*</strong>Surname:</label>
						</p>
						<p class="align">
							
					
							<input class="align" type="text" id="txtSurname" name="txtSurname" style="height: 20px" size="30" maxlength="35" />
						</p>
						
						<p class="align">
							
							<label for="txtPassport"><strong class="mark">*</strong>ID Number/Passport:</label>
					
						</p>
						<p class="align">
							
							
							<input class="align" type="number" id="txtPassport" name="txtPassport" style="height: 20px" size="20" maxlength="20" />
						</p>
						
						<p class="align">
							
							<label for="txtEmail"><strong class="mark">*</strong>Email:</label>
						</p>
						
						<p class="align">
							
						
							<input class="align" type="email" id="txtEmail" name="txtEmail" style="height: 20px" size="30" maxlength="35" />
							
						</p>
						
						<p class="align">
							
							<label for="txtTel"><strong class="mark">*</strong>Cell Number:</label>
					
						</p>
						
						<p class="align">
							
						
							<input class="align" type="tel" id="txtTel" name="txtTel" style="height: 20px" size="30" maxlength="35" />
						</p>
						
						
						<p class="align">
							
							<label for="txtAddress1"><strong class="mark">*</strong>Address Line 1:</label>
							
						</p>
						<p class="align">
							
							
							<input class="align" type="text" id="txtAddress1" name="txtAddress1" style="height: 20px" size="50" maxlength="35" />
						</p>
						
						<p class="align">
							
							<label for="txtCity"><strong class="mark">*</strong>Town/City:</label>
							
						</p>
						<p class="align">

							<input class="align" type="text" id="txtCity_" name="txtCity" style="height: 20px" size="50" maxlength="35" />
						</p>
						
						<p class="align">
							
							<label for="txtPostCode"><strong class="mark">*</strong>Post Code:</label>
					
						</p>
						<p class="align">
							
							
							<input class="align" type="number" id="txtPostCode" name="txtPostCode" style="height: 20px" size="30" maxlength="35" />
						</p>
						
						<p class="align">
							
							<label for="txtGender"><strong class="mark">*</strong>Gender:</label>
						</p>
						
						<p class="align">
							
						
							<select class="align" id="txtGender" name="txtGender">
								<option value ="Unknown">--Select Gender--</option>
								<option value ="Male">Male</option>
								<option value ="Female">Female</option>
							</select>
							
						</p>
						
						<p class="align">
							<label for="txtSpecial"><strong class="mark">*</strong>Doctor Specialization:</label>
						</p>
						<p class="align">

							<input class="align" type="text" id="txtSpecial" name="txtSpecial" style="height: 20px" size="20" maxlength="20" />
						</p>
					  
						<p class="align">
							
							<label for="txtPassword"><strong class="mark">*</strong>Password:</label>
						</p>
						 <p class="align">

							<input class="align" type="password" id="txtPassword" name="txtPassword" style="height: 20px" size="20" maxlength="20" />
						</p>
						
						 <p class="align">
							
							<label for="txtRePassword"><strong class="mark">*</strong>Re-enter Password:</label>
			
						</p>
						 <p class="align">
							<input class="align" type="password" id="txtRePassword" name="txtRePassword" style="height: 20px" size="20" maxlength="20" />
						</p>
					
					</div>	
					
					<div id="submits">
				
					<p>
				
						<input type="submit" style="width: 200px" name="decision" style="height: 35px" value="Register" />
				
						
					</p><br>
				  </div>
				</fieldset>
				</form>
			</div>	
	</body>

</html>
<?php
	}else
	{
		//if not logged in
		header("location: index.php");
	}
?>