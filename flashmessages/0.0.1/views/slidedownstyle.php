
<style type="text/css">
	.admin-message {

		background: gray none repeat scroll 0 0;

		border-radius: 0 0 4px 4px;

		color: white;

		padding: 10px;

		position: absolute;

		top: -40px;

		right: 200px;

		opacity: 0;

		z-index: 10000;

		transition: all 0.5s 0s linear;

	}

	.admin-message.displayed {

		top: 0;

		opacity: 1;

	}

	.admin-message.error {

		background-color: #B82222

	}

	.admin-message.warning {

		background-color: #C7B123

	}

	.admin-message.success {

		background-color: #26A21B

	}

	.admin-message button {
		float: right;
		border: none;
		background: transparent;
	}

	.admin-message .admin-message-content {
		margin: 0;
	}

</style>
<div class="admin-message template">

	<button onclick="var $p = $(this).parent().removeClass('displayed');
			window.setTimeout(function () {
				$p.remove()
			}, 1000);">&Cross;</button>

	<p class="admin-message-content"></p>

</div>        

<script>

	$(function () {
		<?php if (isset($flashMessages) && $flashMessages): ?>
			<?php $nbFlashMessage = count($flashMessages); ?>
			<?php for ($i = $nbFlashMessage - 1; $i >= 0; $i--): ?>
				<?php $flashMessage = $flashMessages[$i]; ?>
				showAdminMessage('<?php echo str_replace("\n", "\\", trim(addslashes($flashMessage['content']))) ?>', '<?php echo addslashes($flashMessage['type']); ?>');
			<?php endfor; ?>
		<?php endif; ?>

	});

</script>

<script type="text/javascript">

	function showAdminMessage(message, type) {

		var $adminMessage = $('.admin-message.template').clone().removeClass('template');

		$adminMessage.find('.admin-message-content').html(message);

		$('body').append($adminMessage);

		window.setTimeout(function () {

			$adminMessage.addClass(type);

			$adminMessage.addClass('displayed');

		}, 1);

	}

</script>