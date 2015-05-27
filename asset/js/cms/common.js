 /**************************************************************
   *    Menu Dropdown JS
   **********************************************************/
	//cms menu list js
	var $main_menu_list = $('.menu').find('ul').first().children();
	var $hidden_menu = $main_menu_list.find('ul');
	//var $hidden_menu = $main_menu_list.find('ul');
	$main_menu_list.click(function(){
		$this = $(this);
		if($this.data('menu') == "yes")
		{
			if($hidden_menu.data('active') == 'inactive')
			{
				$hidden_menu.data('active', 'active');
				$hidden_menu.show().slideDown(100);
			}
			else if($hidden_menu.data('active') == 'active')
			{
				$hidden_menu.data('active', 'inactive');
				$hidden_menu.hide().slideUp(100);

			}
		}
		return false;
	});



	$hidden_menu.children().each(function(){
		$this = $(this);
		$this.find('a').click(function(){
			$this = $(this);
			if($this.data('url')){
				var url = $this.data('url');
			}
			else
			{
				var url = $(this).attr('href');
			}
			window.location.replace(url);
			
			return false;
		})

	});