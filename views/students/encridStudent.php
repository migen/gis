<?php 
	// pr($_SESSION['q']);
	$dbo=PDBO;
	$dbg=VCPREFIX.$sy.US.DBG;
	$dbcontacts="{$dbo}.00_contacts";
	$dbclassrooms="{$dbg}.05_classrooms";

?>
<h3>
	Student Enrollment Classroom <?php echo $sy; ?> | <?php $this->shovel('homelinks'); ?>
	| <a href='<?php echo URL."enrollment/ledger/$scid?sy=$sy"; ?>' >Ledger</a>
	| <a href='<?php echo URL."students/leveler/$scid/$sy"; ?>' >Leveler</a>
	| <a href='<?php echo URL."students/sectioner/$scid/$sy"; ?>' >Sectioner</a>


</h3>


<p><table id="tbl-1" class="gis-table-bordered " >
	<tr>
		<th>ID</th>
		<td>
		<input class="pdl05" id="part" autofocus placeholder="name" />
		<input type="submit" name="auto" value="Classrooms" onclick='getDataByTable(dbclassrooms,5);return false;' />
		<input type="submit" name="auto" value="Students" onclick='getDataByTable(dbcontacts,5);return false;' />
		
	</td></tr>
	
</table></p>

<?php if($scid): ?>

<div class="half" >	<!-- left -->
<form method="POST" >

<table class="gis-table-bordered" >
<tr><td>Scid </td><td><?php echo $row['scid']; ?></td></tr>
<tr><td>Student </td><td><?php echo $row['studname']; ?></td></tr>
<tr><td>Classroom (summ)</td><td><?php echo $row['classroom'].' #'.$row['summcrid']; ?></td></tr>
<tr><td>Lvl-Num</td><td><?php echo $row['level_id'].'-'.$row['num']; ?></td></tr>
<tr><td>enid | summid</td><td>
	<input class="vc50" readonly name="post[enid]" value="<?php echo $row['enid']; ?>" >
	<input class="vc50" readonly name="post[summid]" value="<?php echo $row['summid']; ?>" >
</td></tr>
<tr><td>Encrid </td><td><input name="post[encrid]" value="<?php echo $row['encrid']; ?>" ></td></tr>
<tr><td>Summcrid </td><td><input name="post[summcrid]" value="<?php echo $row['summcrid']; ?>" ></td></tr>

<tr><th colspan=2 ><input type="submit" name="submit" value="Save" ></th></tr>
</table>

</form>
</div>

<?php endif; ?>	<!-- scid -->


<div id="names" >names</div>



<script>
var gurl = "http://<?php echo GURL; ?>";
var sy = "<?php echo $sy; ?>";
var dbcontacts = "<?php echo $dbcontacts; ?>";
var dbclassrooms = "<?php echo $dbclassrooms; ?>";
var limit=20;
			
$(function(){
	$('html').live('click',function(){ $('#names').hide(); });
	$('#names').hide();
	
})




function axnFilter(id){
	var url=gurl+"/students/encrid/"+id+"/"+sy;
	window.location=url;
}









</script>



<script type="text/javascript" src='<?php echo URL."views/js/axjs.js"; ?>' ></script>

