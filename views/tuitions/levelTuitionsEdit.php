<h3>
	Edit Level Tuition Fees SY<?php echo $sy; ?> | <?php $this->shovel('homelinks'); ?>
	| <a href='<?php echo URL."tuitions/table/$sy"; ?>' >Table</a>
	<?php if(!isset($_GET['edit'])): ?>
		| <a href='<?php echo URL."tuitions/edit/$lvl/$sy"; ?>' >Edit</a>	
	<?php else: ?>
		| <a href='<?php echo URL."tuitions/level/$lvl/$sy"; ?>' >Cancel</a>	
	<?php endif; ?>
	| <span onclick="traceshd();" >Add</span>
<?php if($lvl>13): ?>	
	| <span>&num= (SHAG)</span>
<?php endif; ?>	

	| <a href="<?php echo URL.'tfeetypes/table'; ?>">Fees</a>


	
</h3>

<?php 

// $isPrevsy 

// pr($_SESSION['q']);
// pr($level);
// pr($data);
// pr($rows[10]);
// debug($rows[0]);
$dbg=VCPREFIX.$sy.US.DBG;
$dbo=PDBO;
$dbtable="{$dbo}.03_tfeedetails";
$dbfeetypes="{$dbo}.03_feetypes";
$dbtuitions="{$dbo}.03_tuitions";


$headrow="<tr><th>#</th><th>ID</th><th>Num</th><th>Fee</th><th>Prnt</th><th>Disp</th><th class='right'>Amount</th><th>Indent</th><th>Position</th>";
$headrow.="<th>Hide<br>Amount</th><th>In<br>Total</th><th>Actions</th></tr>";

$tuition_total=$level['total'];
$tuition_id=$level['tuition_id'];
// pr($total);
// prx($data);


?>



<table class="gis-table-bordered" >
	<tr><th>Level
		<?php echo ($num>1)? '-Num':NULL; ?>
	</th><td><?php echo $level['name'].' #'.$level['id']; ?>
		<?php echo ($num>1)? "-{$num}":NULL; ?>
	</td>
	<th>Assessed</th><th><?php echo number_format($level['amount'],2); ?></th>
	</tr>
</table><br />


<?php foreach($levels AS $sel): ?>
	<a href="<?php echo URL.'tuitions/level/'.$sel['id'].DS.$sy.'&edit'; ?>" ><?php echo $sel['code']; ?></a> | 
<?php endforeach; ?>
<br />
<br />


<form method="POST" >
<?php $total=0; ?>
<?php $total_tuition=0; ?>
<?php $total_nontuition=0; ?>
<table class="gis-table-bordered table-altrow table-fx" >
<tr>
	<th>#
	<input type="hidden" name="tf[id]" value="<?php echo $level['pkid']; ?>" >

	</th>
	<th>Key</th>
	<th>Num</th>
	<th>Fee</th>
	<th>Prnt</th>
	<th>Disp</th>
	<th class='right'>Amount</th>
	<th>Indent<br />
		<input class="pdl05 vc50" id="iindent" /><br />	
		<input type="button" value="All" onclick="populateColumn('indent');" >								
	</th>
	<th>Position<br />
		<input class="pdl05 vc50" id="iposition" /><br />	
		<input type="button" value="All" onclick="populateColumn('position');" >								
	</th>
	<th>Hide<br />Amount<br />
		<input class="pdl05 vc50" id="ihideamt" /><br />	
		<input type="button" value="All" onclick="populateColumn('hideamt');" >								
	</th>	
	<th>In<br />Total</th>
	<th class="shd" >Actions</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<?php $total+=$rows[$i]['amount']; ?>
<?php $total_tuition+=($rows[$i]['in_total'])? $rows[$i]['amount']:0; ?>
<?php $total_nontuition+=(!$rows[$i]['in_total'])? $rows[$i]['amount']:0; ?>

<?php // if($rows[$i]['is_active'] && $rows[$i]['in_total']){ $total_active_tuition+=$rows[$i]['amount']; ?>


<?php $pkid=$rows[$i]['pkid']; ?>

<?php 
	if($i%12==0){ echo $headrow;}

?>


