<html>
<head><title>LABSITE</title>
<link type='text/css' rel='stylesheet' href="<?php echo URL; ?>public/style.css" />
<script type='text/javascript' src="<?php echo URL; ?>public/js/jquery.js"></script>

<?php 
	if(isset($this->js)){
 		foreach($this->js as $js){
			echo '<script type="text/javascript" src="'.URL."views/".$js.'"></script>';
		}
	}
?>


</head><body>
<div id='outline'>
<div id="wrapper">

<div id="header">
<a href="<?php echo URL; ?>posts">Posts</a>
<a href="<?php echo URL; ?>pages">Pages</a>
<?php if(Session::get('logged') == 0): ?>
<a href="<?php echo URL; ?>index">Index</a>
<a href="<?php echo URL; ?>math">Math</a>  
<a href="<?php echo URL; ?>users/login">Login</a>

<?php else: ?>
<a href="<?php echo URL; ?>axes">Axe</a>  
<a href="<?php echo URL; ?>data">Data</a>  
<a href="<?php echo URL; ?>chat">Chat</a>  
<a href="<?php echo URL; ?>data/dashboard">Dashboard</a>  
	<?php if(Session::get('role')=='admin'): ?>
		<a href="<?php echo URL; ?>users">Users</a>  
	<?php endif; ?>
<a href="<?php echo URL; ?>users/logout">Logout</a>  
<br />
<?php endif; ?>



</div> <!-- header -->


<div id='side2'>
<ul>
Data
<li><a href="<?php echo URL;?>data/admininfo">data admininfo</a></li>
<li><a href="<?php echo URL;?>data/timestwo">data timestwo</a></li>
<li><a href="<?php echo URL;?>data/query">data query</a></li>
Tests
<li><a href="<?php echo URL;?>tests/css">Tests Css</a></li>
<li><a href="<?php echo URL;?>tests/query">tests query</a></li>
<li><a href="<?php echo URL;?>tests/xhradd">tests xhradd</a></li>
</ul>



</div>


<div id="main">

<div class='flashMsg red'>
<?php // flashMessage Div here 
	if(Session::get("msg") != ""){
		$flashMsg = Session::get("msg");
		echo "<h2>".$flashMsg."</h2>";
		Session::set('msg','');
	}

?>
</div>