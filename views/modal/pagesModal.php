<style>


.wrapper{
	width:800px;height:520px;border:1px solid red;overflow:fixed;
	
}
.ibox{ float:left;border:1px solid black;margin-right:4px;width:200px;height:60px;}


</style>

<div class="wrapper"  >
<?php for($i=0;$i<$count;$i++): ?>
	<div class="ibox" ><?php echo "#".$rows[$i]['id']."<br />".$rows[$i]['name']; ?></div>
<?php endfor; ?>
</div>