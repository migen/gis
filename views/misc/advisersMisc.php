
<h5>
	Advisers | 
	<a href="<?php echo URL.$_SESSION['home']; ?>" />Home</a>  
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>
	| <a href="<?php echo URL.'setup/grading/'.$sy; ?>" >Setup</a>
	| <a href="<?php echo URL.'mis/teachers'; ?>" >Teachers</a>
	| <a href="<?php echo URL.'nonteachers'; ?>" >Nonteachers</a>
	| <span class="u" onclick="tracehd();" >Passwords</span>
	
</h5>

<?php 

// pr($rows[0]);

?>


<table class="gis-table-bordered table-fx table-altrow" >

<tr class="headrow" >
	<th>#</th>
	<th class="" >Crid</th>	
	<th>Level-Section<br />Classlist</th>
	<th>Adviser<br />Login-Pass</th>
	<th>Matrix</th>
	<th>Attd</th>
	<th>Submissions</th>
	<th>Cond/Trts</th>
	<th class="hd" >Pass</th>
	<th>Status</th>
	<th>Manage</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>

<tr class="<?php echo($rows[$i]['is_active'])? NULL:'red'; ?>"  >
	<td><?php echo $i+1; ?></td>
	<td class="" ><?php echo $rows[$i]['crid']; ?></td>
	<td class="vc200" >
		<?php echo $rows[$i]['lvlcode'].'-'.$rows[$i]['sxncode']; ?><br />
		<a href="<?php echo URL.'classlists/classroom/'.$rows[$i]['crid']; ?>" ><?php echo $rows[$i]['classroom']; ?></a></td>
	<td class="" ><?php echo $rows[$i]['adviser']; ?><br />
		<?php echo '#'.$rows[$i]['ucid'].'-'.$rows[$i]['account'].'-'.$rows[$i]['ctp']; ?></td>		
	<td><a href="<?php echo URL.'matrix/grades/'.$rows[$i]['crid'].DS.$ssy.DS.$sqtr; ?>" >Matrix</a></td>		
	<td><a href="<?php echo URL.'attendance/monthly/'.$rows[$i]['crid'].DS.$ssy.DS.$sqtr; ?>" >Attd</a></td>		
	<td><a href="<?php echo URL.'submissions/view/'.$rows[$i]['crid'].DS.$ssy.DS.$sqtr; ?>" >Submissions</a></td>		

	<td>
		<?php $method = ($rows[$i]['crstype_id']==CTYPECONDUCT)? 'conducts' : 'traits'; ?>	
			<a href="<?php echo URL.'advisers/'.$method.'/'.$rows[$i]['conduct_id'].DS.$sy.DS.$sqtr; ?>">
				<?php echo $method; ?></a> 			
	</td>		
	<td class="hd" ><?php echo $rows[$i]['ctp']; ?></td>	
	<td id="stat<?php echo $i; ?>" ><?php echo ($rows[$i]['is_active'])? 'Active':'Not active'; ?></td>
	<td>
	<a class="" href='<?php echo URL."loads/teacher/".$rows[$i]['ucid'].DS.$sy; ?>' >Loads</a>
	| <a class="" href="<?php echo URL.'contacts/ucis/'.$rows[$i]['ucid']; ?>" >Edit</a>
	| <a class="" href="<?php echo URL.'mgt/users/'.$rows[$i]['ucid']; ?>" >User</a>
	| <a class="" href="<?php echo URL.'codename/one/'.$rows[$i]['ucid']; ?>" >Code</a>
	| <a class="" href="<?php echo URL.'mgt/pass/'.$rows[$i]['ucid']; ?>" >Pass</a>
		
		
	</td>
	

</tr>

<?php endfor; ?>
</table>




<!------------------------------------------------------------------------>

<script>

var gurl = 'http://<?php echo GURL; ?>';
var sy	 = '<?php echo $sy; ?>';

$(function(){
	hd();
	nextViaEnter();

})




</script>