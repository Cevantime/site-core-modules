<form class="form_add_blogpost" action="<?php echo current_url(); ?>" method="post" enctype="multipart/form-data">
	<?php $this->load->view('blog/includes/basic-content'); ?>
	<p><input type="submit" value="Ajouter" name="blogpost_add"/></p>
	
</form>

<?php echo Modules::run('flashmessages/flashMessages/basicstyle'); ?>