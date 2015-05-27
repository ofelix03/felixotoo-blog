
/**********************************************************
Functios for site_url & base_url
***********************************************************/	
function site_url(){
	return $('#site_url').data('url') + "/";
}

function base_url(){
	return $('#base_url').data('url');
}


/***********************************************************
Functions for manipulating the  data-* values
***********************************************************/
function get_action(object){
	return object.data('action');
}


function get_id(object){
	return object.data('id');
}

function get_state(object){
	return object.data('state');
}

function set_state(object, value){
	object.data('state', value);
}

function get_checked_ids(object){
	//get ids for all checked rows
	var ids = [];
	var count = 0;
	object.each(function(index, value){
		$this = $(this);
		if(get_action($this) == 'check' && get_state($this) == 'checked')
		{
			var id = get_id($this);
			ids[count] = id;
			count++;
		}
	});	
	return ids;
}


function set_active($this, value){
	$this.data('active', value);
}


/*****************************************************************
		check/Uncheck All Functions
		*****************************************************************/

function check_all(object){
	//change the unchecked state of the check all node to checked
	set_state(object,'checked');
	var $tds = $('.content').find('tr td');

	//change the checked icon to an unchecked icon
	var src = base_url() + "asset/img/cms/unchecked.png";
	object.find('img').attr('src', src);

	//change the check all text to uncheck all
	object.find('span').text("Uncheck All");

	$tds.each(function(){
		$this = $(this);
		if(get_action($this) == 'check')
		{
			//change the check state to "uncheck"
			set_state($this, 'unchecked');
			change_check_icon($this);

			//set check state  to "checked"
			set_state($this, "checked");
		}
	});

	//get all checked ids
	return get_checked_ids($tds);
}


function uncheck_all(object){
	//change the check state of the check all node to unchecked
	set_state(object, "unchecked");

	//change the checked icon to an unchecked icon
	var src = base_url() + "asset/img/cms/check.png";
	object.find('img').attr('src', src);

	//change the check all text to uncheck all
	object.find('span').text("Check All");

	var $tds = $('.content').find('tr td');
	$tds.each(function(){
		$this = $(this);
		if(get_action($this) == 'check')
		{
			//change all unchecked state to "checked"
			set_state($this, 'checked');
			change_check_icon($this);

			//set check state  to "unchecked"
			set_state($this, "unchecked");
		}
	});
}

/*************************************************************
window.location.methods
*************************************************************/
var locate = {
	"change_url" :	function change_url(new_url ){
		return window.location.replace(new_url);
	},

	"reload" 	:	function reload(){
		window.location.reload();
	},

	"get_href" : 	function get_href(){
		return window.location.href;
	},

	"url_replace" : function url_replace(new_url){
		window.location.replace(new_url);
	}
}



/*************************************************************
	Functions to manipulate the icons on the CMS
	************************************************************/
//chaning the check/uncheck command icon 
function change_check_icon(object){
	if(get_state(object) == 'checked')
	{
		//change checked to uncheck
		set_state(object, 'unchecked');

		//change the image
		var src = base_url() + 'asset/img/cms/unchecked.png';
		object.find('img').attr('src', src);
	}
	else if(get_state(object) == 'unchecked')
	{
		//change unchecked state to checked
		set_state(object, 'checked');

		//change the image
		// var src = "<?php echo base_url('asset/img/cms/facebook.png');?>"
		var src = base_url() + 'asset/img/cms/check.png';
		object.find('img').attr('src', src);
	}
}



