<?php 

// =========== DEFINE VARS ===========

// pr($data);

// =========== for shovel vars ===========
$d['prep']			= $data['prep'];		// for prep 

$d['is_locked']		= $is_locked;
$is_this_year = ($_SESSION['sy'] == $curr_sy)? true : false;
$data['is_this_year']  	  = $d['is_this_year'] 		= $is_this_year;
$data['curr_sy'] 	  	= $d['curr_sy'] 			= $curr_sy;
$data['next_sy'] 		= $d['next_sy'] 	= $next_sy;


// =========== DEBUG ===========


// =========== FUNCTIONS ===========
function dated($date,$format='M-d-Y'){
	if(isset($date) && ($date != '0000-00-00')){
		return date($format,strtotime($date));
	} else {
		return null;
	}
}

// pr($data);

$parts = rtrim($_GET['url'],'/'); 
$parts = explode('/',$parts);		
$home = ($c = array_shift($parts))? $c : 'index'; 			

?>

<h5>
	Promotion Report | 
	<a href="<?php echo URL.$home; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
</h5>


<!-- ========================  page info / user info =================================-->
<table class='gis-table-bordered table-fx'>
<tr class="hd" ><th class="bg-blue2" >CID</th><td><?php echo $user['ucid']; ?></td></tr>
<tr class="hd" ><th class="bg-blue2" >DID</th><td><?php echo $user['department_id']; ?></td></tr>
<tr class="hd" ><th class="bg-blue2" >ACL</th><td><?php echo $user['role_id'].'-'.$user['privilege_id']; ?></td></tr>
<tr class="hd" ><th class="bg-blue2" >Title</th><td><?php echo $user['title_id'].'-'.$user['title']; ?></td></tr>
<tr><th class="bg-blue2" >ID Number</th><td><?php echo $user['code']; ?></td></tr>
<tr><th class="bg-blue2" >Class Section</th><td><?php echo $classroom['classroom']; ?></td></tr>
<tr><th class="bg-blue2" >Adviser</th><td><?php echo $classroom['adviser']; ?></td></tr>
<tr><th class="bg-blue2" >School year</th><td><?php echo $curr_sy.' - '.($curr_sy+1); ?></td></tr>
</table>
<br />



<!-- ========================  data / process =================================-->
<form method="POST" >
<?php  

/* 
if(!$is_locked){ 
	$this->shovel('prom',$data);  
}
 */
 
if($is_this_year){ 
	$this->shovel('prep',$d);	
}

?>

<?php if(!$is_locked && $is_this_year): ?>
	<input type="submit" name="prep"  value="Report"  >
	<input type="submit" name="finalize"  value="Finalize"  >
<?php endif; ?>

</form>

<!-- ========================  script  =================================-->

<script>

var gurl = 'http://<?php echo GURL; ?>';
$(function(){
	hd();
	nextViaEnter();
})


</script>

<script type='text/javascript' src="<?php echo URL; ?>views/js/promotions.js"></script>
