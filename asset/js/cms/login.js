function validate_login_details(field, value){
	var src = site_url() + '/cms/validate_login_details';
	var data = {
		"feild" : field,
		"value" : value
	}
	$.post(src, data, function(ret){
		console.log(ret);
	});

}