//chaning the pub/unpub command icon 
function change_pub_icon(object, data){
	var ids = data.ids;
	if((data.ids_count > 1 && object.length > 1) || (data.ids_count == 1 && object.length > 1)){
		// if data.ids_count > 1 => publish or unpublish was triggered  from the main command
		if(data.action == "publish"){
			for(var i = 0; i < ids.length; i++)
			{
				var id = ids[i];
				object.each(function(){
					$this  = $(this);
					if(get_state($this) == '0' && get_action($this) == 'pub' && get_id($this) ==  id)
					{
							//change unpub(0) to pub(1)
							set_state($this, '1');
							
							//change the image
							var src = base_url() + 'asset/img/cms/eye.png';
							$this.find('img').attr('src', src);
						}
					});
			}
		}
		else if (data.action == 'unpublish')
		{
			for(var i = 0; i < ids.length; i++)
			{
				var id = ids[i];
				object.each(function(){
					$this  = $(this);
					if(get_state($this) == '1' && get_action($this) == 'pub' && get_id($this) == id )
					{
						console.log('unpublishing');
						//change pub(1) state to unpub(0)
						set_state($this, '0');
						//change the image
						var src = base_url() + 'asset/img/cms/eye-blocked.png';
						$this.find('img').attr('src', src);
					}
				});
			}

		}
	}
	else if(data.ids_count == 1 && object.length == 1)
	{
		console.log('equals one');
		//if data.ids_count == 1 => publish or unpublish was triggered from the inline pub/unpub icon
		$this = object;
		if(get_state($this) == '0' && get_action($this) == 'pub' && get_id($this) ==  ids)
		{
			//change unpub(0) to pub(1)
			set_state($this, '1');
			
			//change the image
			var src = base_url() + 'asset/img/cms/eye.png';
			$this.find('img').attr('src', src);
		}
		else if(get_state($this) == '1' && get_action($this) == 'pub' && get_id($this) == ids )
		{
			//change pub(1) state to unpub(0)
			set_state($this, '0');
			//change the image
			var src = base_url() + 'asset/img/cms/eye-blocked.png';
			$this.find('img').attr('src', src);
		}

	}




}



/*********************************************************************
	Functions for ORDERING the articles.
	ORDER by article.id, author.name, article.title
	************************************************************************/

	function get_table_name(object){
		return object.data('table');
	}

	function get_order(object){
		return object.data('order');
	}

	function get_order_by(object){
		return object.data('order-by');
	}

	function get_tb_name(object){
		return object.data('table');
	}

	function set_order(object, value){
		object.data('order', value);
	}

	function change_sort_img(node, order){
		if(order == 'desc')
			node.attr('class', 'fa fa-caret-down');
		else if(order == 'asc')
			node.attr('class', 'fa fa-caret-up');

	}


	function show_notification(text, status){
		if(status == 'success')
			var back_color = 'green';
		else if(status == 'fail')
			var back_color = 'red';

		var $notification = $('.notification').css('background', back_color);
		var defaultPosition = {
			'top' : $notification.css('top'),
			'left' : $notification.css('left')
		};

		var $span = $notification.find('span');
		$span.text(text);


		var notification_width = $('.notification').innerWidth();
		var window_width = $(window).innerWidth();
		var leftPosition =  (window_width / 2) -  (notification_width / 2) ;
		$notification.animate({
			top :  "0%",
			left : leftPosition
		}, 200)

	//setTime out
	window.setTimeout(function(){
		$notification.animate({
			top:  -999,
			left : defaultPosition.left
		}, 200)
	}, 5000);

    // $notification.fadeIn(200);

    // window.setTimeout(function(){
    // 	$notification.fadeOut(200);
    // }, 5000);

}

/*********************************************
	Ajax request Functions
	********************************************/
//ajax calls for the varous commands

//ajax call for delete
function ajax_del_author(node){
	var ids  = get_id(node);
	var src = site_url() + 'cms/author_delete';
	loading(node);

	//ajax call now
	$.post(src, {"ids" : ids})
	.done(function(data){
		intepret_result(data, node);
	})
	.fail(function(){
		intepret_result(data, node);
	});
}

function ajax_perm_del_authors_checked(node){
	var ids  = get_checked_ids(node);
	var src = site_url() + 'cms/author_delete';
	loading_del_checked(node, ids);
	
	//ajax call now
	$.post(src, {"ids" : ids})
	.done(function(data){
		intepret_result(data, node);
	})
	.fail(function(data){
		intepret_result(data, node);
	});
}

function ajax_del(node){
	var ids  = get_id(node);
	var src = site_url() + 'cms/delete';
	loading(node);

	//ajax call now
	$.post(src, {"ids" : ids})
	.done(function(data){
		intepret_result(data, node);
	})
	.fail(function(){
		intepret_result(data, node);
	});
}

