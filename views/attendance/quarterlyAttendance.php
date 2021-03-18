<?php 
	$qvsum=($qtr<5)? "q{$qtr}_days_total":"year_days_total";
?>

<h5>
	Attendance Q<?php echo $qtr; ?> (<?php echo $count; ?>) - <?php echo ($is_locked)? 'Locked':'Open'; ?>
	| <a href="<?php echo URL.$_SESSION['home']; ?>" />Home</a>  
	| <span class="blue u" onclick="ilabas('smartboard');" >Smartboard</span>
	| <a class="u" id="btnExport" >Excel</a> 	
	
	
<?php if($is_admin): ?>
	| <?php if($is_locked): ?>
		<a href='<?php echo URL."finalizers/openAttendance/".$cr['crid']."/$sy/$qtr"; ?>' > Unlock </a>
	<?php else: ?>
		<a href='<?php echo URL."finalizers/closeAttendance/".$cr['crid']."/$sy/$qtr"; ?>' > Lock </a>
	<?php endif; ?>	
<?php endif; ?>	

<?php if(isset($_GET['sort']) && ($_GET['sort']=='c.position')): ?>	
	| <a href='<?php echo URL."attendance/quarterly/$crid/$sy/$qtr"; ?>' >Alphabetical</a> 		
<?php else: ?>
	| <a href='<?php echo URL."attendance/quarterly/$crid/$sy/$qtr?sort=c.position"; ?>' >Position</a> 			
<?php endif; ?>
	| <a href='<?php echo URL."attendance/monthly/$crid/$sy/$qtr"; ?>' >Monthly</a> 					

<?php if($_SESSION['qtr']>3): ?>
	| <a href='<?php echo URL."attendance/quarterly/$crid/$sy/5"; ?>' />Total</a>  	
	
<?php endif; ?>

	| <a href='<?php echo URL."attendance/annualQtr/$crid/$sy"; ?>' />Annual</a>  	
	
</h5>

<?php if(isset($_GET['debug'])){ pr($q); } ?>

<?php $this->shovel('hdpdiv'); ?>

<table class='gis-table-bordered table-fx'>

<?php if($qtr<5): ?>
	<tr class="hd" >
		<th>Locking</th><td>
		<?php if($is_locked): ?>
			<a href='<?php echo URL."finalizers/openAttendance/".$cr['crid']."/$sy/$qtr"; ?>' > Unlock </a>
		<?php else: ?>
			<a href='<?php echo URL."finalizers/closeAttendance/".$cr['crid']."/$sy/$qtr"; ?>' > Lock </a>
		<?php endif; ?>
	</td></tr>
<?php endif; ?>

	<tr><th>Classroom | Adviser</th><td><?php echo $cr['level'].' - '.$cr['section'].' | '.$cr['adviser']; ?></td></tr>
	<?php if($qtr < 5): ?> <tr><th>Status</th>
		<td><?php echo 'Q'.$data['qtr'].' - '; echo ($is_locked  == 1)? 'Closed' : 'Open' ; ?></td></tr> <?php endif; ?>	
	
	<?php if(($_SESSION['settings']['has_rfid']==1) && ($current)): ?>
		<tr class="screen" ><th>YYYY-MM-DD </th>
			<td><input id="clsAttDate" class="pdl05 " type="text" value="<?php echo $today; ?>" > 
				<span onclick="redirClsAttLogs();" class="button"  >Go</span>
				<input type="hidden" value="<?php echo $crid; ?>" id="crid" />
			</td>
		</tr>
	<?php endif; ?>
</table>

<br />


<div style="float:left;width:50%;" >
<form method="POST" >
<table id="tblExport" class="gis-table-bordered table-fx table-altrow" >
<tr><th>#</th>
<th>Scid</th>
<th>ID No.</th>
<th>Student</th>
<th class="center" >Present<br /><?php echo $attdmos[$qvsum]; ?><br />
	<input class="center vc50" type="text" id="ipresent" /><br />	
	<input type="button" value="All" onclick="populateColumn('present');" >						
</th>
<th class="center" >Tardy<br /><br />
	<input class="center vc50" type="text" id="itardy" /><br />	
	<input type="button" value="All" onclick="populateColumn('tardy');" >						
</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td id="<?php echo $rows[$i]['scid']; ?>"  >
		<a href="<?php echo URL.'attendance/studentQtr/'.$rows[$i]['scid']; ?>" >
			<?php echo $rows[$i]['student']; ?></a></td>
	<td><input name="posts[<?php echo $i; ?>][present]" value="<?php echo $rows[$i]['present']; ?>" tabindex="2"
		class="vc50 center present" id="present<?php echo $i; ?>" /></td>
	<td><input name="posts[<?php echo $i; ?>][tardy]" value="<?php echo $rows[$i]['tardy']; ?>" tabindex="4"
		class="vc50 center tardy"  id="tardy<?php echo $i; ?>" /></td>

	<input type="hidden" name="posts[<?php echo $i; ?>][oldpre]" value="<?php echo $rows[$i]['present']; ?>" />
	<input type="hidden" name="posts[<?php echo $i; ?>][oldtar]" value="<?php echo $rows[$i]['tardy']; ?>" />
	<input type="hidden" name="posts[<?php echo $i; ?>][attid]" value="<?php echo $rows[$i]['attid']; ?>" />
		
</tr>




<?php endfor; ?>
</table>
<br />

<?php if(!isset($_GET['view'])): ?>
	<p>
	<?php if(!$is_locked): ?>		
		<input type="submit" name="save" value="Save" onclick="return confirm('Sure?');" />
		<input type="submit" name="save" value="Finalize" onclick="return confirm('Sure?');" />
	<?php endif; ?>	

	<?php if(($is_locked) && ($_SESSION['srid']==RMIS)): ?>		
		<input type="submit" name="save" value="Save On" onclick="return confirm('Sure?');" />
	<?php endif; ?>	
	</p>
<?php endif; ?>	<!-- not view -->


</form>
</div>

<div style="float:left;width:30%;" >
<p class="smartboard" >
<select id="classbox" >
	<option value="present" >Present</option>
	<option value="tardy" >Tardy</option>
</select>
</p>

<?php $d['width'] = '25'; ?>
<?php $this->shovel('smartboard',$d); ?>
</div>

<div class="clear ht100" ></div>



<script>

var hdpass 	= '<?php echo HDPASS; ?>';

$(function(){
	hd();
	excel();
	selectFocused();
	nextViaEnter();
	itago('smartboard');
	$('#hdpdiv').hide();
	
	
})

</script>

<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>
