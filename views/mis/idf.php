<?php 

pr($_SESSION['q']);

?>

<h5>
	ID Finder / Filter
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
	
	
</h5>



<table class="gis-table-bordered table-fx" >
<tr>
<th>Contact</th><td>
	<select name="ucid" >
		<?php foreach($contacts AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name'].' #'.$sel['id'].' pcid#'.$sel['parent_id']; ?></option>
		<?php endforeach; ?>
	</select>
</td>
</tr>

</table>


<hr />

<table class="gis-table-bordered table-fx" >
<?php foreach($tables AS $table): ?>
<tr>
<th><?php echo ucfirst($table); ?></th><td>
	<select name="<?php echo $table.'_id'; ?>" >
		<?php foreach($$table AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name'].' #'.$sel['id']; ?></option>
		<?php endforeach; ?>
	</select>
</td>
</tr>

<?php endforeach; ?>
</table>


<hr />

<?php 
	$lookups = array(
		'dbone_'.VCFOLDER.'.contacts' => 'Contacts',
		DBYR.'_dbmaster_'.VCFOLDER.'.03_feetypes' => 'Fee types',
		DBYR.'_dbmaster_'.VCFOLDER.'.03_prodtypes' => 'Product types',
		DBYR.'_dbmaster_'.VCFOLDER.'.prodsubtypes' => 'Product Subtypes',
		DBYR.'_dbmaster_'.VCFOLDER.'.03_products' => 'Products',
		DBYR.'_dbmaster_'.VCFOLDER.'.levels' => 'Levels',
		DBYR.'_dbmaster_'.VCFOLDER.'.sections' => 'Sections',
		DBYR.'_dbmaster_'.VCFOLDER.'.05_classrooms' => 'Classrooms',
		DBYR.'_dbmaster_'.VCFOLDER.'.courses' => 'Courses',
		DBYR.'_dbmaster_'.VCFOLDER.'.criteria' => 'Criteria',
		DBYR.'_dbmaster_'.VCFOLDER.'.subjects' => 'Subjects',
		'dbone_'.VCFOLDER.'.`00_titles`' => 'Titles',
		'dbone_'.VCFOLDER.'.`00_roles`' => 'Roles',
		'dbone_'.VCFOLDER.'.`00_actions`' => 'Actions',				
	);
	// pr($lookups);

?>


<p><table id="tbl-1" class="gis-table-bordered " >
	<tr class="headrow" ><th colspan="2" >Lookups Filter</th></tr>
	<tr><th class="bg-gray3" >
		<select id="lookup" >
			<?php foreach($lookups AS $k=>$v): ?>
				<option value="<?php echo $k; ?>" ><?php echo $v; ?></option>	
			<?php endforeach; ?>
		</select>
	</th><td>
	<input class="pdl05" id="part" autofocus  />
	<input type="submit" name="auto" value="Filter" onclick="xgetNamesByPart();return false;" />
	</td></tr>
	
	<tr><th class="bg-gray3" >ID No.</th><td>
	<input class="pdl05" id="idno"  />
	<input type="submit" name="auto" value="Find" onclick="xgetNameById();return false;" />
	</td></tr>	
	
</table></p>

<div class="hd" id="names" >names</div>

<!---------------------------------------------------------------->

<script>
var gurl = 'http://<?php echo GURL; ?>';

$(function(){
	hd();
	$('html').live('click',function(){
		$('#names').hide();
	});
	
})



function redirLookup(ucid){
	var url = gurl + '/students/sectioner/' + ucid;	
	// alert(url);
	// window.location = url;		
}



</script>




<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>

