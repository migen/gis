<?php
  // There will be no output until you "flush" or echo the buffer's contents
  ob_start();
  
  $name = "Lara";
  $food = "cashews";
?> 

<h1>Hi, my name is <?php echo $name; ?>.</h1>
<p>I like <?php echo $food; ?>.</p> 

 <p> this will be part of content - YES </p>

<?php


  $content = ob_get_contents();
  
 ?>
 
 <p> will this be part of content? - NO </p>

<?php   
  ob_end_clean();

//  echo $content;
?>


some blha blah blah content in html

<br >


<?php


echo $content;

echo '<hr>';

echo $content;