function ajax_perm_del(node){
	var ids  = get_id(node);
	var src = site_url() + 'cms/permanent_delete';
	loading(node);
	//ajax call now
	$.post(src, {"ids" : ids})
	.done(function(data){
		intepret_result(data, node);
	})
	.fail(function(data){
		intepret_result(data, node);
	});
}

function ajax_perm_del_checked(node){
	var ids  = get_checked_ids(node);
	var src = site_url() + 'cms/permanent_delete';
	loading_checked(node, ids);
	
	//ajax call now
	$.post(src, {"ids" : ids})
	.done(function(data){
		intepret_result(data, node);
	})
	.fail(function(data){
		intepret_result(data, node);
	});
}

function ajax_pub_unpub(node){
	if(get_state(node) == 0)
	{
		//publish
		ajax_publish(node);

	}
	else if(get_state(node) == 1)
	{
		//unpublish
		ajax_unpublish(node);
	}
}

function ajax_publish(node){
	var ids  = get_id(node);
	var src = site_url() + 'cms/publish';

	loading(node);
	
	$.post(src, {"ids" : ids})
	.done(function(data){
		intepret_result(data, node);
	});
}

function loading(node, loader){
	if(loader != undefined && loader != "")
		var loader  = base_url() + loader;
	else
		var loader = base_url() + 'asset/img/cms/ajax2.gif';
	node.children().attr('src', loader);
}

function loading_checked(objects, ids){
	objects.each(function(){
		$this = $(this);
		for(var i = 0; i < ids.length; i++)
		{
			if(get_id($this) == ids[i] && get_action($this) == "pub")
			{
				//attach a loader to node
				loading($this);
			}
		}
	})
}



function loading_del_checked(objects, ids){
	objects.each(function(){
		$this = $(this);
		for(var i = 0; i < ids.length; i++)
		{
			if(get_id($this) == ids[i] && get_action($this) == "del")
			{
				//attach a loader to node
				loading($this);
			}
		}
	})
}


function revert_loading_check(objects, ids, img){
	if(img != undefined && img != "")
		var img = img;
	objects.each(function(){
		$this = $(this);
		for(var i = 0; i < ids.length; i++)
		{
			if(get_id($this) == ids[i] && get_action($this) == "pub")
			{
				//attach a loader to node
				loading($this, img);
			}
		}
	});	
}


function ajax_unpublish(node){
	var ids  = get_id(node);
	var src = site_url() + 'cms/unpublish';
	loading(node);
	$.post(src, {"ids": ids})
	.done(function(data){
		intepret_result(data, node);
	});
}

function ajax_pub_checked(object){
	var ids = get_checked_ids(object);
	loading_checked(object, ids);
	var src = site_url() + "cms/publish";
	//ajax call now
	$.post(src, {'ids': ids})
	.done(function(data){
		intepret_result(data, object);
	});

}



function ajax_unpub_checked(object)
{
	var ids = get_checked_ids(object);
	loading_checked(object, ids);
	
	var count = 0;
	var src = site_url() + "cms/unpublish";
	//ajax call now
	$.post(src, {'ids': ids})
	.done(function(data){
		intepret_result(data, object);
	});
}



function ajax_del_checked(object)
{
	var ids = get_checked_ids(object);
	var count = 0;
	var src = site_url() + "cms/delete";
	//ajax call now
	$.post(src, {'ids': ids})
	.done(function(data){
		intepret_result(data, object);
	});
}


function ajax_undel_checked(object)
{
	var ids = get_checked_ids(object);
	var count = 0;
	var src = site_url() + "cms/undelete";
	//ajax call now
	$.post(src, {'ids': ids})
	.done(function(data){
		intepret_result(data, object);
	});
}

function formateIds(ids){
	var formated = '';
	for(var i = 0; i< ids.length; i++)
	{
		if(i < ids.length - 1)
			formated += ids[i] + ", ";
		else
			formated += ids[i];
	}
	return formated;
}

