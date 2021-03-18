<style>
#watermark {
  color: #d0d0d0;
  font-size: 60pt;
  position: absolute;
  width: 100%;
  height: 100%;
  margin: 0;
  z-index: -1;
  left:250px;
  top:400px;
}

</style>

<div id="watermark" >
	<?php 
		switch($student['is_active']){
			case 0: echo 'Dropped'; break;
			case 2: echo 'Transferred'; break;
			default: break;
		}	
	?>	
</div>
