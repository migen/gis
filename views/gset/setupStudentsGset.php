
<style>
div{ border:0px solid black; }


</style>

<?php 


// pr($data);
$lc=$last_contact;
$lcid=isset($_GET['lcid'])? $_GET['lcid']:$lc['id'];
$dbo=PDBO;


?>


<h5>
	Students Setup
	| <?php $this->shovel('homelinks','GSET'); ?>
	| <span onclick="ilabas('clipboard');" class="u" >Smartboard</span>
	| <span>Last Contact:<?php echo $lc['name'].' #'.$lc['id']; ?></span>	
	| <a href='<?php echo URL."setup/students"; ?>' >With-Classroom</a>
	| <a href='<?php echo URL."records/setup/{$dbo}.00_contacts"; ?>' >Custom</a>
</h5>



<div style="float:left;width:60%;" >

<p><?php $this->shovel('numrows'); ?></p>


<h5> 
	Add Students
	| <a class="u" onclick="ilabas('clipboard');" >Smartboard</a>
	| &lcid=<?php echo $lcid; ?>
</h5>


<form method="POST" >

<p>
	<input type="submit" name="submit" value="Add" /> &nbsp; 
	<button><a href="<?php echo URL.'mis'; ?>" class="no-underline" >Cancel</a></button>
	&nbsp; <span class="bg-gray" > Axis &nbsp; <input type="checkbox" value="1" name="axis" /></span>		
</p>

<table class="gis-table-bordered" >
<tr class='headrow'>
	<th class="vc30" >#</th>	
	<th class="vc30" >SCID</th>	
	<th class="vc100" >LRN</th>
	<th class="vc100" >ID Number</th>
	<th class="vc200" >Fullname</th>
	<th class="vc50" >Sex<br />M: 1<br />F: 0	
		<input class="vc50" type="text" id="isex" placeholder="All" />
		<button class="vc50" onclick="populateColumn('sex');return false;">All</button>				
	</th>
	<th class="vc50" >Role<br />K12: 1<br />Coll: 8	
		<input class="vc50" type="text" id="irole" placeholder="All" />
		<button class="vc50" onclick="populateColumn('role');return false;">All</button>				
	</th>	
</tr>

<?php $numrows = isset($_POST['numrows'])? $_POST['numrows'] : 1; ?>
<?php for($i=0;$i<$numrows;$i++): ?>
<?php $scid=$lcid+1+$i; ?>
<tr >
	<td><?php echo $i+1; ?></td>
	<td><input id="scid<?php echo $i; ?>" class="full" type="text" name="posts[<?php echo $i; ?>][id]" value="<?php echo $scid; ?>" /></td>		
	<td><input id="lrn<?php echo $i; ?>" class="full" type="text" name="posts[<?php echo $i; ?>][lrn]" /></td>		
	<td><input id="code<?php echo $i; ?>" class="full" type="text" name="posts[<?php echo $i; ?>][code]" /></td>		
	<td><input id="name<?php echo $i; ?>" class="full" type="text" name="posts[<?php echo $i; ?>][name]" /></td>		
	<td><input class="center vc50 sex" id="sex<?php echo $i; ?>" class="full" type="text" name="posts[<?php echo $i; ?>][is_male]" /></td>		
	<td><input class="center vc50 role" id="role<?php echo $i; ?>" class="full" type="text" name="posts[<?php echo $i; ?>][role_id]" value=1 /></td>		
		
</tr>

<?php endfor; ?>			
</table>



</form>


</div>



<!------------------------------------------------------------------------>

<div style="width:50px;float:left;height:100px;" ></div>
<div class="clipboard" style="width:200px;float:left;"  >
<p>
<select id="classbox" >
	<option value="scid" >SCID</option>
	<option value="lrn" >LRN</option>
	<option value="code" >Code</option>
	<option value="name" >Name</option>
	<option value="sex" >Sex</option>
	<option value="role" >Role</option>
</select>
</p>
<?php $d['width'] = '20'; ?>
<?php $this->shovel('smartboard',$d); ?>
</div>



<div class="clear ht100" >&nbsp;</div>





<!-------------------------------------------------------------------------------------->

<script>

var gurl = "http://<?php echo GURL; ?>";


$(function(){
	itago('clipboard');

})




</script>




