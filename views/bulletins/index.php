<?php// pr($q);$get = isset($_GET)? sages($_GET):'';	// echo "get : $get <br />"; $d['cstatuses'] = $cstatuses; $d['ctags']		= $ctags;$d['room_id']	= $room['id'];$d['room']		= $room;$today	 = date('Y-m-d');$numrows = count($bullets);$user	 = $_SESSION['user'];function overdays($deadline,$today){		$dt1 = strtotime($deadline);		$dt2 = strtotime($today);		$dtdiff = $dt1 - $dt2;		$days_left = $dtdiff/(3600*24);		return $days_left;}?><h5>	<span ondblclick="tracehd();"  > Bulletin </span> 		- Circle <?php echo $room['name']; ?>	| <a href="<?php echo URL.'circles'; ?>" >Home</a>	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				| <a href="<?php echo URL.'bulletins/index/1?cstatus_id=1&circle='.$room['id']; ?>" >Events</a>	| <a href="<?php echo URL.'bulletins/add/'.$room['id']; ?>" >Add</a>	| <a href="<?php echo URL.'circles/members/'.$room['id']; ?>" >Members</a></h5><p><?php $this->shovel('search_bulletin',$d); ?></p><table class="gis-table-bordered table-fx table-altrow"  ><tr class="headrow" >	<th>#</th>	<th>Item</th>	<th>Tag</th>	<th>Date</th>	<th>Status</th>	<th>Who</th>	<th>Action</th>	<th class="hd" >BID</th></tr><?php for($i=0;$i<$numrows;$i++): ?><tr id="row-<?php echo $i; ?>" >	<?php 		$is_owner = $user['ucid']==$bullets[$i]['ucid'];		$is_info  = $bullets[$i]['cstatus_id']=='3';		$has_body = $bullets[$i]['has_body']=='1';		$is_collaborative = $bullets[$i]['is_collaborative']=='1';		if(!$is_info){			$overdue = ($today>$bullets[$i]['date'])? true:false; 			if($overdue){ $overdays = overdays($today,$bullets[$i]['date']); }				} else { $overdue = false; }	?>	<td><?php echo $i+1; ?></td>	<td class="vc500" >		<?php if($has_body): ?>			<a href="<?php echo URL.'bulletins/view/'.$bullets[$i]['id']; ?>"   > <?php echo $bullets[$i]['info']; ?> </a>	<?php else: ?>		<?php echo $bullets[$i]['info']; ?>	<?php endif; ?>			</td>	<td><?php echo $bullets[$i]['ctag']; ?></td>		<td class="<?php echo ($overdue)? 'red':NULL; ?>" ><?php echo date('M-d',strtotime($bullets[$i]['date'])); ?></td>	<td id="od-<?php echo $i; ?>" class="center <?php echo ($overdue)? 'red':NULL; ?>" ><?php echo ($overdue)? $overdays: $bullets[$i]['status']; ?></td>	<td><?php echo $bullets[$i]['owner']; ?></td>	<td>		<?php if($is_owner): ?>			<a href="<?php echo URL.'bulletins/edit/'.$bullets[$i]['id']; ?>"   > Edit </a> 								<?php if($bullets[$i]['cstatus_id']=='1'): ?>				| <a onclick="xcloseEvent(<?php echo $i; ?>);" class="txt-blue underline"   >Close </a> 			<?php endif; ?>			| <a onclick="xdeleteBulletin(<?php echo $bullets[$i]['id']; ?>);" class="txt-blue underline"   >Delete</a> 					<?php endif; ?>	</td>	<td class="hd" ><?php echo $bullets[$i]['id']; ?></td>		<input id="eid-<?php echo $i; ?>" type="hidden" value="<?php echo $bullets[$i]['id']; ?>"   /></tr><?php endfor; ?></table><!-- --------------------------------------------------------------------------------------------- --><p>	<!-- pagination -->	<?php  if(isset($num_pages) && $num_pages){ echo $data['pages']; } ?></p><!-- --------------------------------------------------------------------------------------------- --><script>var gurl 	= 'http://<?php echo GURL; ?>';$(function(){	hd();		})function xcloseEvent(i){	var eid = $('#eid-'+i).val();	var od  = $('#od-'+i).text();	var sure = confirm('Are you sure?');	if(sure){		var vurl = gurl + '/bulletins/xcloseEvent';					 		$.ajax({		  type: 'POST',		  url: vurl,		  data: "eid="+eid+"&od="+od,	  		  success: function(){ $('#row-'+i).remove(); }			  		  	   });							}}function xdeleteBulletin(bid){	var sure = confirm('Are you sure?');	if(sure){		var vurl = gurl + '/bulletins/xdeleteBulletin';					 		$.ajax({		  type: 'POST',		  url: vurl,		  data: "bid="+bid,	  		  success: function(){  location.reload(); }			  		  	   });						}}	/* fxn */</script>