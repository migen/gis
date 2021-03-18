<?php 

// echo GURL;
// echo $home;
// echo $sy;


?>

<h5>GIS Information</h5>

<table class="gis-table-bordered table-fx" >
<tr><th class="white bg-blue2 vc200" >Academics</th></tr>
<tr><td><a class="b" href='<?php echo URL."data/levels/$sy"; ?>'>* LEVELS *</a></td></tr>

<?php if($user['role_id']==RMIS): ?>
	<tr><td> 
		<select class="vc200" onchange="redir('mis','components',this.value);" >
			<option value="0">Components</option>
			<?php foreach($levels AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select> &nbsp; Go
	</td></tr>
<?php endif; ?>

<tr><td> 
<select class="vc200" onchange="redir('info','courses',this.value);" >
	<option value="0">Courses</option>
	<?php foreach($levels AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select> &nbsp; Go
</td></tr>

<tr><td> 
<select class="vc200" onchange="redir('info','students',this.value);" >
	<option value="0">Students</option>
	<?php foreach($levels AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select> &nbsp; Go
</td></tr>




<tr><td><a href='<?php echo URL."data/loading"; ?>'>Loading</a></td></tr>
<tr><td><a href='<?php echo URL."data/teachers"; ?>'>Teachers</a></td></tr>
<tr><td><a href='<?php echo URL."data/classrooms/$sy"; ?>'>Classrooms</a></td></tr>




</table>



<!----------------------------------------------------------------------------------->

<script>

var gurl = 'http://<?php echo GURL; ?>';
var home = '<?php echo $home; ?>';
var sy  = '<?php echo $sy; ?>';
			
	$(function(){
		hd();
		
	})
		
		

	
		
	function redir(ctlr,axn,param){
		var rurl 	= gurl + '/'+ctlr+'/'+axn+'/'+param+'/'+sy;		/* redirect url */	
		// alert(rurl);
		window.location = rurl;		
	}
			
		
</script>