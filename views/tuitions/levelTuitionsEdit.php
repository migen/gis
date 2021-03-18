<h3>
	Edit Level Tuition Fees | <?php $this->shovel('homelinks'); ?>
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
	
</h3>

<?php 

// pr($_SESSION['q']);
// pr($level);
// pr($data);
// pr($rows[10]);
// debug($rows[0]);
$dbg=VCPREFIX.$sy.US.DBG;
$dbo=PDBO;
$dbtable="{$dbo}.03_tfeedetails";
$dbfeetypes="{$dbo}.03_feetypes";




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
	<th>Amount</th>
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
	<th class="shd" >Delete</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<?php $total+=$rows[$i]['amount']; ?>
<?php $pkid=$rows[$i]['pkid']; ?>

<tr>
	<td><?php echo $i+1; ?></td>
	<td><input readonly class="vc50" name="posts[<?php echo $i; ?>][id]" value="<?php echo $rows[$i]['pkid']; ?>" ></td>
	<td><?php echo $rows[$i]['num']; ?></td>
	<td><?php echo $rows[$i]['feetype']; ?></td>
	<td><?php echo $rows[$i]['parent_id']; ?></td>
	<td><input class="vc50" name="posts[<?php echo $i; ?>][is_displayed]" value="<?php echo $rows[$i]['is_displayed']; ?>" ></td>
	<td><input name="posts[<?php echo $i; ?>][amount]" value="<?php echo $rows[$i]['amount']; ?>" ></td>
	<td><input class="vc50 indent" name="posts[<?php echo $i; ?>][indent]" value="<?php echo $rows[$i]['indent']; ?>" ></td>
	<td><input class="vc50 position" name="posts[<?php echo $i; ?>][position]" value="<?php echo $rows[$i]['position']; ?>" ></td>
	<td><input class="vc50 hideamt" name="posts[<?php echo $i; ?>][amount_hidden]" value="<?php echo $rows[$i]['amount_hidden']; ?>" ></td>
	<td><input class="vc50" name="posts[<?php echo $i; ?>][in_total]" value="<?php echo $rows[$i]['in_total']; ?>" ></td>
	<td class="shd" ><button onclick='xdelRow("<?php echo $pkid; ?>")' >Delete</button></td>
	
</tr>
<?php endfor; ?>
<tr>
	<th colspan=6>Total</th>
	<th class="" ><?php echo number_format($total,2); ?></th>
	<th class="shd" ></th>
	<th class="shd" ></th>
</tr>

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
</table>

<br /><p><input type="submit" name="submit" value="Save" ></p>

</form>

<div id="names" ></div>
<div class="ht50" ></div>


<script>

var gurl="http://<?php echo GURL; ?>";
var sy="<?php echo $sy; ?>";
var lvl="<?php echo $lvl; ?>";
var num="<?php echo $num; ?>";
var dbtable="<?php echo $dbtable; ?>";
var dbfeetypes="<?php echo $dbfeetypes; ?>";
var limit="20";

$(function(){
	// shd();

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
	if (confirm('DANGEROUS! Sure?')){
		var vurl = gurl+'/ajax/xdata.php';	
		var task = "xdeleteData";	
		var pdata='task='+task+'&id='+id+'&dbtable='+dbtable;
		
		$.ajax({
			url:vurl,dataType:"json",type:"POST",
			data:pdata,async:true,
			success: function() {  location.reload(); }		  
		});									
	}
	
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





</script>


<script type="text/javascript" src='<?php echo URL."views/js/axjs.js"; ?>' ></script>
