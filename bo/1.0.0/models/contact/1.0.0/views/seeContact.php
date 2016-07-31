<script type="text/javascript" src=<?php echo base_url("/js/contact/jqBootstrapValidation.js"); ?> ></script>
 <script type="text/javascript" src=<?php echo base_url("/js/contact/contact_me.js"); ?> ></script>

<br/><br/>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="section-title no-margin-top">Envoyer un Message</h2>
        </div>
        <div class="col-md-8">
            <section>
                <p>Besoin de renseignements ? <br/> Demande Propal pour les professionnels ?  <br/>Contactez nous !</p>

                <form role="form" name="sentMessage" id="contactForm"   >
                    <div class="form-group control-group">
						 <div class="controls">
                        <label for="InputName">Nom</label>
                        <input type="text" class="form-control" id="InputName" required data-validation-required-message="Entrez votre nom SVP">
						 <p class="help-block"></p>
						 </div>
                    </div>
                    <div class="form-group control-group">
						 <div class="controls">
                        <label for="InputEmail1">Adresse Mail</label>
                        <input type="email" class="form-control" id="InputEmail1"  required data-validation-required-message="Indiquez votre email !">
						 </div>
                    </div>
                    <div class="form-group control-group">
						 <div class="controls">
                        <label for="InputMessage">Message</label>
                        <textarea class="form-control" id="InputMessage" rows="8" required data-validation-required-message="Entrez votre message" maxlength="999" style="resize:none"></textarea>
						 </div>
				    </div>
					
					
					<div id="success"></div>
                    <button type="submit" class="btn btn-ar btn-primary">Envoyer</button>
                    <div class="clearfix"></div>
                </form>
            </section>
        </div>

        <div class="col-md-4">
            <section>
                <div class="panel panel-primary">
                    <div class="panel-heading"><i class="fa fa-envelope-o"></i>Informations</div>
                    <div class="panel-body">
                        <h4 class="section-title no-margin-top">Contacts</h4>
                        <address>
                            <strong><?php echo $name; ?></strong><br>
                            <?php echo $street; ?><br>
                            <?php echo $city; ?><br>
                            <abbr title="Phone">P:</abbr><?php echo $phone; ?><br>
                            Mail: <a href="#"><?php echo $mail; ?></a>
                        </address>

                        <!-- Business Hours -->
                        <h4 class="section-title no-margin-top">Heures d'ouverture</h4>
                        <ul class="list-unstyled">
                            <li><strong>Monday-Friday:</strong> 9am to 7pm</li>
                            <li><strong>Saturday:</strong> 9am to 2pm</li>
                            <li><strong>Dimanche:</strong> Fermé</li>
                        </ul>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <hr class="dotted">

    <section>
        <div class="well well-sm">
           <!--<iframe width="100%" height="350" src="http://maps.google.com/maps?hl=en&q=CarsLogistics %26Carcassonne%26 296 Route Minervoise&ie=UTF8&z=15&t=roadmap&iwloc=B&output=embed"></iframe>
		 <iframe width="100%" height="350" src="http://maps.google.com/maps?hl=fr&q=<?php echo $adress; ?>&ie=UTF8&z=<?php echo $zoom; ?>5&t=roadmap&iwloc=B&output=embed"></iframe>
		   <iframe width="100%" height="350" src="http://maps.google.com/maps?hl=fr&q=<?php echo $adress; ?>&ie=UTF8&z=<?php echo $zoom; ?>&t=roadmap&iwloc=B&output=embed"></iframe>
		   
		   <iframe width="100%" height="350" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q=Taurisano%20alexandre%205%20rue%20sus%20carrieras%2011190%20antugnac&key=AIzaSyAhzYF47lvKzztFfva_6mdufNOvH6z-LBQ " allowfullscreen></iframe> -->
		    <iframe width="100%" height="350" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q=<?php echo $map_adress; ?>&key=AIzaSyAhzYF47lvKzztFfva_6mdufNOvH6z-LBQ " allowfullscreen></iframe> 
		
		</div>			
	 </section>
</div> <!-- container -->