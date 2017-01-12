<?php
/*--------------------------------------------------------------------------------------------
|    @desc:        profile.php
|    @author:      Nicolas Rasekgala
|    @date:        12 November 2016
|    @email        Nicolasrasekgala@gmail.com 
|                  
---------------------------------------------------------------------------------------------*/
	//session_id(md5(uniqid()));
	session_start();//initialize a session_cache_expire
	
	//test if the user has loggedin
	
	if(!empty($_SESSION['logged']))
	{
		
			
		try{	
		
					//import all needed classes
				include_once 'inc/admin_functions.php';
				include_once 'class/Doctor.class.php';
				include_once 'class/Person.class.php';
				include_once 'class/Address.class.php';
				include_once ('inc/paginate.php'); //include of paginat page
				
				//instantiate admin object
				$admin = new Admin_Function();
			
				$_SESSION['admin'] = md5(uniqid());
		
				//declare variables to be used
				$name="";
				$surname ="";
				$idNumber ="";
				$code ="";
				$cell ="";
				$email ="";
				$gender ="";
				$specialization ="";
				$address ="";
				$result= "";
				$tableContent = "";
		
				
					// get all doctors
				include_once './inc/admin_functions.php';
				$admin = new Admin_Function();
				
				//for registration
				$registerStatus = $_SESSION['status'];
		
				//if delete is clicked
				if(isset($_POST['delete']))
				{
					
					if($_POST['id'] != "")
					{
						$result = $admin->deleteDoctor($_POST['id']);//call delete doctor function and pass doctor code
						
					}else{
						$result="Enter valid doctor code please";
					}
					
				}elseif(isset($_POST['search']))// if search
				{
					
					if($_POST['id'] != "")
					{
						//method search the doctor
						$query_result = $admin->searchDoctor($_POST['id']);
						if($rows = mysql_fetch_assoc($query_result))
						{
							//instantiate the Doctor object with values
							
							$doctor = new Doctor($rows['name'], $rows['surname'], $rows['email'], $rows['id_number'],
                      							$rows['phone'], $rows['gender'], $rows['doctor_code'],
                        							$rows['specialization'], $rows['person_id'], $rows['person_id']);
							
							//instantiate the Address object with values
							$addressObj = new Address($rows['address_id'], $rows['street_name'], $rows['city'],
							                 $rows['postal_code'], $rows['person_id']);
							
							//set values to the variables
							$name= $doctor->getName();
							$surname = $doctor->getSurname();
							$idNumber = $doctor->getIdNumber();
							$code = $doctor->getDoctor_code();
							$cell = $doctor->getPhone();
							$email = $doctor->getEmail();
							$gender = $doctor->getGender();
							$specialization = $doctor->getSpecialty();
							
							$address = $addressObj->getStreet_name(). ' '.$addressObj->getCity().' '.$addressObj->getPostal_code();
							$result= "";
					
						}else{
							$result="No results found for the doctor code";
					
						}
						
					}else{
						$result="Enter valid doctor code please";
					}
					
				}elseif(isset($_POST['block']))//block doctor
				{
					
					if($_POST['id'] != "")
					{
						$result = $admin->blockDoctor($_POST['id']);
						
					}else{
						$result="Enter valid doctor code please";
					}
					
				}elseif(isset($_POST['register']))//register a doctor
				{
					header("location:../registration.php");	
				}
				
				
				$per_page = 5;         // number of results to show per page
				$results1 = mysql_query("select * FROM tblPerson, tblDoctor where tblDoctor.person_id  = tblPerson.person_id");
			
				$total_results = mysql_num_rows($results1);
				$total_pages = ceil($total_results / $per_page);//total pages we going to have

				//-------------if page is setcheck------------------//
				if (isset($_GET['page'])) {
					$show_page = $_GET['page'];             //it will telles the current page
					if ($show_page > 0 && $show_page <= $total_pages) {
						$start = ($show_page - 1) * $per_page;
						$end = $start + $per_page;
					} else {
						// error - show first set of results
						$start = 0;              
						$end = $per_page;
					}
				} else {
					// if page isn't set, show first set of results
					$start = 0;
					$end = $per_page;
				}
				// display pagination
				$page = intval($_GET['page']);

				$tpages=$total_pages;
				if ($page <= 0)
					$page = 1;


			
			
				
					
			} catch(Exception $e){
				/* If something goes wrong we catch the exception thrown by the object, print the message, and stop the execution of script */
				print 'Error! <br />' . $e->getMessage() . '<br />';
				exit;
			}
			
?>
<!DOCTYPE html>
<html ng-app="myApp">
	<head>
		
		<script src="js/angular.js"></script>
	
		<script src="js/angular-route.js"></script>
			<script src="js/validate.js"></script>
		<script src="js/adminApp.js"></script>
	
		
		<link href="css/doc_style/bootstrap.css" rel="stylesheet">
		<link href="" rel="shortcut icon">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Profile</title>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="css/profile.css" />
		<meta name="viewport" content="width, initial-scale=1.0"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<link rel="stylesheet" type="text/css" href="css/doc_style/style.css" />
		

		
	</head>
	
	<body>
		
		<div class="container">
		  <div>	
			<header>
				<img  style="height:69px; width:100px"src="image/logo.jpg"/>
				
			</header>
					
			 <div id="navmenu">
					<p id="bar">
								   
						<ul class="nav">
							<li><a href="logout.php">Logout</a></li>
						</ul>
					</p>
								
			</div>
			 <marquee loop="-1" color="A8CD1B" scrollamount="5" loop="-1" > <h1 id="alignment1"  > WELCOME TO HIBRO TECHNOLOGY</h1> </marquee>
		<div class="search">	 
		<div id="container" >
			<p style="color:red;"><?php echo $result; ?></p>
			<p style="color:red;"><?php echo $registerStatus; ?></p>
			
			<form action="profile.php" method="post" onsubmit="return validateAdmin()">
			
				<fieldset>
					<legend><h3>Doctor Management</h3></legend>
					
					<p class="buttons"><label style="color:#ffffff; margin-left:5px;" for="id">Doctor Code:</label>
						<input type="text" name="id" id="input" placeholder="Enter doctor code here" maxlength="10"/>
					
						<input type="submit" value="Search" name="search" />
						<input type="submit" value="Block" name="block" />
						<input type="submit" value="Delete" name="delete" onsubmit="return deleteDoctor()"/>
						<a href="registration.php" name="register">Register</a>
					</p>


				
					<hr style="border: 1px solid #c7d0d2;"/>
			
				<div id="div1">
					<p class="title">Name:</p>
					<p class="detail"><?php echo $name; ?> </p>
				
					<p class="title">Surname: </p>
					<p class="detail"><?php echo $surname; ?></p>

					<p class="title">ID Number: </p>
					<p class="detail"><?php echo $idNumber; ?></p>

					<p class="title">Email: </p>
					<p class="detail"><?php echo $email; ?></p>
				
					<p class="title">Cell Number: </p>
					<p class="detail"><?php echo $cell; ?></p>
				
					<p class="title">Gender: </p>
					<p class="detail"><?php echo $gender; ?></p>
	
					<p class="title">Doctor Code: </p>
					<p class="detail"><?php echo $code; ?></p>
			
					<p class="title">Doctor Specialization: </p>
					<p class="detail"><?php echo $specialization; ?></p>
				
					<p class="title">Address: </p>
					<p class="detail"><?php echo $address; ?></p>
						
				</div>
				<hr style="border: 1px dotted #c7d0d2;"/>

				</fieldset>
			
			</form>
			
		</div>
		</div>
		
		<p>
		    <h2 style="text-align:center; margin:30px auto 0px 0px;; top:20%;">All Registered Doctors</h2>
		</p>
		
		<div class="all">
				<section id="doctors"> 
			 <hr/>
							
			<div class="row">
			 
				<form action="profile.php" method="POST">
               
                 <?php
				 
                    $reload = $_SERVER['PHP_SELF'] . "?tpages=" . $tpages;
                    echo '<div class="pagination"><ul>';
                    if ($total_pages > 1) {
                        echo paginate($reload, $show_page, $total_pages);
                    }
                    echo "</ul></div>";
                    // display data in table
                    echo "<table class='table table-bordered'>";
					
                    echo "<thead><tr>";
					
					echo "<th class= 'heading'>Code</th>";
					echo "<th class= 'heading'>Name</th>";
					echo "<th class= 'heading'>Surname</th>";
					echo "<th class= 'heading'>Cell Number</th>";
					echo "<th class= 'heading'>Email</th>";
					echo "<th class= 'heading'>Gender</th>";
					echo "<th class= 'heading'>ID Number</th>";
					echo "<th class= 'heading'>Speciality</th>";
					
					echo "</tr></thead>";
					echo "<tbody>";
                    // loop through results of database query, displaying them in the table 
                    for ($i = $start; $i < $end; $i++) {
                        // make sure that PHP doesn't try to show results that don't exist
                        if ($i == $total_results) {
                            break;
                        }
                      
                        // echo out the contents of each row into a table
                        echo "<tr " . $cls . ">";
                        echo '<td>' . mysql_result($results1, $i, 'doctor_code') . '</td>';
						echo '<td>' . mysql_result($results1, $i, 'name') . '</td>';
						echo '<td>' . mysql_result($results1, $i, 'surname') . '</td>';
						echo '<td>' . mysql_result($results1, $i, 'phone') . '</td>';
						echo '<td>' . mysql_result($results1, $i, 'email') . '</td>';
						echo '<td>' . mysql_result($results1, $i, 'gender') . '</td>';
						echo '<td>' . mysql_result($results1, $i, 'id_number') . '</td>';
						echo '<td>' . mysql_result($results1, $i, 'specialization') . '</td>';
						
                        echo "</tr>";
                    }       
					?>
						<tr><?php //echo $tableContent;?></tr>
					</tbody>
                </table>
				</form>
			</section>
		</div>	
	
	
	   </div>
	  </div>	
	  </div>
	</body>
</html>
<?php
	}else
	{
		//if you try to get in here without permission
		header("location: index.php");
	}

?>