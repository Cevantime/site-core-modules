<script>
	contexts = {};
</script>
<p class="actions">
	<a class="btn btn-danger confirm"
	   data-url="<?php echo base_url('traductions/index/cleanup'); ?>" 
	   data-header="Nettoyage des traductions" 
	   data-body="<p>Attention!</p><p>Cette opération a pour but de supprimer toutes les traductions non utilisées.</p><p>Continuer?</p>" class="btn btn-danger confirm">Nettoyer les traductions</a>
</p>
<form action="<?php echo base_url('traductions/index/merge'); ?>" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label>Ajouter un fichier de traduction</label>
		<span class="input-group">
			<span class="input-group-btn">
				<span class="btn btn-primary btn-file">
					Parcourir…
					<input type="file" name="translatemerge" id="translatemerge" class="form-control file"/>
				</span>
			</span>
			<input type="text" readonly="" class="form-control">
		</span>
	</div>
	<div class="form-group">
		<input type="submit" class="btn btn-primary" id="translate" name="translate" value="<?php echo translate("Ajouter"); ?>"/>
	</div>
</form>
<form action="<?php echo base_url('traductions/index/save'); ?>" method="post">
	<div class="form-group">
		<div class="row">
			<div class="col-md-6">
				<?php echo form_dropdown(array('class' => 'form-control', 'id' => 'lang', 'name' => 'lang'), array('fr' => 'Français', 'en' => 'Anglais', 'ru' => 'Russe'), $lang); ?>
			</div>
			<div class="col-md-6">
				<input type="checkbox" id="display-excluded"> <label for="display-excluded">Afficher les segments déjà traduits</label> <br>
				<input type="checkbox" id="display-ignored"> <label for="display-ignored">Afficher les segments ignorés</label>
			</div>
		</div>
	</div>

	<?php foreach ($fullTrads as $file): ?>
		<?php foreach ($file as $id => $trad): ?>
			<div class="form-group translate<?php if (isset($trad['ignored'][$lang]) && $trad['ignored'][$lang]): ?> ignored<?php endif; ?><?php if (isset($trad['excluded'][$lang]) && $trad['excluded'][$lang]): ?> excluded<?php endif; ?>">
				<label>
					<?php echo htmlspecialchars(translate($trad['origin']), ENT_QUOTES, 'utf-8', false); ?> <a onclick="displayContext('<?php echo $id; ?>'); return false;">Contexte</a>
				</label>
				<script>contexts['<?php echo $id; ?>'] = '<?php echo str_replace("\n",'\\n\\',addslashes($trad['context'])); ?>'</script>
				<textarea id="<?php echo $id; ?>" class="form-control" name="<?php echo $id; ?>"><?php echo isset($trad['traductions'][$lang]) ? $trad['traductions'][$lang] : (isset($trad['ignored'][$lang]) && $trad['ignored'][$lang] ? '' : $trad['origin']); ?></textarea>
				<input type="checkbox" class="ignorer" id="ignore-<?php echo $id; ?>" value="1" name="ignore-<?php echo $id; ?>"<?php echo isset($trad['ignored'][$lang]) && $trad['ignored'][$lang] ? ' checked' : ''; ?>/> <label for="ignore-<?php echo $id; ?>">Ignorer</label> 
				<input type="checkbox" class="excluder" id="exclude-<?php echo $id; ?>" value="1" name="exclude-<?php echo $id; ?>"<?php echo isset($trad['excluded'][$lang]) && $trad['excluded'][$lang] ? ' checked' : ''; ?>/> <label for="exclude-<?php echo $id; ?>">Marquer comme traduit</label> 
			</div>
		<?php endforeach; ?>
	<?php endforeach; ?>
	<input type="submit" class="btn btn-primary" id="translate" name="translate" value="<?php echo translate("Traduire"); ?>"/>
</form>

<script>
	$('#lang').change(function () {
		window.location = "<?php echo base_url(); ?>traductions/index/translate/" + $(this).val();
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

	function displayContext(contextId) {
		var $context = $('<div>'+contexts[contextId]+'</div>');
		$context.find('tradwrap').css('color', 'red');
		var popup = window.open(null, 'Traduction context', "height=300,width=300");

		popup.document.write($context.html());
	}
</script>
