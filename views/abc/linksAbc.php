<?php 

// pr($data);
// $bs=2015;
// pr($_SESSION['q']);
$dbo=PDBO;
$dbcontacts="{$dbo}.00_contacts";


?>


<h5>
	Student Links | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'students/filter'; ?>">Filter</a>
	<?php if($scid): ?>
		| <a href='<?php echo URL."students/edit/$scid"; ?>'>Edit</a>
	<?php endif; ?>
	

<?php 
	$d['sy']=$sy;$d['repage']="students/links/$scid";
	$this->shovel('sy_selector',$d); 
?>	

	
</h5>

<?php if($scid): ?>
	<table class="gis-table-bordered" >
		<tr>
			<td><?php echo $row['id']; ?></td>
			<td><?php echo $row['code']; ?></td>
			<td><?php echo $row['name']; ?></td>	
			<td><?php echo $row['classroom']; ?> | #<?php echo $row['crid']; ?></td>	
		</tr>
	</table>
<?php endif; ?>

<p><table id="tbl-1" class="gis-table-bordered " >
	<tr>
		<th>ID</th>
		<td>
		<input class="pdl05" id="part" autofocus placeholder="name" />
		<input type="submit" name="auto" value="Students" onclick='getDataByTable(dbcontacts,20);return false;' />		
	</td></tr>
	
</table></p><div id="names" >names</div>


<?php if($scid): ?>
	<h4>Student</h4>
	<table class="gis-table-bordered" >
		<tr><td><a href="<?php echo URL.'students/edit/'.$scid; ?>" >Edit SY</a></td></tr>
		<tr><td class="vc200" ><a href='<?php echo URL."rcards/scid/$scid"; ?>' >Rpt Card</a>
			<?php for($is=$csy;$is<DBYR;$is++): ?>
				| <a href='<?php echo URL."rcards/scid/$scid/$is/4"; ?>' ><?php echo $is; ?></a>
			<?php endfor; ?>
		</td></tr>
		<tr><td><a href='<?php echo URL."codename/one/$scid"; ?>' >Code Name</a></td></tr>
		<tr><td><a href='<?php echo URL."clearance/one/$scid"; ?>' >Clearance</a></td></tr>
	</table>

<?php endif; ?>


<div class="clear ht50" ></div>





<script>
var gurl = "http://<?php echo GURL; ?>";
var dbcontacts = "<?php echo $dbcontacts; ?>";
var limit=20;


$(function(){
	$('#names').hide();
	$('html').live('click',function(){ $('#names').hide(); });
	
})

function axnFilter(id){
	var url = gurl+'/students/links/'+id;	
	window.location = url;		
}




</script>

<script type="text/javascript" src='<?php echo URL."views/js/axjs.js"; ?>' ></script>
