<h3>
    Mini
    <?php $this->shovel('homelinks'); ?>
    | <a href="<?php echo URL; ?>mini">Mini</a>


</h3>



<table class="mini accordion gis-table-bordered table-altrow" >
	<tr><th class="accorHeadrow" onclick="accordionTable('mini');" >Mini &nbsp;&nbsp; </th></tr>


<?php foreach($rows AS $i => $row): ?>
    <tr>
        <td><a href="<?php echo URL.'mini/'.$row; ?>"><?php echo $row; ?></a></td>
    </tr>
<?php endforeach; ?>
<tr><td>&nbsp;</td></tr>

</table>



