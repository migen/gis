<?php // pr($criteria); 
	$cri=$criteria_id;

?>


<h5>

	<span class="u" ondblclick="tracepass();" >Edit</span> Traits Criteria (<?=$count;?>) <?php echo "Q$qtr"; ?>
	| <a href="<?php echo URL.$_SESSION['home']; ?>" />Home</a>  
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>					
	| <a href='<?php echo URL."trs/view/$crsid/$tcid"; ?>'>View</a>	
	| <span class="blue u" onclick="ilabas('clipboard');" >Smartboard</span>
	<span class="hd" >| <a href='<?php echo URL."trs/delsync/$crsid/$tcid/$cri"; ?>'>DelSync</a></span>	
	
| Input Max <input class="vc50 center" value="<?php echo $imax; ?>" onchange="reloadMax(this.value);return false;" />

</h5>
<h4><?php echo $cr['name'].' - '.$teacher['name'].' - '.$criteria['code'].' - '.$criteria['name']; ?></h4>

<p><?php $this->shovel('hdpdiv'); ?></p>


<p class="brown" >Go back and press "Sync" button at the bottom to initialize if No grades appear on this page.</p>




<div class="half left" >	<!-- left -->
<form method="POST" >
<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th><input type="checkbox" id="chkAlla"  /></th>	
	<th>#</th>
	<th>Scid</th>
	<th>Student</th>
	<th>DB</th>
	<th>Grade</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><input type="checkbox" class="chka" name="rows[<?php echo $rows[$i]['gid']; ?>]" 
		value="<?php echo $rows[$i]['gid']; ?>" /></td>		
	<td><?php echo $rows[$i]['gid']; ?></td>
	<td><?php echo $rows[$i]['scid']; ?></td>
	
	<td><?php echo $rows[$i]['student']; ?></td>
	<td><?php echo $rows[$i]['grade']; ?></td>
	<td>
		<input type="hidden" name="posts[<?php echo $i; ?>][gid]" value="<?php echo $rows[$i]['gid']; ?>" />
		<input class="center vc40" name="posts[<?php echo $i; ?>][grade]" value="<?php echo $rows[$i]['grade']; ?>" 
			id="aim<?php echo $i; ?>" tabindex="10" onchange="belowMax(this.value);return false;" />
	</td>

</tr>
<?php endfor; ?>
</table>

<p>
	<input type="submit" name="submit" value="Submit"  />
	<span class="" ><input onclick="return confirm('Sure?');" type='submit' name='batch' value='Delete' ></span>
</p>

</form>

</div>	<!-- left -->

<div class="" ><?php $this->shovel('clipboard'); ?></div>



<script>

var gurl = "http://<?php echo GURL; ?>";
var crs 	= "<?php echo $crsid; ?>";
var tcid 	= "<?php echo $tcid; ?>";
var cri 	= "<?php echo $criteria_id; ?>";
var sy	 	= "<?php echo $sy; ?>";
var qtr 	= "<?php echo $qtr; ?>";
var ds 		= "/";
var getdg = "<?php echo ($dgonly)? '&dgonly':NULL; ?>";
var imax = "<?php echo $imax; ?>";
var hdpass 	= '<?php echo HDPASS; ?>';



$(function(){
	hd();
	$('#hdpdiv').hide();	
	nextViaEnter();
	selectFocused();
	itago('clipboard');
	chkAllvar('a');
	
})

function belowMax(val){
	if(parseInt(val)>parseInt(imax)){ alert('Over max value.'); }	
}	/* fxn */


function reloadMax(val){
	var url=gurl+'/trs/editTrsColumn/'+crs+ds+tcid+ds+cri+ds+sy+ds+qtr;
	url+='?imax='+val;
	window.location=url;
}	/* fxn */


</script>
