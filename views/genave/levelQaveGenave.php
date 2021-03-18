<?php 

    extract($level);
    $decigenave=isset($_GET['deci'])? $_GET['deci']: $_SESSION['settings']['decigenave'];

?>


<h3>
    Quarters Average
    | &deci=<?php echo $decigenave; ?>
    | &sy=<?php echo $sy; ?>
    | <?php $this->shovel('homelinks'); ?>

    <?php if($lvl>13): ?>
        | <a href="<?php echo URL.'genave/levelQave/'.$lvl.'/1/2/5'; ?>" >Sem1</a>
        | <a href="<?php echo URL.'genave/levelQave/'.$lvl.'/3/4/6'; ?>" >Sem2</a>
        | <a href="<?php echo URL.'genave/levelQave/'.$lvl.'/5/6/7'; ?>" >Final</a>
    <?php endif; ?>    

</h3>

<h4>Level <?php echo $lvlname; ?>: <?php echo $count; ?> </h4>


<form method="POST" >
<table class="gis-table-bordered table-altrow table-fx text-center" >
<tr>
    <th>#</th>
    <th>Classroom</th>
    <th>Scid</th>
    <th>ID No.</th>
    <th>Student</th>
    <th class="center" ><?php echo ucfirst($qa); ?></th>
    <th class="center" ><?php echo ucfirst($qb); ?></th>
    <th class="center" >DB Ave<br><?php echo ucfirst($qc); ?></th>
    <th class="center" >Calc<br><?php echo ucfirst($qc); ?></th>
</tr>
<?php $updated=true; ?>
<?php foreach($rows AS $i => $row): ?>
<?php 
    extract($row);    
?>
<tr>
    <td><?php echo $i+1; ?></td>
    <td><?php echo $classroom; ?></td>
    <td><?php echo $scid; ?></td>
    <td><?php echo $studcode; ?></td>
    <td><?php echo $studname; ?></td>
    <td><?php echo $first; ?></td>
    <td><?php echo $second; ?></td>
    <td><?php echo $ave; ?></td>
    <?php 
        $dbave = number_format($ave,$decigenave);        
        $ctave = number_format(($first+$second)/2,$decigenave);
        $same = ($dbave == $ctave)? true:false;
        
    ?>

    <td>
        <?php if(!$same): ?>
            <?php $updated=false; ?>
            <input class="vc100 center" readonly name="posts[<?php echo $i; ?>][ave]" value="<?php echo $ctave; ?>" >
            <input type="hidden" class="vc100" name="posts[<?php echo $i; ?>][scid]" value="<?php echo $scid; ?>" >
        <?php endif; ?>

    </td>
</tr>

<?php endforeach; ?>

<?php if(!$updated): ?>
    <tr>
        <td colspan=9><input type="submit" name="submit" value="Submit" ></td>
    </tr>
<?php endif; ?>

</table>
</form>


<div class="ht100" ></div>