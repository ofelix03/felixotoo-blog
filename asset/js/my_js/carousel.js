/********************************************
Owl Carousel Implementation
************************************/
$(document).ready(function(){
		$('.carousel').owlCarousel({
			items: 1,
			autoPlay: 5000,
			itemsTablet : [1920, 1],
			itemsMobile : [500, 1],
			responsive: true,
			pagination: true,
			paginationNumbers :true

		});
	});