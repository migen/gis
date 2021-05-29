<?php 
	// pr($_SESSION['q']);
	$dbo=PDBO;
	$dbg=VCPREFIX.$sy.US.DBG;
	$dbclassrooms="{$dbg}.05_classrooms";
	
	// pr($data);

?>
<h3>
<?php 
if($cr){ extract($cr); }
?>
	Schedules <?php echo ($crid)? '#'.$crid.' - '.$crcode.' - '.$crname:NULL; ?> <?php echo "SY{$sy}"; ?>
	| <?php $this->shovel('homelinks'); ?>
	<?php if($crid AND $sy_enrollment>$sy): ?>
		| <a href="<?php echo URL.'schedules/classroom/'.$crid.DS.$sy_enrollment; ?>" ><?php echo $sy_enrollment; ?></a>
	<?php endif; ?>
	| <a href="<?php echo URL.'schedules/rcards?lvl='.$lvl; ?>" >Rcards</a>
	| <a href="<?php echo URL.'schedules/ensteps?lvl='.$lvl; ?>" >Ensteps</a>
	| <a href="<?php echo URL.'schedules/tuitions?lvl='.$lvl; ?>" >Tuitions</a>
	| <a href="<?php echo URL.'schedules/booklists?lvl='.$lvl; ?>" >Booklists</a>


</h3>


<p><table id="tbl-1" class="gis-table-bordered " >
	<tr>
		<th>ID</th>
		<td>
		<input class="pdl05" id="part" autofocus placeholder="name" />
		<input type="submit" name="auto" value="Classrooms" onclick='getDataByTable(dbclassrooms,30);return false;' />
		
	</td></tr>
	
</table></p>

<div id="names" >names</div>



<table class="data accordion gis-table-bordered table-altrow" >
	<tr><th class="accorHeadrow" onclick="accordionTable('data');" >Schedules</th></tr>


	<tr><td><a href="<?php echo URL.'schedules/rcards/'.$sy.DS.'?lvl='.$lvl; ?>" >Rcards</a></td></tr>
	<tr><td><a href="<?php echo URL.'schedules/ensteps/'.$sy.DS.'?lvl='.$lvl; ?>" >Ensteps</a></td></tr>
	<tr><td><a href="<?php echo URL.'schedules/tuitions/'.$sy.DS.'?lvl='.$lvl; ?>" >Tuitions</a></td></tr>
	<tr><td><a href="<?php echo URL.'schedules/booklists/'.$sy.DS.'?lvl='.$lvl; ?>" >Booklists</a></td></tr>
	

</table>







<script>
var gurl = "http://<?php echo GURL; ?>";
var dbclassrooms = "<?php echo $dbclassrooms; ?>";
var sy = "<?php echo $sy; ?>";
var limit=20;
			
$(function(){
	$('html').live('click',function(){ $('#names').hide(); });
	$('#names').hide();
	
})




function axnFilter(id){
	var url=`${gurl}/schedules/classroom/${id}/${sy}`;
	window.location=url;
}	/* fxn */









</script>



<script type="text/javascript" src='<?php echo URL."views/js/axjs.js"; ?>' ></script>

