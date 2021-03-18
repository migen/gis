<?php // flashMessage Div here 
	if(Session::get("message") != ""){
		$flashMessage = Session::get("message");
		echo "<h2 class='flashMessage brown'>".$flashMessage."</h2>";
		Session::set('message',null);
	}

?>

