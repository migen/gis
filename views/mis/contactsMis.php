<?php 

?>


<h5>
	Contacts Manager | <?php $this->shovel('homelinks'); ?>
	| <a href='<?php echo URL."contacts"; ?>' >Links</a> 
	<?php if(isset($_GET['q'])): ?>
		| <a href='<?php echo URL."mgt/contacts"; ?>' >No Qry</a> 	
	<?php else: ?>			
		| <a href='<?php echo URL."mgt/contacts?q"; ?>' >Qry String</a> 
	<?php endif; ?>	
	| <a class="u" onclick="ilabas('clipboard');" >Smartboard</a>


	
</h5>

<p>
<?php
 
	require_once(SITE.'/views/elements/filter_codename.php');
?>
</p>

<div id="names" >names</div>





<?php 

$q=isset($q)? $q:NULL;
if(isset($_GET['q'])){ pr($q); }


if(!isset($_GET['filter'])){
	$incs = SITE.'views/mis/incs/contacts_filter.php';
	include_once($incs);

} else {
	$incs = SITE.'views/mis/incs/contacts_table.php';
	include_once($incs);


}

?>

<script>
var gurl = "http://<?php echo GURL; ?>";
var sy = "<?php echo $sy; ?>";
var limits='20';


$(function(){
	$('#names').hide();
})

function redirContact(ucid){
	var url = gurl+'/contacts/ucis/'+ucid;	
	window.location = url;	
	
}


</script>


<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>
