<?php $this->load->view('flashmessages/includes/list-flash-messages'); ?>

<script type="text/javascript" src="<?php echo base_url('js/homePopup.js'); ?>"></script>
<script type="text/javascript">
	$(function(){$('.list-flash-messages').popup({id:'popup-flash-messages'})});
</script>
