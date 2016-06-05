<h2>
	Le site est actuellement en maintenance. Vous devez être administrateur pour y accéder.
</h2>
<form role="form" method="post" action="<?php echo current_url(); ?>">

	<span class="input-group-addon"><i class="fa fa-user"></i></span>
	<input type="text" name="login" placeholder="Votre nom d'utilisateur">

	<span class="input-group-addon"><i class="fa fa-lock"></i></span>
	<input type="password" placeholder="Password" name="password">

	<input type="hidden" name="login-user" value="1"/>
	<button type="submit">Se connecter</button>

</form>
