<?php 

// pr($intfqtr);
// pr($_SESSION['q']); 
// pr($_SESSION['today']);

$data['crs']['home'] 	= $data['adv']['home'] 	= $_SESSION['home'];
$data['crs']['sy'] 		= $data['adv']['sy'] 	= $sy;
$data['crs']['qtr'] 	= $data['adv']['qtr'] 	= $qtr;
$data['crs']['intfqtr'] 	= $data['adv']['intfqtr'] 	= $intfqtr;



?>




<h5> 
	<span class="u" ondblclick="tracehd();" ><?php echo $level['level']; ?></span>
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			

	
	
</h5>

<p>
	<?php foreach($levels AS $row): ?>
		<a href='<?php echo URL."acad/mca/".$row['id']; ?>' ><?php echo $row['code']; ?></a> &nbsp;&nbsp;   
	<?php endforeach; ?>
</p>



<input id="qtr" type="hidden" value="<?php echo $qtr; ?>" />

<p> <?php	$this->shovel('advQtr',$data['adv']); ?> </p>	
<p> <?php	$this->shovel('crsQtr',$data['crs']); ?> </p>




<!-------------------------  ------------------------------------------------------------------------------------->





<script>

var gurl = 'http://<?php echo GURL; ?>';


$(function(){
	hd();
	// accorHd();
			
})



function accorToggle(sxn){
	$("#"+sxn).toggle();			
}

function accorHd(){
	$(".accordParent table").hide();			
}


	
</script>

<script type='text/javascript' src="<?php echo URL; ?>views/js/mca.js"></script>


<!-------------------------------------------------------------------------------------------------------------->