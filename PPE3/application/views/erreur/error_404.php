<?php $this->load->helper('url');?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<link rel="stylesheet" href="<?php echo base_url("asset/css/include.css"); ?>" />
	<title>erreur 404</title>
</head>
<body>
	<div id="Block404">
		<div><?php echo anchor(site_url(""), "revenir", array("class"=>"lien"));?></div>
		<div>ERREUR 404</div>
		<div id='lien404'>L'url: <span id='url404'><?php echo current_url(); ?></span> n'existe pas</div>
	</div>	
</body>
</html>