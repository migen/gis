<?php 
	// pr($_SESSION['q']);
	$dbo=PDBO;
	$dbg=VCPREFIX.$sy.US.DBG;
	$dbcontacts="{$dbo}.00_contacts";
	$dbstudbooks="{$dbg}.50_students_books";
	$today=$_SESSION['today'];
	
	extract($student);
	// pr($level_id);	
	// pr($student);
	// pr($data);

?>
<h3 class="screen" >
	SJAM Booklist 
	| <?php echo $classroom; ?>
	| <?php $this->shovel('homelinks'); ?>
	
	<?php if($level_id>13): ?>
		<?php if($sem==1): ?>
			| <a href="<?php echo URL.'students/booklist/'.$scid.DS.$sy.'?sem=2'; ?>" >Sem2</a>
		<?php else: ?>
			| <a href="<?php echo URL.'students/booklist/'.$scid.DS.$sy.'?sem=1'; ?>" >Sem1</a>
		<?php endif; ?>		
	<?php endif; ?>
	
</h3>

<div class="screen" >
<?php 

/* navigation controls */
echo $controls."<div class='clear'>&nbsp;</div>";

?>
</div>

<?php 
/* locking */
$is_locked=($srid==RSTUD)? isFinalizedEnstep($db,$scid,$enstep=3):false;
// echo "<br>";echo ($is_locked)? "locked":"open";echo "<br>";

?>

<?php if($srid!=RSTUD): ?>

	<p><table id="tbl-1" class="gis-table-bordered " >
		<tr>
			<th>ID</th>
			<td>
			<input class="pdl05" id="part" autofocus placeholder="name" />
			<input type="submit" name="auto" value="Students" onclick='getDataByTable(dbcontacts,5);return false;' />			
		</td></tr>		
	</table></p>
	<div id="names" >names</div>
<?php endif; ?>



<?php if($scid): ?>

<?php 

?>

<form method="POST" id="form" >

<style type="text/css" media="screen">
	.btn-wrapper {
		margin: auto;
		padding-top: 15px;
		width: 600px;
		text-align:center;
		
	}
	.booklist-wrapper {
		margin: auto;
		padding-top: 15px;
	}
	.bookheader table,
	.booklist table {
		margin: auto;
		width: 600px;
	}
	.bookheader table th,
	.booklist table th {
		text-align: center;
	}
	.bookheader table {
		border-bottom: 1px solid;
	}
	.booklist table {
		margin-top: 15px;
	}
	.right {
		text-align: right;
	}
	.total-amt th {
		font-size: 19px;
		border-top: .08em solid;
	}
	.level-classroom{
		font-size: 25px;
	}
	
</style>

<?php extract($student); ?>

<div class="booklist-wrapper">
	<div class="bookheader">
		<table>
			<tr>
				<th>
					<span style="font-size: 25px">ST. JAMES ACADEMY</span><br>
					<span style="font-size: 20px">MALABON CITY</span><br>
					<span>BOOKLIST</span><br>
					<span>SCHOOL YEAR <?php echo $sy.'-'.($sy+1); ?></span><br>
					<?php if($num==1): ?>
						<span class="level-classroom" ><?php echo strtoupper($student['level']); ?></span>										
					<?php endif; ?>
					<span class="level-classroom" ><?php echo ($num>1)? $classroom:NULL; ?></span>
				</th>
			</tr>
		</table>
	</div>
	<div class="booklist">
		<table>
			<tr>
				<th>BOOK TITLE</th>
				<th width="150">COMPANY</th>
				<th width="100">AMOUNT</th>
			</tr>
			<?php if(($srid==RSTUD) && ($is_locked)): ?>
				<?php $total=0; ?>
				<?php for($i=0;$i<$count;$i++): ?>
				<?php $total+=$rows[$i]['amount']; ?>
				<?php $pkid=$rows[$i]['pkid']; ?>
				<tr id="trow-<?php echo $i; ?>" >
					<td>
						<span><b><?php echo $rows[$i]['subjname']; ?></b></span><br>
						<span><center><?php echo $rows[$i]['book']; ?></center></span>
					</td>
					<td><center><?php echo $rows[$i]['company']; ?></center></td>
					<td class="right" ><?php echo number_format($rows[$i]['amount'],2); ?></td>
				</tr>
				<?php endfor; ?>
			<?php else: ?>
				<?php $total=0; ?>
				<?php for($i=0;$i<$count;$i++): ?>
				<?php $total+=$rows[$i]['amount']; ?>
				<?php $pkid=$rows[$i]['pkid']; ?>
				<tr id="trow-<?php echo $i; ?>" >
					<td>
						<span><b><?php echo $rows[$i]['subjname']; ?></b></span><br>
						<span><center><?php echo $rows[$i]['book']; ?></center></span>
					</td>
					<td><center><?php echo $rows[$i]['company']; ?></center></td>
					<td class="right" ><?php echo number_format($rows[$i]['amount'],2); ?></td>
				</tr>
				<?php endfor; ?>
			<?php endif; ?>	
			<tr class="total-amt">
				<th class="right" colspan="2">TOTAL AMOUNT</th>
				<th class="right"><?php echo number_format($total,2); ?></th>
			</tr>
		</table>
	</div>
</div>



</form>
<?php endif; ?>	<!-- scid -->

	
<div class="clear screen ht100" ></div>	




<script>
var gurl = "http://<?php echo GURL; ?>";
var sy = "<?php echo $sy; ?>";
var dbcontacts = "<?php echo $dbcontacts; ?>";
var dbstudbooks = "<?php echo $dbstudbooks; ?>";
var limit=20;
var today="<?php echo $today; ?>";


			
$(function(){
	$('html').live('click',function(){ $('#names').hide(); });
	$('#names').hide();



})	/* fxn */




function axnFilter(id){
	var url=gurl+"/students/booklist/"+id+"/"+sy;
	window.location=url;
}




function xdelete(dbtable,i){
	var id=$('#pkid-'+i).val();

	if (confirm('Sure?')){
		var vurl = gurl+'/ajax/xdata.php';	
		var task = "xdeleteData";
		var pdata='task='+task+'&id='+id+'&dbtable='+dbtable;
		$.ajax({
			url:vurl,dataType:"json",type:"POST",
			data:pdata,async:true,
			success: function() {  $('#trow-'+i).hide(); }		  
		});									
	}	


}	/* fxn */





</script>



<script type="text/javascript" src='<?php echo URL."views/js/axjs.js"; ?>' ></script>

