<h3>
	Add <?php echo ($feetype_id)? $feetype.' #'.$feetype_id:'Payable'; ?> | 
	<?php $this->shovel('homelinks'); ?> 
	| <a href="<?php echo URL.'students/balances/'.$scid.DS.$sy; ?>" >Balances</a>
	
</h3>

<?php 

	// pr($data);

	$dbo=PDBO;
	$dbcontacts="{$dbo}.00_contacts";


?>

<p><table id="tbl-1" class="gis-table-bordered " >
	<tr>
		<th>ID</th>
		<td>
		<input class="pdl05" id="part" autofocus placeholder="name" />
		<input type="submit" name="auto" value="Students" onclick='getDataByTable(dbcontacts,30);return false;' />		
	</td></tr>
</table></p>



<div id="names" >names</div>



<?php if($scid): ?>

<form method="POST" >
<table class="gis-table-bordered" >
<tr><th>ID No.</th><td><?php echo $row['studcode']; ?></td></tr>
<tr><th>Student</th><td><?php echo $row['studname']; ?></td></tr>
<?php extract($row); ?>
<tr><th>SY</th><td><input type="number" name="post[sy]" value="<?php echo $sy; ?>" ></td></tr>
<tr><th>Feetype</th>
<td>
	<select class="vc200" name="post[feetype_id]" >
		<?php foreach($feetypes AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" 
				<?php echo ($sel['id']==$feetype_id)? 'selected':NULL; ?> >
				<?php echo $sel['name']; ?></option>
		<?php endforeach; ?>
	</select>
</td>
</tr>
<tr><th>Amount</th><td><input name="post[amount]" value=0 ></td></tr>
<tr><th>Due On</th><td><input name="post[due_on]" value="<?php echo $_SESSION['today']; ?>" ></td></tr>
<tr><td colspan=2><input type="submit" name="submit" value="Save" ></td></tr>
<input type="hidden" name="post[scid]" value="<?php echo $scid; ?>" >
<input type="hidden" name="studname" value="<?php echo $studname; ?>" >
</table>
</form>

<?php endif; ?>		<!-- scid -->




<script>
var gurl = "http://<?php echo GURL; ?>";
var sy = "<?php echo $sy; ?>";
var feetype_id = "<?php echo $feetype_id; ?>";
var dbcontacts = "<?php echo $dbcontacts; ?>";
var limit=20;
			
$(function(){
	$('html').live('click',function(){ $('#names').hide(); });
	$('#names').hide();
	
})




function axnFilter(id){
	var url=gurl+"/payables/add/"+id+"/"+sy+"&feetype_id="+feetype_id;
	window.location=url;
}





</script>



<script type="text/javascript" src='<?php echo URL."views/js/axjs.js"; ?>' ></script>

