<html>
<head>
	<link rel="stylesheet" href="<?php echo base_url("asset/css/login.css"); ?>" />
	<title><?php echo $titre;?></title>
</head>
<body>
	<div class="module form-module">
		<div id="haut"><h2>Identifiez vous</h2></div>
		<?php echo $erreur; ?>
		<?php 
			$attributes = array('class' => 'login', 'id' => 'login');
			echo form_open('login/connect', $attributes)."
		";
			
			$loginInfo = array(
              'name'        => 'login',
              'id'          => 'login',
              'value'       => set_value('login'),
              'maxlength'   => '100',
				'placeholder' => "Votre login"
            );

			echo "<br><div id='ligneInput'><span id='info'>Login:</span>".form_input($loginInfo)."</div>
              		";
			$passeInfo = array(
					'name'        => 'passe',
					'id'          => 'passe',
					'value'       => '',
					'maxlength'   => '255',
					'placeholder' => "Votre mot de passe"
			);
			echo "<br><div id='ligneInput'><span id='info'>Mot de passe:</span>".form_password($passeInfo)."</div>
							";
			$submitInfo = array(
					
					'value' => 'envoyer'
			);
			echo "<br><div id='ligneInput'>".form_submit($submitInfo)."</div>
					";
			echo form_close();
		?>
	</div>

</body>
</html>