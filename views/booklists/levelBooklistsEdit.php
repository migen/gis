<h3>
	<?php echo $level['name']; ?> Books SY<?php echo $sy; ?>
	| <?php $this->shovel('homelinks'); ?>
	<?php include('linksBooklists.php'); ?>
	| <a href="<?php echo URL.'booklists/level/'.$lvl.'?num='.$num; ?>" >Cancel</a>

	<?php ?>
		| Num <input type="number" value="<?php echo $num; ?>" min=1 max=5 
			onchange='jsredirect("booklists/level/<?php echo $lvl; ?>?num="+this.value+"&edit");'  >
	<?php ?>


</h3>

<?php 
	
	// prx($rows[0]);
	
	// pr($_SESSION['q']);
	
	$dbsubjects="{$dbo}.05_subjects";
	$dbbooks="{$dbg}.05_books";
	$dblvlbooks="{$dbg}.05_level_books";
	// pr($lvl);
	// pr($dbbooks);
	
?>

<form method="POST" >
<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th>ID</th>
	<th>Subject</th>
	<th>Sem</th>
	<th>Code</th>
	<th>Name</th>
	<th>Company</th>
	<th class="right" >Amount</th>
	<th></th>	
</tr>
<?php $total=0; ?>
<?php for($i=0;$i<$count;$i++): ?>
<?php $total+=$rows[$i]['amount']; ?>
<?php $book_id=$rows[$i]['book_id']; ?>
<?php $lbid=$rows[$i]['lbid']; ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['id']; ?></td>
	<td><?php echo $rows[$i]['subjname']; ?></td>
	<td><input id="sem-<?php echo $i; ?>" tabIndex=2 class="vc50" name="books[<?php echo $i; ?>][sem]" 
		value="<?php echo $rows[$i]['semester']; ?>" ></td>	
	<td><input id="code-<?php echo $i; ?>" tabIndex=4 class="vc100" name="books[<?php echo $i; ?>][code]" 
		value="<?php echo $rows[$i]['code']; ?>" ></td>		
	<td><input id="name-<?php echo $i; ?>" tabIndex=6 class="vc300" name="books[<?php echo $i; ?>][name]" 
		value="<?php echo $rows[$i]['name']; ?>" ></td>
	<td><input id="company-<?php echo $i; ?>" tabIndex=8 class="" name="books[<?php echo $i; ?>][company]" 
		value="<?php echo $rows[$i]['company']; ?>" ></td>	
	<td>
		<input id="amount-<?php echo $i; ?>" tabIndex=12 class="vc100 right" name="books[<?php echo $i; ?>][amount]" 
			value="<?php echo $rows[$i]['amount']; ?>" >
		<input id="book_id-<?php echo $i; ?>" type="hidden" class="" name="books[<?php echo $i; ?>][id]" 
			value="<?php echo $rows[$i]['book_id']; ?>" >		
	</td>	
	<td class="" >
		<?php if($is_current): ?>
			<button id="btn-<?php echo $i; ?>" 
				onclick="xeditRow(<?php echo $i.','.$book_id; ?>);return false;" >Save</button>	
			<button onclick='xdelRow("<?php echo $lbid; ?>")' >Delete</button>
		<?php endif; ?>
	</td>


</tr>
<?php endfor; ?>
<tr>
	<th colspan=7>Total</th>
	<th class="right" ><?php echo number_format($total,2); ?></th>
	<th></th>
</tr>


<?php if($is_current): ?>
	<tr class="" >
		<td><?php echo $i+1; ?></td>
		<td></td>
		
		<td>
			<input class="pdl05" id="part" autofocus  />
			<input type="submit" name="auto" value="Filter" onclick="ajaxFilter(dbsubjects);return false;" />		
			<input id="subject_id" class="vc50" />					
		</td>
		<td><input value="1" class="vc50" id="sem" readonly ></td>
		<td><input class="vc100" id="code" ></td>
		<td><input class="vc300" id="name" ></td>
		<td><input class="" id="company" ></td>
		<td><input class="" id="amount" ></td>
		<td><button onclick='xaddRow("<?php echo $dbsubjects; ?>");' >Add</button></td>	
	</tr>
<?php endif; ?>

</table>
</form>

<div id="names" ></div>
<div class="ht100 clear" ></div>



<script>

var gurl="http://<?php echo GURL; ?>";
var sy="<?php echo $sy; ?>";

var lvl="<?php echo $lvl; ?>";
var num="<?php echo $num; ?>";
var dbsubjects="<?php echo $dbsubjects; ?>";
var dbbooks="<?php echo $dbbooks; ?>";
var dblvlbooks="<?php echo $dblvlbooks; ?>";
var limit="20";

$(function(){
	selectFocused();
	nextViaEnter();
	// alert(dblvlbooks);

})



function axnFilter(id){
	$("#subject_id").val(id);
		
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


function xaddRow(dbtable){
	var subject_id = $('#subject_id').val();	
	var sem = $('#sem').val();	
	var code = $('#code').val();	
	var name = $('#name').val();	
	var company = $('#company').val();	
	var amount = $('#amount').val();	
	
	var vurl = gurl+'/ajax/xbooklists.php';	
	var task = "xaddBooklist";	
	var pdata='task='+task+'&dbbooks='+dbbooks+'&dblvlbooks='+dblvlbooks+'&subject_id='+subject_id+'&code='+code;
	pdata+='&name='+name+'&company='+company+'&amount='+amount+'&semester='+sem+'&lb[level_id]='+lvl+'&lb[num]='+num;
	
	
	$.ajax({
		url:vurl,dataType:"json",type:"POST",
		data:pdata,async:true,
		success: function() {  }		  
    });	

	
}	/* fxn */



function xdelRow(id){
	if (confirm('DANGEROUS! Sure?')){
		var vurl = gurl+'/ajax/xdata.php';	
		var task = "xdeleteData";	
		var pdata='task='+task+'&id='+id+'&dbtable='+dblvlbooks;
		
		$.ajax({
			url:vurl,dataType:"json",type:"POST",
			data:pdata,async:true,
			success: function() {  location.reload(); }		  
		});									
	}
	
}	/* fxn */



function xeditRow(i,book_id){	
	$('#btn-'+i).hide();		

	var sem = $('#sem-'+i).val();
	var code = $('#code-'+i).val();
	var name = $('#name-'+i).val();
	var company = $('#company-'+i).val();
	var amount = $('#amount-'+i).val();
	

	var vurl = gurl+'/ajax/xdata.php';	
	var task="xeditData";
	var pdata="task="+task+"&dbtable="+dbbooks+"&id="+book_id+"&semester="+sem+"&code="+code+"&name="+name;
	pdata+="&amount="+amount+"&company="+company;
		

	// alert(pdata);
	$.ajax({type: 'POST',url: vurl,data: pdata,success:function(){ } });
	
	
}	/* fxn */




	



</script>


<script type="text/javascript" src='<?php echo URL."views/js/axjs.js"; ?>' ></script>
