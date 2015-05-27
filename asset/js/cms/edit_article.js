
   /****************************************************
   *    Publish Date field JS
   ********************************************/
	var $radiobox = $('.published-radiobox').find('input');
	var $publish_date_field = $("input[name='pub_date']");
	var $last_modfied_field = $("input[name='last-modified']");
	$radiobox.click(function(){
		$this = $(this);
		if($this.val() == 'y')
		{
			//set publish date to the current date
			$publish_date_field.val("automatically-setted");

			//disable field
			$publish_date_field.attr('disabled', 'disabled');
		}
		else 
		{
			//enable the field
			$publish_date_field.removeAttr('disabled');
			$publish_date_field.val('');

			//prompt the user to enter the publish date 
			$publish_date_field.attr('placeholder', 'Enter a new publish date for this article');
		}
	})



	/*********************************************************
	*			Ajax call to server that returned a slug of a text *
	***************************************************************/
	var $title = $('form').find("input[name='title']");
	var $slug = $('form').find("input[name='slug']");
	$title.focusout(function(){
		$this = $(this);
		if($this.val() != ""){
			//ajax call to server to build a slug for the title
			var url = $('#site_url').data('url') + '/cms/create_slug';
			var data = {"text" : $this.val()};

			$.get(url, data, function(ret_data){
					var data = ret_data;
					//assign it to the val of $slug
					$slug.val(data);
			});

		}
	})
