<h2> Student Home</h2>

<?php 


?>



<?php if(Session::get('status') == 1): ?>
<h5>Welcome,<?php echo Session::get('student'); ?>
<?php else: ?>
<h5 class="red">
<?php echo Session::get('message'); ?>
<?php endif; ?>
</h5>

<table>
<tr><th>Number</th><td><?php echo Session::get('student_code'); ?></td></tr>
<tr><th>Name</th><td><?php echo Session::get('student'); ?></td></tr>
</table>


<p><a href="<?php echo URL.'grades/view'; ?>">View Grades</a></p>

