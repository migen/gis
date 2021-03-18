<h3>
    SHS Levels Genave 
    | <?php $this->shovel('homelinks'); ?>


</h3>


<?php 

// pr($classrooms[6]);

?>

<h4>Levels</h4>
<table class="gis-table-bordered" >
<?php foreach($levels AS $level): ?>
    <?php if($level['id']>15 || $level['id']<14){ continue; } ?>
    <tr>
        <td><?php echo $level['id']?></td>
        <td><?php echo $level['name']?></td>
        <td><a href="<?php echo URL.'genave/levelQave/'.$level['id'].'/5/6/7'; ?>">Final</a></td>
    </tr>
<?php endforeach; ?>
</table>




<div class="ht100" ></div>
