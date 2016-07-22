
<?php 
	function sliderVal($datas, $key) {
		if(!isset($datas) || !isset($datas[$key])|| !$datas[$key]) return '';
		return $datas[$key];
	}
?>
<?php $this->load->helper('form'); ?>
<div class="row save-post">
	<div class="col-lg-9 col-md-12 main-content">
		<form class="form_add_blogpost" action="<?php echo current_url(); ?>" method="post" enctype="multipart/form-data">
			<?php if(is_module_installed('traductions')): ?>
			<div  class="form-group">
				<?php echo form_dropdown(array('class'=>'form-control', 'id'=>'lang', 'name'=>'lang'), array('fr'=>'Français','en'=>'Anglais','ru'=>'Russe'), $lang) ;?>
				<script type="text/javascript">
				$('#lang').change(function(){
					window.location = "<?php echo current_url(); ?>?lang="+$(this).val();
				});
				</script>
			</div>
			<?php endif; ?>
			<div class="form-group">
				<label for="InputPosition">Titre</label>
				<input class="form-control" type="text" name="title" value="<?php echo sliderVal($datas,'title') ?>" />
			</div>
			<div class="form-group">
				<label for="InputPosition">Description</label>
				<input class="form-control" type="text" name="desc" value="<?php echo sliderVal($datas,'desc') ?>" />
			</div>
			<div class="form-group">

				<label for="InputImage">Image <small class="bg-info">les dimensions doivent être comprises entre 500 et 2000 pixels</small></label>
				<span class="input-group">
					<span class="input-group-btn">
						<span class="btn btn-primary btn-file">
							Parcourir…
							<input type="file" id="InputImage" name="imageName" class="form-control file">
						</span>
					</span>
					<input type="text" readonly="" class="form-control">
				</span>
			</div>
			
			
			<input type="hidden" name="save-slide" value="1"/>
			<?php if(sliderVal($datas, 'id')): ?>
			<input type="hidden" name="id" value="<?php echo sliderVal($datas,'id'); ?>"/>
			<?php endif; ?>
			
			<button class="btn btn-primary"><i class="fa fa-save"></i> Enregistrer</button> <br/><br/>
			<a href="<?php echo base_url($redirect); ?>" class="btn btn-primary">Revenir à la liste des slides</a>
		</form>
	</div>
</div>
