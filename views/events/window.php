<?php 

// pr($_SERVER);
?>

<style>


div#container{
	float:left;
	margin:auto;
	width:1180px;
	overflow-x:hidden;
}


div.event{
	width:220px;
	height:150px;
	float:left;
	margin:10px;	
	border:1px solid green;	
}


.event > .header {
	padding-left:10%;
	width:90%;
	background-color:lightblue;
}

.event > .body {
	padding:6px;
	width:100%;
}


</style>

<h5>
	Calendar of Events
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>

	<?php if(isset($_GET['all'])): ?>
		| <a href='<?php echo URL."events/".$_SESSION['moid']; ?>' ><?php echo $_SESSION['month']; ?></a>
	<?php else: ?>
		| <a href='<?php echo URL."events?all"; ?>' >All</a>	
	<?php endif; ?>

	<?php if(!isset($_GET['future'])): ?>
			| <a href='<?php echo URL."events?all&future"; ?>' >Future</a>	
	<?php else: ?>		
			| <a href='<?php echo URL."events?all"; ?>' >All</a>		
	<?php endif; ?>		
	
	
	
	| <a href='<?php echo URL."events/add"; ?>' >New</a>		

	
</h5>


<div id="container" >
<?php for($i=0;$i<$count;$i++): ?>
	<div class="event" >
		<div class="header" >
			<span class="f12" ><?php echo $events[$i]['date'].' - '.$events[$i]['contact']; ?></span>
		</div>
		<div class="body" >
			<span class="f12" ><?php echo substr($events[$i]['event'],0,100); ?></span>
			<br />
			<a href='<?php echo URL."events/view/".$events[$i]['id']; ?>' >View</a> |
			<a href='<?php echo URL."events/edit/".$events[$i]['id']; ?>' >Edit</a> | 
			<a href='<?php echo URL."events/delete/".$events[$i]['id']; ?>' >Delete</a>
		</div>
	</div>
<?php endfor; ?>
</div>



