	| <a href="<?php echo URL.'booklists'; ?>" >Booklists</a>
	| <a href="<?php echo URL.'booklists/levels'; ?>" >Levels</a>
	| <a href="<?php echo URL.'booklists/table'; ?>" >All</a>
	
	<?php 
		$book_id=isset($book_id)? $book_id:NULL;
		
	?>
	
	| <a href="<?php echo URL.'booklists/manager/'.$book_id; ?>" >Manager</a>
	| <a href="<?php echo URL.'students/booklist'; ?>" >Student</a>
