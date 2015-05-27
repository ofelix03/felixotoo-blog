function ajax_get_profile(id, ajax_img_loader){
    ajax_loader(ajax_img_loader);
	var address = site_url() + 'cms/get_profile';
	$.post(address, {"id": id}
	).
	done(function(ret){
		ajax_loader_off(ajax_img_loader);
		interpret_json(ret);
	});
}


function ajax_loader($img){
	var loader = base_url() + 'asset/img/cms/ajax2.gif';
	$img.fadeIn();
	$img.attr('src', loader);
}

function ajax_loader_off(img){
	img.removeAttr('src');

}

function interpret_json(data){
	data = $.parseJSON(data);
	if(data.status == "success"){
		if(typeof $profile === "object" && $profile.length != 0)
	{
		var profile_data = data.profile;
        //insert data into the DOM
		$profile.hide().find('p').each(function(){
			$this = $(this);
			$second_span  = $this.find('span:nth-child(2)');
			$second_span.text('');

			var identifier = $this.attr('class');
			switch(identifier){
				case 'name': 
				$second_span.text(profile_data.name);
				break;
				case 'age': 
				$second_span.text(profile_data.age);
				break;case 'sex': 
				$second_span.text(profile_data.sex);
				break;
				case 'profession': 
				$second_span.text(profile_data.profession);
				break;
				case 'in-brief': 
				$second_span.text(profile_data.in_brief);
				break;

				case 'social-networks': 
				$second_span.text(profile_data.social_networks);
				break;
			}
		})
        //show profile
		$profile.fadeIn(500);
	}
	else
		console.log('Not dom element selected. Make sure to select the target Node');

	}
	else
	{
		console.log(data);
	}
}