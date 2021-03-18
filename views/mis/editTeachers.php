
<h5>
	<span class="u" ondblclick="tracehd();" >Edit Teachers</span> | 
	<?php 	$this->shovel('homelinks','mis'); ?>
	| <a href="<?php echo URL.'setup/grading/'.$sy; ?>" >Setup</a>
	| <a href="<?php echo URL.'mis/classroomsAdvisers'; ?>" >Advisers</a>
	| <a href="<?php echo URL.'mis/teachers'; ?>" >Teachers</a>	
	| <a class="u" onclick="ilabas('clipboard');" >Smartboard</a>
	
</h5>

<?php 

// pr($rows[4]);

?>

<!------------------------------------------------------------------------------------->

<div style="float:left;width:75%;" >	<!-- left main -->

<form method="POST" >
<table class="gis-table-bordered table-fx table-altrow" >

<tr class="headrow" >
	<th>#</th>
	<th>UCID</th>
	<th>PCID</th>
	<th class="hd" >CRID</th>
	<th>Classroom</th>
	<th>Lvl</th>
	<th>Sxn</th>
	<th class="hd" >TCID</th>
	<th>Adviser</th>
	<th>Account</th>
	<th class="hd" >Pass</th>
	<th>Male<br />
		<input id="imle" class="vc30" /><br />
		<button onclick="populateColumn('mle');return false;" >All</button>
	</th>
	<th>Actv<br />
		<input id="iactv" class="vc30" /><br />
		<button onclick="populateColumn('actv');return false;" >All</button>
	</th>
	<th>Clrd<br />
		<input id="iclrd" class="vc30" /><br />
		<button onclick="populateColumn('clrd');return false;" >All</button>
	</th>		
	<th class="center" >Manage</th>
</tr>

<?php for($i=0;$i<$num_rows;$i++): ?>

<tr class="<?php echo($rows[$i]['is_active'])? NULL:'red'; ?>"  >
	<td><?php echo $i+1; ?></td>
	<td><input class="vc60" name="posts[<?php echo $i; ?>][ucid]" value="<?php echo $rows[$i]['ucid']; ?>" readonly /></td>
	<td><?php echo ($rows[$i]['ucid']==$rows[$i]['pcid'])? null:$rows[$i]['pcid']; ?></td>
	<td class="hd" ><?php echo $rows[$i]['crid']; ?></td>
	<td><?php echo $rows[$i]['classroom']; ?></td>
	<td><?php echo $rows[$i]['level_id']; ?></td>
	<td><?php echo $rows[$i]['section_id']; ?></td>
	<td class="hd" ><?php echo $rows[$i]['ucid']; ?></td>
	<td><input id="name<?php echo $i; ?>" name="posts[<?php echo $i; ?>][name]" 
		value="<?php echo $rows[$i]['adviser']; ?>" /></td>
	<td><input id="code<?php echo $i; ?>" class="vc80" name="posts[<?php echo $i; ?>][account]" 
		value="<?php echo $rows[$i]['account']; ?>" /></td>	
	<td class="hd" ><?php echo $rows[$i]['ctp']; ?></td>		
	<td><input class="vc30 mle" name="posts[<?php echo $i; ?>][is_male]" value="<?php echo $rows[$i]['is_male']; ?>" /></td>	
	<td><input class="vc30 actv" name="posts[<?php echo $i; ?>][is_active]" value="<?php echo $rows[$i]['is_active']; ?>" /></td>	
	<td><input class="vc30 clrd" name="posts[<?php echo $i; ?>][is_cleared]" value="<?php echo $rows[$i]['is_cleared']; ?>" /></td>		
	<td>
<button class="vc60" ><a class="no-underline txt-black" href="<?php echo URL.'contacts/ucis/'.$rows[$i]['ucid']; ?>" >
	Edit</a></button>				
	</td>
</tr>

<?php endfor; ?>
</table>


<p><input type="submit" name="submit" value="Save"  /></p>
</form>
</div>	<!-- left main -->

<div class="clipboard" style="width:200px;float:left;"  >
<p>
<select id="classbox" >
	<option value="name" >Teacher</option>
	<option value="code" >Account</option>
</select>
</p>
<?php $d['width'] = '20'; ?>
<?php $this->shovel('smartboard',$d); ?>
</div>




<!------------------------------------------------------------------------>

<script>

var gurl = 'http://<?php echo GURL; ?>';
var sy	 = '<?php echo $sy; ?>';

$(function(){
	hd();
	nextViaEnter();
	itago('clipboard');

})



</script>