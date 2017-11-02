var $ = window.jQuery || require('jquery');

$('#lang').change(function () {
	window.location = window.baseURL+"traductions/index/translate/" + $(this).val();
});
$('.excluder').change(function () {
	var $this = $(this);
	var isChecked = $this.is(':checked');

	var $formGroup = $this.closest('.form-group.translate');
	$formGroup.removeClass('ignored');
	if (isChecked) {
		$formGroup.slideUp(function () {
			$(this).addClass('excluded')
		});
		$formGroup.find('.ignorer').prop('checked', false);
	} else {
		$formGroup.slideDown(function () {
			$(this).removeClass('excluded')
		});
	}
});
$('.ignorer').change(function () {
	var $this = $(this);
	var isChecked = $this.is(':checked');

	var $formGroup = $this.closest('.form-group.translate');
	$formGroup.removeClass('excluded')
	if (isChecked) {
		$formGroup.find('textarea').text('');
		$formGroup.slideUp(function () {
			$(this).addClass('ignored')
		});
		$formGroup.find('.excluder').prop('checked', false);
	} else {
		$formGroup.slideDown(function () {
			$(this).removeClass('ignored')
		});
	}
});
$('#display-excluded').change(function () {
	var $this = $(this);
	var isChecked = $this.is(':checked');
	if (isChecked) {
		$('.form-group.translate.excluded').slideDown();
	} else {
		$('.form-group.translate.excluded').slideUp();
	}
});
$('#display-ignored').change(function () {
	var $this = $(this);
	var isChecked = $this.is(':checked');
	if (isChecked) {
		$('.form-group.translate.ignored').slideDown();
	} else {
		$('.form-group.translate.ignored').slideUp();
	}
});

$('.bt-context').click(function(){
	displayContext($(this).data('id'));
});

function displayContext(contextId) {
	var $context = $('<div>' + window.contexts[contextId] + '</div>');
	$context.find('tradwrap').css('color', 'red');
	var popup = window.open(null, 'Traduction context', "height=300,width=300");

	popup.document.write($context.html());
}