<div class="container">
	
	<?php if($this->configuration->getValue('maintenance')): ?>
	<p>
		Le site est actuellement en mode privé. <a class="btn btn-primary" href="<?php echo base_url('maintenance/configure/turnoff'); ?>"><i class="fa fa-users"></i> Désactiver le mode privé</a>
	</p>
	<?php else: ?>
	<p>
		Le site est actuellement en mode public. <a class="btn btn-danger" href="<?php echo base_url('maintenance/configure/turnon'); ?>"><i class="fa fa-lock"></i> Activer le mode privé</a>
	</p>
	
	<?php endif; ?>
	<p data-module="modules/maintenance/update">
		Souhaitez vous mettre à jour le site ? <button class="btn btn-primary" id="site-full-update">Mettre à jour le site </button>
	</p>
	
</div>
