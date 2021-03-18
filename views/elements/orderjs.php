<script>

function sessionASC(){	
	var gurl 	= 'http://<?php echo HOST.'/'.DOMAIN; ?>';
	var vurl = gurl + '/index/sessionASC';			
	$.ajax({ url : vurl, })
	location.reload();
}

function sessionDESC(){	
	var gurl 	= 'http://<?php echo HOST.'/'.DOMAIN; ?>';
	var vurl = gurl + '/index/sessionDESC';			
	$.ajax({ url : vurl, })
	location.reload();
	
}


</script>


<?php if($_SESSION['order']=='ASC'): ?>
	<span class="underline" onclick="sessionDESC();" >DESC</span>			
<?php else: ?>
	<span class="underline" onclick="sessionASC();" >ASC</span>						
<?php endif; ?>
