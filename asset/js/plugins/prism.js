var $pre = $('pre'),
	 $code = $('code'),
	 classes = $pre.attr('class');
	 $pre.attr('class', classes + " line-numbers language-markup");
	 $code.atttr('class', classes + "language-markup");