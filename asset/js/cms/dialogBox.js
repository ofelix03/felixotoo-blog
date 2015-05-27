function DialogBox(options){
	this.dialogBox_underlay		 =  $("#dialogBox-underlay");
	this.dialogBoxNode 			 =  $("#dialogBox");
	this.dialogBoxTitleNode 	 =  $("#title");
	this.dialogBoxMessageNode 	 =  $("#message");
	this.dialogBoxResponseNode 	 =  $( "#response");
	this.dialogBoxCloseBtnNode	 =  $('#closeBtn').find('button');
	this.windowWidth 	 		 =  window.innerWidth;
	this.windowHeight		     =  window.outerHeight;

	this.default = {
		            "position"                   : "center",
					"dialogType"                 : "notification", //notification or confirmation
					"title"                      : "Confirm Action",
					"message"                    : "Do you want to continue with selected action",
					"responseText"               : ['Yes', 'No'],
					"animationSpeed"             : 100,
					"closeByEsc"                 : true,
					"responseCallback"           : null,
					"responseCallbackParameters" : null
				}
				this.options = $.extend({}, this.default, options);

				//Set the height of the dialogBox_underlay equal to the height of the document
				this.dialogBox_underlay.css("height", $(document).height());
	
	}

	DialogBox.prototype = {
		"init" : function(){
	 		//apply the options to the dialogBox markup
	 		if(this.options.dialogType == "notification")
	 			this.dialogBoxResponseNode.find('button').data('text', 'Ok');


	 		//call required methods.
	 		this.setPosition();
	 		this.setResponseText();
	 		this.setTitle();
	 		this.setMessage();
	 		this.responseCallback();
	 		this.close();
	 	},

	 	"show" : function(options){
	 		if(options){
	 		 	this.options = $.extend({}, this.options, options);
	 		}
	 		//set all needed optiosn and markkup css
	   		this.init();
            //show dialogBox_underlay
            this.dialogBox_underlay.show();
	 		//show dialogBox
	 		this.dialogBoxNode.slideDown(this.options.animationSpeed);
	 	},

	 	"close" : function(){
	 		var data = {
	 			"dialogBoxNode"		 : this.dialogBoxNode,
	 			"animationSpeed" 	 : this.options.animationSpeed,
	 			"dialogBox_underlay" : this.dialogBox_underlay
	 		}

	 		this.dialogBoxCloseBtnNode.click(data, function(index){
	 			data.dialogBoxNode.slideUp(data.animationSpeed);
	 			data.dialogBox_underlay.hide();
	 		});

	 		if(this.options.closeByEsc == true)
	 		{
	 			$(document).keypress(data, function(e){
	 				if(e.which == 0 ){
	 					data.dialogBoxNode.slideUp(data.animationSpeed);
			 			data.dialogBox_underlay.hide();
	 				}
	 			});
	 		}
	 	},

	 	"setPosition"           :  setPosition,

	 	"setResponseText"       :  setResponseText,

	 	"setTitle"              :  setTitle,

	 	"setMessage"            :  setMessage,

	 	"responseCallback"      : responseCallback
	}


	 function setPosition(){
	 	if(this.options.position == "center"){
	 		var top  = (this.windowHeight / 2);
	 		var left = (this.windowWidth / 2) - (this.dialogBoxNode.innerWidth() / 2);
	 		this.dialogBoxNode.css({
	 			"top"  : top,
	 			"left" : left
	 		});
	 	}
	 	else if(this.options.position == "leftCenter"){
	 		this.dialogBoxNode.css({
	 			"left"  : 0, 
	 			"top"   : this.windowHeight / 2
	 		});
	 	}
	 	else if(this.options.position == "rightCenter"){
	 		this.dialogBoxNode.css({
	 			"right" : 0,
	 			"top"   : this.windowHeight / 2
	 		});
	 	}
	 	else if(this.options.position == "leftTop"){
	 		this.dialogBoxNode.css({
	 			"left" : 0,
	 			"top"  : 0
	 		});
	 	}
	 	else if(this.options.position == "rightTop"){
	 		this.dialogBoxNode.css({
	 			"right" : 0,
	 			"top"   : 0
	 		});
	 	}
	 	else if(this.options.position == "leftBottom"){
	 		this.dialogBoxNode.css({
	 			"left"    : 0,
	 			"bottom"  : 0
	 		});
	 	}
	 	else if(this.options.position == "rightBottom"){
	 		this.dialogBoxNode.css({
	 			"right"   : 0,
	 			"bottom"  : 0
	 		});
	 	}
	 }


	 function  setResponseText(){
 		//Assign any new responseText substitute 
 		var responseButtons = this.dialogBoxResponseNode.find('button');
 		var responseText = this.options.responseText;

 		if(this.options.dialogType == 'notification')
 		{
 			//Change the text of the first button to "OK" and hide the second button
 			responseButtons.each(function(index){
 				$this = $(this);
 				if(index == 0){
 				 	//change the button text to "OK"
 				 	$this.text("OK");
 				 }
 				 else
 				 	$this.hide();
 			});

 		}
 		else if(this.options.dialogType == "confirmation")
 		{
 			//dialogBox is a confirmation type, therefore need at least two buttons
 			responseButtons.each(function(index){
 				$this = $(this).show();
 				$this.text(responseText[index]);
 			});
 		}
 	}

 	function setTitle(){
 		this.dialogBoxTitleNode.find("header").text(this.options.title);
 	}

 	function setMessage(){
 		this.dialogBoxMessageNode.text(this.options.message);
 	}

   function responseCallback(){
      var data = {
      	       "options" : this.options,
      	       "dialogBoxNode" : this.dialogBoxNode,
      	       "dialogBox_underlay" : this.dialogBox_underlay
      	   }
      var $responseBtn = this.dialogBoxResponseNode.find('button');
      $responseBtn.click(data, function(){
      	$this = $(this);
      	if($this.data('text') == "yes"){
      		//implement user callback for yes dialog response
      		var parameters = data.options.responseCallbackParameters
      		var args = []
      		if($.isArray(parameters))
      		{
      			//create an array of the parameters/args
      			for(var i = 0; i< parameters.length ; i++)
	      		{
	      			args[i] = parameters[i];
	      		}
      		}
      		else
      		{
      		     //an args array with only one element
      			 args[0] = parameters;
      		}
      		data.options.responseCallback.apply(this, args);
      		data.dialogBoxNode.slideUp(data.options.animationSpeed);
      	}
       
        if($this.data('text') == "no")
      	{
	       data.dialogBoxNode.slideUp(data.options.animationSpeed);
      	}
      	if($this.data('text') == "Ok")
      	{
	       data.dialogBoxNode.slideUp(data.options.animationSpeed);
      	}
      	data.dialogBox_underlay.hide();
      });
   }
 	
