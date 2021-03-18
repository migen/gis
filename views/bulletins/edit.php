<?php 

// pr($_SESSION['q']);
// pr($bulletin);
// pr($cstatuses);

$user = $_SESSION['user'];

$bid 			  = $bulletin['id'];
$is_owner 		  = $user['ucid']==$bulletin['ucid'];
$is_collaborative = $bulletin['is_collaborative'];
$has_body 		  = $bulletin['has_body'];
$is_mis  		  = ($user['role_id']==RMIS);


/* 
echo ($is_owner)? 'owner':'not owner';  echo "<br />";
echo ($is_collaborative)? 'IS colloabro':'not collabor'; echo "<br />";
echo ($readonly)? 'readonly':'NOT readonly'; echo "<br />";
echo ($is_editable)? 'editable':'NOT editable'; echo "<br />";
echo ($has_body)? 'has Body':'NO Body'; echo "<br />";
echo ($has_bullbody)? 'has BullBody':'NO BullBody';

 */
?>

<h5> 
	<a href="<?php echo URL.'bulletins/index/1?circle='.$bulletin['room_id'].'&cstaus_id=1'; ?>" ><?php echo $bulletin['room']; ?></a>
	| <a href="<?php echo URL.'circles'; ?>" >Circles</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			

	<?php if($has_body && $is_owner): ?>
		| <a class="txt-blue underline" onclick="xdeleteBullbody(<?php echo $bid; ?>);" >Detach</a>
	<?php elseif(!$has_body && $is_owner): ?>
		| <a class="txt-blue underline" onclick="xaddBullbody(<?php echo $bid; ?>);" >Attach</a>	
	<?php endif; ?>
	
</h5>


<form method="POST" >
<table class="gis-table-bordered table-fx"  >
<tr><th class="bg-blue2 white" >Owner</th><td><?php echo ucfirst($bulletin['owner']); ?></td></tr>

<tr><th class="bg-blue2 white" >Tag</th><td class="vc300">
	<select class="full"  name="ctag_id" >
		<option value="0" >None</option>
		<?php foreach($ctags AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$bulletin['ctag_id'])? 'selected':NULL; ?>  ><?php echo $sel['name']; ?></option>
		<?php endforeach; ?>
	</select>
</td></tr>

<tr><th class="bg-blue2 white" >Status</th><td class="vc300">
	<select class="full"  name="cstatus_id" >
		<?php foreach($cstatuses AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$bulletin['cstatus_id'])? 'selected':NULL; ?>  ><?php echo $sel['name']; ?></option>
		<?php endforeach; ?>
	</select>
</td></tr>


<tr><th class="bg-blue2 white" >Is Collaborative</th><td>
	<select class="full" name="is_collaborative"  >
		<option value="1" <?php echo ($is_collaborative)? 'selected':NULL; ?> >Collaborative</option>
		<option value="0" <?php echo (!$is_collaborative)? 'selected':NULL; ?> >NOT Collaborative</option>
	</select>
</td></tr>

<tr><th class="bg-blue2 white" >Date</th><td><input class="pdl05 full" type="date" name="date" value="<?php echo $bulletin['date']; ?>" ></td></tr>
<tr><th class="bg-blue2 white" >Bulletin</th><td><input class="pdl05 full" type="text" name="info" value="<?php echo $bulletin['info']; ?>" ></td></tr>

</table>


<p>
<?php if($has_bullbody && $is_owner): ?>
	<p><textarea rows="2" cols="100" name="bb[body]"  >
	<?php echo $bullbody; ?>
	</textarea></p>			
<?php endif; ?>	
	<input type="submit" name="submit" value="Update"  />		
	<?php echo isset($_SERVER['HTTP_REFERER'])? '<button><a class="no-underline" href="'.$_SERVER['HTTP_REFERER'].'" >Back</a></button>' : ''; ?>			
</p>




</form>


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
