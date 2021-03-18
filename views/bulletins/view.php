<?php 

// pr($_SESSION['q']);
// pr($bulletin);
// pr($data);

$user 			  = $_SESSION['user'];
$bid 			  = $bulletin['id'];
$is_collaborative = $bulletin['is_collaborative'];
$has_body 		  = $bulletin['has_body'];

/* 
$is_owner 		  = $user['ucid']==$bulletin['ucid'];
$readonly		  = (!$is_owner && !$is_collaborative);
$is_mis  		  = ($user['role_id']==RMIS);
$is_editable 	  = !$readonly || $is_mis;
 */


?>

<h5> 
	<a href="<?php echo URL.'bulletins/index/1?circle='.$bulletin['room_id'].'&cstaus_id=1'; ?>" ><?php echo $bulletin['room']; ?></a>
	| <a href="<?php echo URL.'circles'; ?>" >My Circles</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	
</h5>


<form method="POST" >
<table class="gis-table-bordered table-fx"  >
<tr><th class="bg-blue2 white" >Owner</th><td><?php echo ucfirst($bulletin['owner']); ?></td></tr>

<tr><th class="bg-blue2 white" >Tag</th><td class="vc300"><?php echo $bulletin['ctag']; ?></td></tr>

<tr><th class="bg-blue2 white" >Status</th><td class="vc300">
<?php echo $bulletin['cstatus']; ?>
</td></tr>

<tr><th class="bg-blue2 white" >Is Collaborative</th><td><?php echo ($bulletin['is_collaborative'])? 'Collaborative':'NOT Collaborative'; ?></td></tr>

<tr><th class="bg-blue2 white" >Date</th><td><?php echo $bulletin['date']; ?></td></tr>
<tr><th class="bg-blue2 white" >Bulletin</th><td><?php echo $bulletin['info']; ?></td></tr>

</table>

<p>
	<?php if($has_bullbody && $is_collaborative): ?>
		<p><textarea rows="2" cols="100" name="bb[reply]"  ></textarea></p>			
		<input type="submit" name="submit" value="Reply"  />		
	<?php endif; ?>	
	<?php if(!$has_body): ?>
		<button><a onclick="xaddBullbody(<?php echo $bid; ?>);" >Attach Text</a></button>		
	<?php endif; ?>
	
</p>		



</form>

<p>
<?php echo $bullbody; ?>
</p>


<!-- --------------------------------------------------------------------------------------------- -->


<script>

var gurl 	= 'http://<?php echo GURL; ?>';


$(function(){

	hd();
	
	
})

function xaddBullbody(bid){
	var sure = confirm('Are you sure?');
	if(sure){
		var vurl = gurl + '/bulletins/xaddBullbody';					 
		$.ajax({
		  type: 'POST',
		  url: vurl,
		  data: "bid="+bid,	  
		  success: function(){  location.reload(); }			  		  		  
	   });					
	}
}	/* fxn */


function xdeleteBullbody(bid){
	var sure = confirm('Are you sure?');
	if(sure){
		var vurl = gurl + '/bulletins/xdeleteBullbody';					 
		$.ajax({
		  type: 'POST',
		  url: vurl,
		  data: "bid="+bid,	  
		  success: function(){  location.reload(); }			  		  
	   });					
	}
}	/* fxn */


</script>
