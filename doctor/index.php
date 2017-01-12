<?php

/*--------------------------------------------------------------------------------------------
|    @desc:        index.php
|    @author:      Nicolas Rasekgala
|    @date:        12 November 2016
|    @email        Nicolasrasekgala@gmail.com 
|                  
---------------------------------------------------------------------------------------------*/
	//initialize a session
	session_id(md5(uniqid()));
	session_start();
	
	error_reporting();
	
	// import all the classes
	include_once 'inc/logon.php';
    include_once 'class/Doctor.class.php';
    include_once 'class/Person.class.php';
    include_once 'class/Login.class.php';
	$error = "";
	

	
	
	if(isset($_POST['Login']))
	{
		//get values from the form
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		//prevent mysql injection
		$username = stripcslashes($username);
		$password = stripcslashes($password);

		
		//instantiate process login object
		$logon = new Process_Login();
		
		try{
				
			$pass = md5($password);	
			//login using a method from logon object
		   $login = $logon->login($username, $pass);
		
			if($user = $login)
			{
				//if passed get the user details
				$row = mysql_fetch_assoc($user);
				
				//instantiate login object
				$loginObj = new Login($row['login_id'], $row['password'], $row['username'],
     				$row['role'], $row['person_id'], $row['status']);
				//test if user exists
				if($loginObj->getUsername() == $username && $loginObj->getPassword() == $pass)
				{
					//login sucssess now test the role
					$_SESSION['password'] = $loginObj->getPassword();
					
					if(strcasecmp($loginObj->getRole(),'doctor')==0)
					{
						//check if doctor is not blocked
						if(strcasecmp($loginObj->getStatus(),'Active')==0)
						{

							//query the database to get the doctor code.
							$id = $loginObj->getPerson_id();
							$doctor  = $logon->getLoggedDoctor($id);
							
							//initia doctor object and store it into a session serialized
							$doc_results = mysql_fetch_assoc($doctor);
							
							$doctor = new Doctor($doc_results['name'], $doc_results['surname'],
							$doc_results['email'], $doc_results['id_number'], $doc_results['phone'],
							$doc_results['gender'], $doc_results['doctor_code'], $doc_results['specialization'],
							$doc_results['person_id'], $doc_results['person_id']);
							
							$_SESSION['doctor_code'] = $doctor->getDoctor_code();
							$_SESSION['doctor']= serialize($doctor);//store doctor object into session
							$_SESSION['logged_doctor'] = md5(uniqid());//generate a uniqid encrypted  for the user session
							header("location: viewall.php");// send user to view patient page.
						}else{
							//blocked doctor are denied access
							$error = "You are blocked from using the system, please contact HIBRO TECH...";
						}
						
					}else{
						
						//This is an admin
						//uniqid encrypted ID is generated as well for them
						$_SESSION['logged'] = md5(uniqid());
						header("location: profile.php");// send user to management page.
					}
						
				}else{
						//login unsuccessful.
						$error = "Incorrect password or username...";		
				}
						
				}else{
					
					$error = "Failed to connect to Server...";
				}
				
			} catch(Exception $e){
				/* If something goes wrong we catch the exception thrown by the object,
     				print the message, and stop the execution of script */
				print 'Error! <br />' . $e->getMessage() . '<br />';
				exit;
			}
	
	}


?>

<!doctype html>
<html ng-app="myApplication">

<head>
        <title>Welcome to Hibro Tech</title>
        <meta name="keywords" content="" />
		<meta name="description" content="" />
		
			<!-- Mobile Specifics -->
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<meta name="HandheldFriendly" content="true"/>
			<meta name="MobileOptimized" content="320"/> 
		    <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--<link rel="shortcut icon" href="PUT YOUR FAVICON HERE">-->
        
        <!-- Google Web Font Embed -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
        <!-- Google Font -->
		<link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,200,200italic,300,300italic,400italic,600,600italic,700,700italic,900' rel='stylesheet' type='text/css'>

		<!-- Google Font -->
		 <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,200,200italic,300,300italic,400italic,600,600italic,700,700italic,900' rel='stylesheet' type='text/css'>

		 <!-- Font Icons -->
		<link href="css/fonts.css" rel="stylesheet">
		
		<script src="js/angular.js"></script>
		<script src="js/app.js"></script>
		<script src="js/validate.js"></script>
		<script src="js/angular-route.js"></script>
	 
        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.css" rel='stylesheet' type='text/css'>
		<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css'>
       
     
        <link href="css/templatemo_style.css"  rel='stylesheet' type='text/css'>

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
		



