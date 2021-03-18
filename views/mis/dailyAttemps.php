
<?php 

$home = 'mis';
// pr($data);
// pr($home);
// pr($role_id);
// pr($emps[0]);



// pr($_SERVER); for home link,used by registrar and teacher
$parts = rtrim($_GET['url'],'/'); 
$parts = explode('/',$parts);		
$home = ($c = array_shift($parts))? $c : 'index'; 			

?>



<h5>
	Daily Attendance Employee Logs
	| <?php $this->shovel('homelinks',$home); ?>
	
</h5>



<!-------------------------------------------------------------------------------------->

<p class="screen"  >
	<a class="button" id="btnExport" style="font-size:14px;" >Excel</a> &nbsp; 
</p>

<!-- page info -->
<p><table class='gis-table-bordered table-fx'>
	<tr><th class='white headrow'>Date</th><td><?php echo date('M-d,Y,l',strtotime($date)); ?></td></tr>
	<tr><th class='white headrow'>Other</th>
		<?php $today = date('Y-m-d'); ?>
		<td><input id="dailyAttemps" class="pdl05 " type="text" value="<?php echo $today; ?>" > 
			<span onclick="redirDailyAttemps(<?php echo $role_id; ?>);" class="button"  >Go</span>
		</td>
	</tr>

</table></p>




<!-------------------------------------------------------------------------------------->


<table id="tblExport" class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th>#</th>
	<th class="" >CID</th>
	<th class="vc300" >Employee</th>
	<th class="vc120" >Timein</th>
	<th class="vc120" >Timeout</th>
</tr>

<?php for($i=0;$i<$num_attendances;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $attendances[$i]['cid']; ?></td>
	<td><?php echo $attendances[$i]['employee']; ?></td>
	<td><?php echo $attendances[$i]['timein']; ?></td>
	<td><?php echo $attendances[$i]['timeout']; ?></td>
</tr>
<?php endfor; ?>


</table>

<!--------------------------------------------------------------------------------->

<?php 

// pr($data);




?>



<!------------------------------------------------------------------------->
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>


<!------------------------------------------------------------------------------>
<script>

	var gurl = 'http://<?php echo GURL; ?>';	var sy   = '<?php echo $sy; ?>';
	var home 	= '<?php echo $home; ?>';


	$(function(){	
		$(".juice").datepicker({
			dateFormat:"yy-mm-dd"
		});
		
		excel();

		
	});

	
	function excel(){
		$("#btnExport").click(function () {
			$("#tblExport").btechco_excelexport({
				containerid: "tblExport"
			   ,datatype: $datatype.Table
			});
		});

	}
	
	function redirDailyAttemps(roleid){
		var day  = $('#dailyAttemps').val();
		
				
		var rurl 	= gurl + '/'+home+'/dailyAttemps/'+roleid+'/'+day;		// redirect url	
		// alert(rurl);
		window.location = rurl;		
	}


	
	
</script>	






