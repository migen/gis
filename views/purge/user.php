<h5>
	Dangerous Purge User
	| <?php $this->shovel('homelinks'); ?>
</h5>


<p><?php require_once(SITE.'/views/elements/filter_codename.php'); ?></p>
<div id="names" >names</div>





<script>
var gurl = "http://<?php echo GURL; ?>";
var limits='20';


$(function(){ $('#names').hide(); })

function redirContact(ucid){
	var url = gurl+'/purge/user/'+ucid;	
	window.location = url;		
}


</script>

<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>
