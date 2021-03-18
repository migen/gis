<h3>
    Classroom Level


</h3>


<?php 

// pr($classrooms[6]);

?>

<h4>Levels</h4>
<table class="gis-table-bordered" >
<?php foreach($levels AS $level): ?>
    <?php if($level['id']>15){ continue; } ?>
    <tr>
        <td><?php echo $level['id']?></td>
        <td><?php echo $level['name']?></td>
    </tr>
<?php endforeach; ?>
</table>



<h4>Classrooms</h4>
<table class="gis-table-bordered" >
<?php foreach($classrooms AS $classroom): ?>
    <?php if($classroom['section_id']<3){ continue; } ?>
    <tr>
        <td><?php echo $classroom['id']?></td>
        <td><?php echo $classroom['name']?></td>
    </tr>
<?php endforeach; ?>
</table>


<div class="ht100" ></div>