</head>

<body>
		
		<div class="page-top-bar" id="div-top">
            <div class="container">
                <div class="subheader">
                    <div id="phone" class="pull-left">
                            <img src="image/phone.png" alt="phone"/>
                            076-372-0007
                    </div>
                    <div id="email" class="pull-right">
                            <img src="image/email.png" alt="email"/>
                            Marketingatwork00gmail.com
                    </div>
                </div>
            </div>
        </div>
		
	 <div class="div-top-menu">
            <div class="container">
                <!-- Static navbar -->
                <div class="navbar navbar-default" role="navigation">
                    <div class="container">
                        <div class="navbar-header">
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                </button>
                        <a href="#" class="navbar-brand"><img style=" height:65px;" class="img-responsive" src="image/logo.jpg" alt="HIBRO TECH" title="HIBRO TECH" /></a>
                        </div>
                        <div class="navbar-collapse collapse" id="main-nav-bar">
                            <ul class="nav navbar-nav navbar-right" style="margin-top: 40px;">
                                <li class="active"><a href="#div-top">HOME</a></li>
                                <li><a href="#container">LOGIN</a></li>
                                <li><a href="#about">ABOUT US</a></li>
                                <li><a href="#cont">CONTACT US</a></li>
                            </ul>
                        </div><!--/.nav-collapse -->
                    </div><!--/.container-fluid -->
                </div><!--/.navbar -->
            </div> <!-- /container -->
        </div>

   <div>
            <!-- Main view -->
            <div id="main-carousel" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#main-carousel" data-slide-to="0" class="active"></li>
                    <li data-target="#main-carousel" data-slide-to="1"></li>
                    <li data-target="#main-carousel" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="item active">
                        <div class="container">
                            <div class="carousel-caption">
                                <h1>WELCOME TO HIBRO TECH</h1>
                                <p style="font-size:12px;">Innovation Through Technology</p>
                                <p>Let's work together and change the Health Sector of South Africa.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="item">
                        <div class="container">
                                <div class="carousel-caption">
                                    <div class="col-sm-6 col-md-6">
                                    	<h1>FIRST AID APP</h1>
                                        <p>Any doctor who will like to use First First Aid mobile application, please feel free to contact us. Let's improve our health.</p>
										   
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                    	<h1>FOLLOW US</h1>
                                        <p>Feel free to follow us on <a style="text-decoration:none;" href="https://web.facebook.com/nicolas.rasekgala1/">Facebook</a> & <a style="text-decoration:none;" href="https://twitter.com/Tebogo_nicolas">twitter</a>. Give us query regarding anything we do and we will communicate.</p>
											
                                    </div>
                                </div>
                        </div>
                    </div>
                        <div class="item">
                            <div class="container">
                                <div class="carousel-caption">
									<p></p><br>
                                	<h1>OUR SERVICES</h1>
                                    <p id="ourservice">
										<strong><u>Mobile Application</u></strong><br>We develop mobile application for both enterprise functions and any apps for fun.<br>
										<strong><u>Business Website</u></strong><br>Best website at an affordable amount for both small businesses and big businesses.<br>
										& <br>
										You can also get any of IT services you want.
									</p>
                                   
                                </div>
                            </div>
                        </div>
                </div>
                <a class="left carousel-control" href="#main-carousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
                <a class="right carousel-control" href="#main-carousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
            </div><!-- /# end of main div -->
        </div>
		
		<!-- Login div -->
		
		   <div class="templatemo-welcome" id="templatemo-welcome">
            <div class="container" >
                <div class="templatemo-slogan text-center" id="container">
                    <span class="txt_darkgrey">Welcome to </span><span class="txt_orange">HIBRO TECHNOLOGY</span>
                    <div id="login">
						<div id="container" ng-controller="loginController">
						
						<form action="index.php" name="login" method="POST" onsubmit="return validateLogin()">
						<h1>Login</h1>
						<hr id="line"></hr>
						
						<p>
							<label class="Lform" for="name">Username:</label>
							
							<input type="text" id="username" ng-model="userName" name="username" placeholder="Enter username here" />
						</p>
						<p>
							<label class="Lform" for="password">Password:</label>

							<input type="password" ng-model="passWord"  id="password" name="password" placeholder="Enter password here" />
						</p>
						
						<p  id="error"> <?php echo $error; ?></p>
						
						<div id="lower">

						<input type="submit" value="Login" name="Login" ng-disabled="login.username.$invalid || login.password.$invalid"/> 
						
						</div>
						
						</form>
					</div>
					</div>
                </div>	
            </div>
        </div><!-- End of login -->
		
		<!--  The About Us div -->
			<div id="about" class="page-alternate">
			<div class="container">
				<!-- Title Page -->
				<div class="row">
					<div class="span12">
						<div class="title-page">
							<h2 class="title">About Us</h2>
							
						</div>
					</div>
				</div>
				
				<!-- End Title Page -->
				
				<div style="margin:auto;">
					
					<h3 style="text-align:center;">Our Mission</h3>
					<p style="text-align:center; width:60%; margin:auto;">Our mission is simply to ensure that technology reach everyone, reliably and at anytime. To also improve technology side of our local business and
					 communities in general.</p>
					 <p style="margin:auto; left:40px;">
					 
						<ul style="margin:auto; left:40px; padding-left:20%;">
							<li>To allow technology to change the world.</li>
							<li>To make a difference both in business and technology world.</li>
							<li>To connect the world</li>
						</ul>
					 </p>
				
				</div>
				
				<div style="margin:auto;">
				
					<h3 style="text-align:center;">Our Vision</h3>
					<p style="text-align:center;  width:60%; margin:auto;">Be the world's technology leader in the eyes of our customers, communities and people. To be a team that clearly understand
					 and love to change the world and ensure technology is accessable to everyone of any social status.</p>
				
				</div>

	<section style="margin-top:50px;" id="contact">
    
    <div id="contact-us" class="parallax">
      <div class="container">
        <div class="row">
          <div class="heading text-center col-sm-8 col-sm-offset-2 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
            <h2>Contact Us</h2>
			<br/>
			</div>
		  <br/>
        </div>
		 <br/>
        <div class="contact-form wow fadeIn" id="cont" data-wow-duration="1000ms" data-wow-delay="600ms">
          <div class="row">
            <div class="col-sm-6">
				 <form class="form-horizontal" action="sendemail.php" onsubmit="return validateContact()">
                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Your Name..." maxlength="40" />
                        </div>
                        <div class="form-group">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Your Email..." maxlength="40" />
                        </div>
                        <div class="form-group">
                        <textarea  class="form-control" id="message" name="message" style="height: 130px;" placeholder="Write down your message..."></textarea>
                     </div>
                    <p><input type="submit" class="btn btn-orange pull-right" value="SEND"></p>
                </form>
            </div>
			<br>
            <div class="col-sm-6">
              <div class="contact-info wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
                <p>The following are ways which you can reach us. its clearly up to you which one you use but we assure you that all of them are up and running. We are looking forward to hear from you. Enjoy.</p>
                <ul class="address">
                  <li><i class="fa fa-map-marker"></i> <span> Address:</span> 306 Joe Modise Str </li>
                  <li><i class="fa fa-phone"></i> <span> Phone:</span> +27 79 834 4109  </li>
                  <li><i class="fa fa-envelope"></i> <span> Email:</span><a href="mailto:Marketingatwork00gmail.com"> Marketingatwork00gmail.com</a></li>
                  <li><i class="fa fa-globe"></i> <span> Website:</span> <a href="www.doctorsatwork.co.za">www.doctorsatwork.co.za</a></li>
                </ul>
				
				
					<div class="team-member wow flipInY" data-wow-duration="1000ms" data-wow-delay="1100ms">
					 
					  <div class="social-icons">
						<ul>
						  <li><a class="facebook" href="#"><i class="fa fa-facebook"></i></a></li>
						  <li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a></li>
						  <li><a class="linkedin" href="#"><i class="fa fa-linkedin"></i></a></li>
						  <li><a class="dribbble" href="#"><i class="fa fa-dribbble"></i></a></li>
						  <li><a class="rss" href="#"><i class="fa fa-rss"></i></a></li>
						</ul>
					  </div>
					</div>
              </div>                            
            </div>
          </div>
        </div>
      </div>
    </div>        
  </section><!--/#contact-->
		
		<div class="footer_bottom_content">
            <span id="footer-line">Copyright © 2017 <a href="#">HIBRO TECH</a></span>
         </div>
		<script src="js/jquery.min.js" type="text/javascript"></script>
        <script src="js/bootstrap.min.js"  type="text/javascript"></script>
		<script src="js/stickUp.min.js"  type="text/javascript"></script>
        <script src="js/colorbox/jquery.colorbox-min.js"  type="text/javascript"></script>
        <script src="js/templatemo_script.js"  type="text/javascript"></script>


</body>

</html>