<tr>
	<td><?php echo $i+1; ?></td>
	<td><input readonly class="vc50" name="posts[<?php echo $i; ?>][id]" value="<?php echo $rows[$i]['pkid']; ?>" ></td>
	<td><?php echo $rows[$i]['num']; ?></td>
	<td><?php echo $rows[$i]['feetype']; ?></td>
	<td><?php echo $rows[$i]['parent_id']; ?></td>
	<td><input id="disp-<?php echo $i; ?>" tabIndex=4 class="vc50" name="posts[<?php echo $i; ?>][is_displayed]" value="<?php echo $rows[$i]['is_displayed']; ?>" ></td>
	<td>
		<input type="hidden" id="oldamount-<?php echo $i; ?>" readonly 
			class="right" tabIndex=6 value="<?php echo $rows[$i]['amount']; ?>" >
		<input id="amount-<?php echo $i; ?>" class="right" tabIndex=6 name="posts[<?php echo $i; ?>][amount]" value="<?php echo $rows[$i]['amount']; ?>" >	
	</td>
	<td><input id="indent-<?php echo $i; ?>" tabIndex=8 class="vc50 indent" name="posts[<?php echo $i; ?>][indent]" value="<?php echo $rows[$i]['indent']; ?>" ></td>
	<td><input id="pos-<?php echo $i; ?>" tabIndex=10 class="vc50 position" name="posts[<?php echo $i; ?>][position]" value="<?php echo $rows[$i]['position']; ?>" ></td>
	<td><input id="amthidden-<?php echo $i; ?>" tabIndex=12 class="vc50 hideamt" name="posts[<?php echo $i; ?>][amount_hidden]" value="<?php echo $rows[$i]['amount_hidden']; ?>" ></td>
	<td><input id="intotal-<?php echo $i; ?>" tabIndex=14 class="vc50" type="number" min=0 max=1
		name="posts[<?php echo $i; ?>][in_total]" value="<?php echo $rows[$i]['in_total']; ?>" ></td>
	<td class="shd" >
		<?php if($is_current): ?>
			<button id="btn-<?php echo $i; ?>" 
				onclick="xeditRow(<?php echo $i.','.$pkid; ?>);return false;" >Save</button>	
			<button onclick='xdelRow("<?php echo $pkid; ?>")' >Delete</button>
		<?php endif; ?>
	</td>
	
</tr>
<?php endfor; ?>

<tr>
	<th colspan=6>Total Tuition</th>
	<th class="right" ><?php echo number_format($total_tuition,2); ?></th>
	<th colspan=5 class="shd" ></th>
</tr>

<tr>
	<th colspan=6>Total Non-Tuition</th>
	<th class="right" ><?php echo number_format($total_nontuition,2); ?></th>
	<th colspan=5 class="shd" ></th>
</tr>

<tr>
	<th colspan=6>Total</th>
	<th class="right" ><?php echo number_format($total,2); ?></th>
	<th colspan=5 class="shd" ></th>
</tr>

<?php if($is_current): ?>
	<tr class="shd" >
		<td><?php echo $i+1; ?></td>
		<td></td>
		<td><input value="<?php echo $num; ?>" class="vc50" id="num" readonly ></td>
		
		<td>
			<input class="pdl05" id="part" autofocus  />
			<input type="submit" name="auto" value="Filter" onclick="ajaxFilter(dbfeetypes);return false;" />		
			<input id="feetype_id" class="vc50" />					
		</td>
		<td></td>
		<td><input class="vc50" id="is_displayed" ></td>
		<td><input id="amount" ></td>
		<td><input class="vc50" id="indent" value="0" ></td>
		<td><input class="vc50" id="position" value="10" ></td>
		<td><input class="vc50" id="amount_hidden" value="0" ></td>
		<td><input class="vc50" id="in_total" ></td>
		<td><button onclick='xaddRow("<?php echo $dbtable; ?>");' >Add</button></td>	
	</tr>
<?php endif; ?>
	</table>



<?php if($is_current): ?>	
	<br /><p><input type="submit" name="submit" value="Save" ></p>
<?php endif; ?>

</form>

<div id="names" ></div>
<div class="ht100 clear" ></div>


<script>

