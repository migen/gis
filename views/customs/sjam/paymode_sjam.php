<h3>
	SJAM Paymode SY<?php echo ($sy); ?> | <?php $this->shovel('homelinks'); ?>
<?php if($srid!=RSTUD): ?>
	| <a href='<?php echo URL."enrollment/ledger/$scid/$sy"; ?>' >Ledger</a>
<?php endif; ?>	

</h3>


<?php 

$dbo=PDBO;
$dbcontacts="{$dbo}.00_contacts";

?>

<?php if($srid!=RSTUD): ?>
<p><table id="tbl-1" class="gis-table-bordered " >
	<tr>
		<th>ID</th>
		<td>
		<input class="pdl05" id="part" autofocus placeholder="name" />
		<input type="submit" name="auto" value="Students" onclick='getDataByTable(dbcontacts,30);return false;' />
		
	</td></tr>
	
</table></p>
<div id="names" >names</div>
<?php endif; ?>	<!-- !user_is_student -->


<?php if($scid): ?>
<form method="POST" >
<table class="gis-table-bordered" >
<tr><th>Level</th><td><?php echo $row['level']; ?></td></tr>
<tr><th>ID No.</th><td><?php echo $row['studcode']; ?></td></tr>
<tr><th>Student</th><td class="vc200" ><?php echo $row['studname']; ?></td></tr>

<?php if($srid==RSTUD): ?>
	<tr><th>Status</th><td><?php echo ($row['paymode_finalized']==1)? 'Locked':'Open'; ?>
		<input type="hidden" name="summ[paymode_finalized]" value=1 >
	</td></tr>
<?php else: ?>
	<tr><th>Status</th><td><select name="summ[paymode_finalized]" >
		<option value="1" <?php echo ($row['paymode_finalized']==1)? 'selected':NULL; ?> >Locked</option>
		<option value="0" <?php echo ($row['paymode_finalized']==0)? 'selected':NULL; ?> >Open</option>
	</select>
	</td></tr>
<?php endif; ?>

<tr><th>Paymode</th><td><?php echo $row['paymode']; ?></td></tr>

<?php if(($srid==RSTUD) && ($row['paymode_finalized']==1)){ echo "</table>"; exit; } ?>
	<?php if($row['level_id']>2): ?>
		<tr><th>Change</th><td>
			<input type="hidden" name="summ[id]" value="<?php echo $row['pkid']; ?>" >
			<select name="summ[paymode_id]"   >
				<?php foreach($paymodes AS $sel): ?>
					<option value="<?php echo $sel['id']; ?>" <?php echo ($row['paymode_id']==$sel['id'])? 'selected':NULL; ?> >
						<?php echo $sel['name']; ?></option>
				<?php endforeach; ?>
			</select>
		</td></tr>
	<?php else: ?>	
		<tr><th>Change</th><td>
			<input type="hidden" name="summ[id]" value="<?php echo $row['pkid']; ?>" >
			<select name="summ[paymode_id]"   >
				<option value=1 <?php echo ($row['paymode_id']==1)? 'selected':NULL; ?> >Yearly</option>
				<option value=3 <?php echo ($row['paymode_id']==3)? 'selected':NULL; ?> >Monthly</option>
			</select>
		</td></tr>
	<?php endif; ?>		


<?php if($srid==RSTUD): ?>
	<tr><th colspan=2><input type="submit" name="submit" value="Save" onclick="return confirm('One time change only. Sure?');" ></th></tr>
<?php else: ?>
	<tr><th colspan=2><input type="submit" name="submit" value="Save" ></th></tr>
<?php endif; ?>
</table>
</form>
<?php endif; ?> 	<!-- scid -->

<script>
var gurl = "http://<?php echo GURL; ?>";
var sy = "<?php echo $sy; ?>";
var dbcontacts = "<?php echo $dbcontacts; ?>";
var limit=20;


$(function(){
	$('#names').hide();
	$('html').live('click',function(){ $('#names').hide(); });
	
})

function axnFilter(id){
	var url = gurl+'/students/paymode/'+id+'/'+sy;	
	window.location=url;
}	/* fxn */




</script>

<script type="text/javascript" src='<?php echo URL."views/js/axjs.js"; ?>' ></script>
