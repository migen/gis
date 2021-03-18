<?php 

$dbo=PDBO;
$dbtable="{$dbo}.`00_contacts`";
$method=($_SESSION['settings']['attd_qtr']==1)? 'studentQtr':'student';


?>

<h5>
	Attendance | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'profiles/scid'; ?>" >Profile</a>


</h5>


<?php $this->shovel('filter_redirect'); ?>



<script>
var gurl = "http://<?php echo GURL; ?>";
var limits='20';
var dbtable = "<?php echo $dbtable; ?>";
var method = "<?php echo $method; ?>";

$(function(){
	$('#names').hide();
	$('html').live('click',function(){ $('#names').hide(); });
	
})

function axnFilter(id){
	var url = gurl+'/attendance/'+method+'/'+id;	
	window.location = url;		
}





</script>

<script type="text/javascript" src='<?php echo URL."views/js/filters_general.js"; ?>' ></script>
