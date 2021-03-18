
<style>
div{ border:0px solid black; }


</style>


<h5>
	Teachers
	<?php $this->shovel('homelinks'); ?>
	
</h5>

<div style="float:left;width:60%;" >

<p><?php $this->shovel('numrows'); ?></p>


<h5> 
	Add Teachers
	| <a class="u" onclick="ilabas('clipboard');" >Smartboard</a>
</h5>


<form method="POST" >

<p>
	<input type="submit" name="submit" value="Add" /> &nbsp; 
	<button><a href="<?php echo URL.'mis'; ?>" class="no-underline" >Cancel</a></button>
</p>

<table class="gis-table-bordered" >
<tr class='headrow'>
	<th>#</th>	
	<th class="vc30" >TCID</th>
	<th class="vc100" >ID Number</th>
	<th class="vc200" >Fullname</th>
</tr>

<?php $numrows = isset($_POST['numrows'])? $_POST['numrows'] : 1; ?>
<?php for($i=0;$i<$numrows;$i++): ?>

<tr >
	<td class="vc20" ><?php echo $i+1; ?></td>
	<td><input id="scid<?php echo $i; ?>" class="full" type="text" name="posts[<?php echo $i; ?>][id]" /></td>		
	<td><input id="code<?php echo $i; ?>" class="full" type="text" name="posts[<?php echo $i; ?>][code]" /></td>		
	<td><input id="name<?php echo $i; ?>" class="full" type="text" name="posts[<?php echo $i; ?>][name]" /></td>
</tr>

<?php endfor; ?>			
</table>



</form>


</div>	<!-- left -->


<div class="third" >

<p>
<?php 
	require_once(SITE.'/views/elements/filter_codename.php');
?>
</p>

<div id="names" >names</div>

</div>	<!-- right -->







<!------------------------------------------------------------------------>

<div style="width:50px;float:left;height:100px;" ></div>
<div class="clipboard" style="width:200px;float:left;"  >
<p>
<select id="classbox" >
	<option value="scid" >SCID</option>
	<option value="code" >Code</option>
	<option value="name" >Name</option>
</select>
</p>
<?php $d['width'] = '20'; ?>
<?php $this->shovel('smartboard',$d); ?>
</div>



<div class="clear ht100" >&nbsp;</div>





<!-------------------------------------------------------------------------------------->

<script>

var gurl = "http://<?php echo GURL; ?>";
var limits='20';


$(function(){
	itago('clipboard');
	$('#names').hide();
	$('html').live('click',function(){ $('#names').hide(); });
	

})

function redirContact(){ $('#part').val(''); }




</script>




<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>