var gurl="http://<?php echo GURL; ?>";
var sy="<?php echo $sy; ?>";
var lvl="<?php echo $lvl; ?>";
var tuition_total="<?php echo $tuition_total; ?>";
var tuition_id="<?php echo $tuition_id; ?>";
var num="<?php echo $num; ?>";
var dbtable="<?php echo $dbtable; ?>";
var dbfeetypes="<?php echo $dbfeetypes; ?>";
var dbtuitions="<?php echo $dbtuitions; ?>";
var limit="20";

$(function(){
	selectFocused();
	nextViaEnter();
	// alert(dbtable);

})


function xaddRow(dbtable){
	var feetype_id = $('#feetype_id').val();	
	var num = $('#num').val();	
	var amount = $('#amount').val();	
	var is_displayed = $('#is_displayed').val();	
	var in_total = $('#in_total').val();	
	
	var vurl = gurl+'/ajax/xdata.php';	
	var task = "xsaveData";	
	var pdata='task='+task+'&feetype_id='+feetype_id+'&amount='+amount+'&dbtable='+dbtable;
	pdata+='&sy='+sy+'&level_id='+lvl+'&is_displayed='+is_displayed+'&num='+num;
	
	
	$.ajax({
		url:vurl,dataType:"json",type:"POST",
		data:pdata,async:true,
		success: function() {  location.reload(); }		  
    });					
}	/* fxn */


function xdelRow(id){
	// if (confirm('DANGEROUS! Sure?')){
		var vurl = gurl+'/ajax/xdata.php';	
		var task = "xdeleteData";	
		var pdata='task='+task+'&id='+id+'&dbtable='+dbtable;
		
		$.ajax({
			url:vurl,dataType:"json",type:"POST",
			data:pdata,async:true,
			success: function() {  location.reload(); }		  
		});									
	// }
	
}	/* fxn */


function axnFilter(id){
	$("#feetype_id").val(id);
		
}	/* fxn */


function ajaxFilter(dbtable){
	
	var part=$("#part").val();
	var vurl = gurl+'/ajax/xdata.php';	
	var task="xgetData";	
	var pdata="task="+task+"&part="+part+"&limit="+limit+"&dbtable="+dbtable;
	// alert(pdata);
	
	$.ajax({
		url:vurl,dataType:"json",type:"POST",async:true,
		data: pdata,
		success: function(s) { 
			var cs=s.length;
			content='';
			$('#names').html('<h4 class="txt-blue u" onclick="closeFilter();return false;" >Close (X) </h4>');
			if(!s) { content += '<h2 class="red" >No record found!</h2>'; }
for (var i = 0; i < cs; i++) {			
	content+='<p><span class="txt-blue b u" onclick="axnFilter('+s[i].id+');return false;" >'+s[i].name+'</span></p>';
}
			$('#names').append(content).show();content = '';

		}	
	})


}	/* fxn */


function xeditRow(i,pkid){	
	$('#btn-'+i).hide();		
	var disp = $('#disp-'+i).val();
	var pos = $('#pos-'+i).val();
	var amount = $('#amount-'+i).val();
	var oldamount = $('#oldamount-'+i).val();
	var indent = $('#indent-'+i).val();
	var amthidden = $('#amthidden-'+i).val();
	var intotal = $('#intotal-'+i).val();
	
	if(intotal==1){
		tuition_total = parseFloat(tuition_total)-parseFloat(oldamount)+parseFloat(amount);
	} 


	var vurl = gurl+'/ajax/xdata.php';	
	var task="xeditData";
	var pdata="task="+task+"&dbtable="+dbtable+"&id="+pkid+"&is_displayed="+disp+"&position="+pos+"&amount="+amount+"&indent="+indent;
	pdata+="&amount_hidden="+amthidden+"&in_total="+intotal;
		
	$.ajax({type: 'POST',url: vurl,data: pdata,success:function(){ 
		if(intotal==1){
			xeditTuitionTotal(tuition_total);					
		}
	}  });					
	
}	/* fxn */


function xeditTuitionTotal(tuition_total){
	var vurl = gurl+'/ajax/xdata.php';	
	var task="xeditData";
	var pdata="task="+task+"&dbtable="+dbtuitions+"&id="+tuition_id+"&total="+tuition_total;		
	$.ajax({type: 'POST',url: vurl,data: pdata,success:function(){ }  });					
	
}	/* fxn */


	



</script>


<script type="text/javascript" src='<?php echo URL."views/js/axjs.js"; ?>' ></script>
