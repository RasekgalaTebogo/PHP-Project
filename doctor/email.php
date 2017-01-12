<?php


    $msg = 'Name: nicolas'."\n"
	       .'Email: nicolas@gmail.com'."\n"
		   .'Comment: Hello Tebogo'."\n";
   $status =  mail('Nicolasrasekgala@gmail.com','Contact Us',$msg);
	
	if($status)
	{
		print("Your Email has been sent successfully");
	}else{
		print("Your Email has not been sent successfully ".$status);
	}
    
    

?>
    