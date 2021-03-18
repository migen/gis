<?php 

$dbg=PDBG;
$dbtable="{$dbo}.`05_subjects`";

?>

<h5>
	College Subjects | <?php $this->shovel('homelinks','College'); ?>
	| <a href="<?php echo URL.'unisubjects/create'; ?>" >Create</a>
	| <a href="<?php echo URL.'unisubjects/reset'; ?>" >Reset</a>
	| <a href="<?php echo URL.'uniclassrooms'; ?>" >Classrooms</a>


</h5>


<?php $this->shovel('filter_redirect'); ?>



<script>
var gurl = "http://<?php echo GURL; ?>";
var limits='20';
var dbtable = "<?php echo $dbtable; ?>";

$(function(){
	$('#names').hide();
	$('html').live('click',function(){ $('#names').hide(); });
	
})

function axnFilter(id){
	var url = gurl+'/unisubjects/crs/'+id;	
	window.location = url;		
}





</script>

<script type="text/javascript" src='<?php echo URL."views/js/filters_general.js"; ?>' ></script>
