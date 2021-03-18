
    function Connect() {
        var ret =  document.embeds[0].Connect("*");
        if(ret != "") alert(ret);           
    }
    
    function Disconnect() {
      document.embeds[0].Disconnect(true);
      RefreshCardState();
    }
    
    function setReader(){
      var readerName = document.getElementById('readers').options[document.getElementById('readers').selectedIndex].value;
      var set = document.embeds[0].SetReader(readerName);
      RefreshCardState();
      Disconnect();
    }
    
    
    function SendApdu(){
      var set = document.embeds[0].TransmitString(document.getElementById('ApduIn').value);
    }

	
    
    function RefreshReadersList() {
	  
	  var nb = document.embeds[0].GetReaderCount();
      s = '<select class="select" id= "readers"  onChange="setReader();">' ;
      var i;
      for (i=0; i<nb; i++) {
		s += '<option>'+document.embeds[0].GetReaderName(i)+'</option>';
      }
      s += '</select>';
      document.getElementById('list').innerHTML = s;
      setReader();
    }
    
    function RefreshCardState(){
      var isPresent = document.embeds[0].IsCardPresent();
      if(isPresent){						
		var set = ReadCard();
		$("#cidraw").val(set);		
		xgetContact(set);		
      } else {
        document.getElementById('CardState').value = "No Card on the reader";
		// $("input.contact").val('');		
		// $(".contact").text('');		
      }
    }
    
    function display(str) {
      alert('.'+str+'.');
    }
    
	
	function LoadAuth(key){
		if (typeof(key)==='undefined') key = 'FF 82 00 00 06 FF FF FF FF FF FF';
		document.embeds[0].TransmitString(key);	
	}
	
	
	function AuthCard(block){
		if (typeof(block)==='undefined') block = '05';
		var key =  'FF 86 00 00 05 01 00 '+ block +' 60 00';
		document.embeds[0].TransmitString(key);			
	}
	


	function ReadBlock(block){
		if (typeof(block)==='undefined') block = '05';
		var key =  'FF b0 00 '+ block +' 10';
		var val = document.embeds[0].TransmitString(key);	
		return val;		
	}
	
	/* FF D6 00 05 10  */
	function WriteBlock(){
		if (typeof(block)==='undefined') block = '05';
		var inputcid = $("#InputCid").val();
		var key =  'FF d6 00 '+ block +' 10 '+inputcid;
		var val = document.embeds[0].TransmitString(key);			
	}
	
	
	
	function ReadCard(){
		/* 1 - connect */
		alert(33);
		Connect();
				
		/* 2 - load authentication */
		LoadAuth();
		
		/* 3 - authenticate card */
		AuthCard();
		
		/* 4 - read card block 5  */
		return ReadBlock('05');
	
	}


	function WriteCard(){
		/* 1 - connect */
		Connect();
				
		/* 2 - load authentication */
		LoadAuth();
		
		/* 3 - authenticate card */
		AuthCard();
		
		/* 4 - write card block 5  */
		return WriteBlock('05');	
	
	}

	
	function tracehd(){
		$('.hd').toggle();
	}
	