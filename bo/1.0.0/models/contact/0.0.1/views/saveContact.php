
<?php $CI =& get_instance(); $CI->load->helper('form'); ?>

<h1> Editer les informations du contact </h1><br/><br/>

<form role="form" method="post" action="<?php echo base_url('contact/contactbo/save'); ?>">
	<div class="row">
		<div class="col-md-6">
			<?php //$this->load->view('bo/expeditions/includes/expedition-details') ;?>
		</div>
	</div>
	<div class="form-group">
		<label for="InputName">Nom du contact</label>
		<input class="form-control" type="text" name="contact_name" value="<?php echo $values["contact_name"]; ?>"/>		
	</div>
	
	<div class="form-group">
		<label for="InputStreet"> Rue/Avenue</label>
		<input class="form-control" type="text" name="contact_street" value="<?php echo $values["contact_street"]; ?>"/>		
	</div>
	<div class="form-group">
		<label for="InputCity"> Code postal + ville</label>
		<input class="form-control" type="text" name="contact_city" value="<?php echo $values["contact_city"]; ?>"/>		
	</div>
	<div class="form-group">
		<label for="InputMail"> Email</label>
		<input class="form-control" type="text" name="contact_mail" value="<?php echo $values["contact_mail"]; ?>"/>		
	</div>
	<div class="form-group">
		<label for="InputPhone"> Téléphone</label>
		<input class="form-control" type="text" name="contact_phone" value="<?php echo $values["contact_phone"]; ?>"/>		
	</div>
	
	<!--<div class="form-group">
		<label for="InputNote">Note</label>
		<textarea class="form-control"id="InputNote" name="note"><?php echo set_value('note') ? set_value('note') : isset($pop_save_expedition['note']) ? $pop_save_expedition['note'] : ''; ?></textarea>
	</div>-->
	
	<div class="row">
<!--		<div class="col-md-8">
			<div class="checkbox checkbox-inline">
				<input type="checkbox" name="accepted_rules" id="inlineCheckbox1" value="1">
				<label for="inlineCheckbox1">J'accepte les <a href="#">conditions générales</a>.</label>
			</div>
		</div>-->
		<!--<input type="hidden" name="save-expedition" value="1"/>-->
		<div class="col-md-4">
			<button type="submit" class="btn btn-ar btn-primary">Valider</button> <a href="<?php echo base_url('bo/expeditions/all') ;?>" class="btn btn-primary">Revenir aux expéditions</a>
		</div>
	</div>
</form>