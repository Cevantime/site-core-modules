var $ = require('jquery');
global.jQuery = $;
require('bootstrap');

function parseModal() {
	$('.confirm').click(function (e) {
		var url = $(this).data('url');
		var body = $(this).data('body');
		var header = $(this).data('header');
		var $modal = $('#modal-from-dom');
		$modal.modal('show');
		var $removeBtn = $modal.find('.btn-danger');
		$removeBtn.attr('href', url);

		var $body = $modal.find(".modal-body");
		$body.html(body);

		var $header = $modal.find(".modal-header h3");
		$header.html(header);
		return false;
	});
}
$(function () {
	parseModal();
	$(document).ajaxComplete(parseModal);
});