var $ = require('jquery');

require('../../compiled/homePopup');

$('#site-full-update').click(function(e){
	e.preventDefault();
	var $parent = $(this).parent();
	$parent.find('.update-checked').remove();
	$parent.append('<div class="loader medium-loader"></div>');
	$.get(window.baseURL+'maintenance/update/index', function(html){
		$(html).popup();
		$parent.find('.loader').remove();
		$parent.append('<span class="update-checked"><i class="fa fa-check"></i> mise à jour effectuée</span>');
	});
});