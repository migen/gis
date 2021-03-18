<?php 

$guardian = (isset($_SESSION['user']['role_id']) && ($_SESSION['user']['role_id']==1) && !isset($_SESSION['user']['child']))? 'Guardian of' : null;

echo "<div id='mainMenu' ><table><tr>";
	if(isset($_SESSION['loggedin']) && ($_SESSION['loggedin'])){
	
?>

<td class='f20'>We<a class="no-underline" href="<?php echo URL.'index/session'; ?>">l</a>come,<?php echo $guardian; ?> <span class='bold' ><?php echo $_SESSION['user']['fullname']; ?> </span> &nbsp; &nbsp; &nbsp; </td>


<?php
		echo "<td class='f20' ><a href='".URL."users/logout'>Logout</a></td>";  
	} else {
		echo "<p><a href='".URL."users/login'>Login</a></p>";  
	
	}		
echo "</tr></table></div>";


