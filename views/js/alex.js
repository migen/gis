// alert('alex');

// $(selector).live(events,data,handler);                // jQuery 1.3+
// $(document).delegate(selector,events,data,handler);  // jQuery 1.4.3+
// $(document).on(events,selector,data,handler);        // jQuery 1.7+

// delete	: for 1-to-many cfile-details   // # $('.delchild').live('click',function(){
$(document).on('click','.delchild',function(){		
	delchild = $(this);
	var id = delchild.attr('rel');	// alert(id);
	var cnfm = confirm ("WARNING! Confirm DELETE " + id + "?") ;
	if(cnfm){
		delchild.parent().parent().remove();		// .hide();
		var url = gurl + controller + '/delchild/'+ id;
		$.post(url,function(x){
			return false;
		},'json');
		return false;					
	}
});

// delete	: for n-to-n or family,ie groups_users		# deprecated // $('.delLink').live('click',function(){
$(document).on('click','.delLink',function(){		
	delLink = $(this);
	var id = delLink.attr('rel');	// alert(id);
	var cnfm = confirm ("WARNING! Confirm delete " + id + "?") ;		
	if(cnfm){
		delLink.parent().parent().remove();
		var url = gurl + '/' + controller +'/delLink/'+ id+'/alter';
		$.post(url,function(x){
			return false;
		},'json');
		return false;					
	}
});

// delete	: for independent,ie text-replys	
$(document).on('click','.delthis',function(){		
	delthis = $(this);
	var id = delthis.attr('rel');	// alert(id);
	var cnfm = confirm ("WARNING! Confirm delete " + id + "?") ;		
	if(cnfm){
		delthis.parent().parent().remove();
		var url = gurl + controller +'/delete/'+ id;
		$.post(url,function(x){
			return false;
		},'json');
		return false;					
	}
});
