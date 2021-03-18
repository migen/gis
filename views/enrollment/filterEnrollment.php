<?php 


// pr($_SESSION['q1']);

// pr($q);
$dbg=PDBG;
$dbtable="{$dbg}.05_classrooms";

?>

<h3>

	Enrollment Filter (<?php echo $count; ?>) | <?php $this->shovel('homelinks'); ?>	
	| <span onclick="traceshd();" >SHD</span>
	<?php $this->shovel('links_enrollment'); ?>

</h3>

<h4 id="feedback" ></h4>

<?php $incs="filter_sectioning.php";include_once($incs); ?>

<?php if(isset($_GET['submit'])): ?>
	<table class="gis-table-bordered" >
	<tr>
		<th>#</th>
		<th>scid</th>
		<th>name</th>
		<th class="shd" >sy</th>
		<th class="shd" >actv</th>
		<th class="shd" >summ<br />scid-crid</th>
		<th class="shd" >en<br />scid-crid</th>
		<th class="" >classroom</th>		
		<th class="vc60" >crid</th>		
		<th>Save</th>
	</tr>
	<?php for($i=0;$i<$count;$i++): ?>
	<tr>
		<td><?php echo $i+1; ?></td>
		<td id="scid-<?php echo $i; ?>" ><?php echo $rows[$i]['scid']; ?></td>
		<td id="name-<?php echo $i; ?>" ><?php echo $rows[$i]['name']; ?></td>
		<td class="shd" ><?php echo $rows[$i]['sy']; ?></td> 		
		<td class="shd" ><?php echo ($rows[$i]['is_active']!=1)? "-":NULL; ?></td> 		
		<td class="shd" ><?php echo $rows[$i]['summscid'].'-'.$rows[$i]['summcrid']; ?></td> 		
		<td class="shd" ><?php echo $rows[$i]['enscid'].'-'.$rows[$i]['encrid']; ?></td> 		

	<td>
		<?php $substr_name = substr($rows[$i]['classroom'],0,12); ?>	
		<input class="vc200 pdl05" id="part-<?php echo $i; ?>" value="<?php echo $substr_name; ?>" />		
		<input type="submit" name="auto" value="Filter" onclick="xgetDataByPartRow(<?php echo $i; ?>);return false;" />
	</td>
	<td><input id="crid-<?php echo $i; ?>" class="crid pdl05 full" name="posts[<?php echo $i; ?>][crid]" 
			value="<?php echo $rows[$i]['summcrid']; ?>"  /></td>		
		
		<td><span onclick="axnRow(<?php echo $i; ?>);" >Save</span></td>
	</tr>
	<?php endfor; ?>
	</table>
<?php endif; ?>	<!-- get -->

<div class="shd" id="names" >names</div>

<div class="ht100" ></div>

<script>
var gurl="http://<?php echo GURL; ?>";
var dbtable="<?php echo $dbtable; ?>";
var sy="<?php echo $sy; ?>";
var limits=10;

$(function(){
	shd();
	$('html').live('click',function(){ $('#names').hide(); });

})

function axnRow(i){
	var crid=$('input[name="posts['+i+'][crid]"]').val();	
	var name=$('#name-'+i).text();
	var scid=$('#scid-'+i).text();
	// alert("row: "+i+", scid: "+scid+", crid: "+crid);

	var vurl = gurl+'/ajax/xenrollment.php';			
	var task = "xenrollStudent";		
	var pdata="task="+task+"&sy="+sy+"&scid="+scid+"&crid="+crid;
	// alert(pdata);
	
	$.ajax({
		url:vurl,type:"POST",data:pdata,
		success: function() { 
			$('#feedback').text(name); 
		}		  
	});						
	
}	/* fxn */

function axnFilter(id,i){
	$('input[name="posts['+i+'][crid]"]').val(id);
	
}	/* fxn */


</script>


<script type="text/javascript" src='<?php echo URL."views/js/data.js"; ?>' ></script>

