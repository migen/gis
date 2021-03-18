<style>

.box{ background-color:green; width:100px;text-align:center;float:left;margin-right:10px;margin-bottom:10px;
	height:100px;line-height:1.5; 
  display: inline-block;
  vertical-align: middle;

}
.wrapper{ width:330px; }

</style>


<!-- 

// for multiline text
line-height: 1.5;
  display: inline-block;
  vertical-align: middle;


-->


<h5>
Box | <?php $this->shovel('homelinks'); ?>


</h5>


<div class="wrapper" >

<?php for($i=0;$i<$count;$i++): ?>
<div class="box" >
	<?php pr($i+1); echo 'dfsdf lflksdf fgfd kjlk'; ?>
</div>
<?php endfor; ?>

</div>
