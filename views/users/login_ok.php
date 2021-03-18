<style>




</style>


<?php 



  // background-image: url("../img/glyphicons-halflings.png");
  // echo URL."public/images/login";

$parts = rtrim($_GET['url'],'/'); 
$parts = explode('/',$parts);		
$home = ($c = array_shift($parts))? $c : 'index'; 			

?>


<form method="post">


<h5>Login
| <a href='<?php echo URL."users/prefix"; ?>' >Prefix</a>	
<a target='blank' class='white' href='<?php echo URL."users/mdfive"; ?>' >MDFive Encryption</a>	


<?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==1): ?>
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
<?php endif; ?>


</h5>

<div class="third" >
<table id='login' class='' >
<!-- sql injection -->
<tr><td><label>Username</label></td><td><input class="pdl05" accesskey='l' type='text' name='data[User][code]' 
	maxlength='20' placeholder='Login ID' AutoFocus  /></td></tr>

<tr><td colspan="2">&nbsp;</td></tr>
<tr><td><label>Password</label></td><td><input class="pdl05" type='password' name='data[User][pass]' 
	maxlength='20' placeholder='Password' /></td></tr>
<tr><td colspan="2">&nbsp;</td>
</tr>

<tr><td></td><td colspan=''><input type='submit' name='submit' value='Log In'></td></tr>


</table>
</form>
</div>