function intepret_result(data, node){
	var data = $.parseJSON(data);
	if(typeof data.ids === "string")
	{
		data.ids = new Array(data.ids); //cast to Array
	}
	
	if(data.status == 'success')
	{
		var ids = formateIds(data.ids);
		var ids_length = data.ids.length;

		if(data.action == 'publish')
		{
			//change pub_icon 
			change_pub_icon(node, data);

			//colorize the border-bottom of the title published row
			border_bottom_coloring(node, 'green', data);
			show_notification('Published ('+ ids_length +') article with [id(s)] : ' + ids, data.status);
		}

		if(data.action == 'unpublish')
		{
			 //change pub_icon 
			 change_pub_icon(node, data);

			//colorize the border-bottom of the title td
			border_bottom_coloring(node, '#ccc',data);
			show_notification('Unpublished (' + ids_length + ') article with [id(s)] : ' + ids, data.status);
		}

		if(data.action == 'delete')
		{
			var parent_node = node.parent();
			// parent_node.detach();
			var ids = data.ids;
			parent_node.each(function(){
				$this = $(this);
				for(var i = 0; i < ids.length; i++)
				{
					if(get_id($this) == ids[i])
					{
						$this.remove();
					}
				}
			})
			show_notification('Deleted (' + ids.length + ') article(s) with[id] : ' + ids, data.status);
		}

		if(data.action == 'undelete')
		{
			var parent_node = node.parent();
			// parent_node.detach();
			var ids = data.ids;
			parent_node.each(function(){
				$this = $(this);
				for(var i = 0; i < ids.length; i++)
				{
					if(get_id($this) == ids[i])
					{
						$this.remove();
					}
				}
			})
			show_notification('Restored (' + ids.length + ') article(s) with[id] : ' + ids, data.status);
		}
	}
	else if(data.status == 'fail')
	{
		var ids = formateIds(data.failed_ids);
		var ids_length = data.failed_ids.length;
		if(data.action == 'publish')
		{
			console.log('failed publish');
			//change pub_icon 
			change_pub_icon(node, data);

			//colorize the border-bottom of the title published row
			border_bottom_coloring(node, 'green', data);

			revert_loading_check(node, data.failed_ids, 'asset/img/cms/eye.png');

			//add notificatio to  the dome  using a slide down 
			show_notification('Failed to publish (' + ids_length +') article(s) with [id(s)] : ' + ids + "  [Hint : Already published]", data.status);
		}

		if(data.action == 'unpublish')
		{
			//change pub_icon 
			change_pub_icon(node, data);

			//colorize the border-bottom of the title published row
			border_bottom_coloring(node, '#ccc', data);

			revert_loading_check(node, data.failed_ids, 'asset/img/cms/eye-blocked.png');

			//add notificatio to  the dome  using a slide down 
			show_notification('Failed to publish (' +  ids_length +') article(s) with [id(s)] : ' + ids + " [Hint : Already unpublished]", data.status);
		}

		if(data.action == 'delete')
		{
			//add notificatio to  the dome  using a slide down 
			show_notification('Failed to delete (' +  ids_length +') article(s) with [id(s)] : ' + ids + " [Hint : Already deleted]", data.status);
		}

		if(data.action == 'undelete')
		{
			//add notificatio to  the dome  using a slide down 
			show_notification('Failed to restore (' +  ids_length +') article(s) with [id(s)] : ' + ids + " [Hint : Already undeleted]", data.status);
		}
	}
}

function border_bottom_coloring(node, color, data){
	var ids = data.ids;
	//give the lower bottom a green color
	if((data.ids_count > 1 && node.length > 1) || (data.ids_count = 1 && node.length > 1))
	{
		for(var i = 0; i < ids.length; i++)
		{
			var id = ids[i];
			//loop through the node(made of list of td objects)
			node.each(function(){
				$this = $(this);
				if(get_action($this) == 'pub' &&  get_id($this) == id)
				{
					// $this.parent().find('td:nth-child(4)').css('borderBottom', '1px solid '+color);
					$this.parent().css('borderBottom', '1px solid '+color);
				}
			});
		}
	}
	else
	{
		//find the parent of the node and select td:nth-child(3);
		// node.parent().find('td:nth-child(4)').css('borderBottom', '1px solid '+color);
		$this.parent().css('borderBottom', '1px solid '+color);
	}
	
}


