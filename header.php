<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">
	<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/style-vinc.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

	<?php 
		global $idPage;
		if ( $idPage == "index" )
		{
			echo '<style type="text/css">#lnkLinks{text-decoration : underline !important;}</style>';
			echo '<script type="text/javascript" src="js/functions.js"></script>';
		}
		else if ( $idPage == "pix" )
		{
			echo '<style type="text/css">#lnkPix{text-decoration : underline !important;}</style>';
			echo '<script type="text/javascript" src="js/functions_pix.js"></script>';
		}
	?>
</head>
<body>
<!-- LIGTHBOX -->
<div id="lightbox">
	<div id="lbx_more_options">
		<span id="lbc_close" class="fright">X</span>
		<form onsubmit="lbx_opts(this); return false;" action="" method="POST">	
			<div class="lbx_margin clearfix">
				<label for="">Nombre de tweets : </label>
				<input type="number" value="5" min="0" max="49" name="opt_nb_tweets" />
			</div>
			<div class="lbx_margin clearfix">
				<label for="">Tweets localisé ? : </label>
				<input type="checkbox" name="opt_twt_geoloc" value="1" />
			</div>
			<div class="lbx_margin clearfix">
				<label for="">langue Comming sooon...</label>
			</div>
			<input type="submit" value="GoGo..." class="fright"/>
		</form>
	</div>
</div>
<!-- /LIGTHBOX -->
<div id="wrapper" class="limitWidth">
	<div id="blockBanner">
		<div id="blockTitle">
			<h1>TweetCast</h1>
			<h2><a href="index.php" id="lnkLinks">Link</a> - <a href="pix.php" id="lnkPix">Pix</a></h2>
		</div>
		<div id="blockMenu">
			<a class="btn btn--add noPadding" href="index.php"><span>50 Dernières</span></a>
			<a class="btn btn--add noPadding" href=#><span>Trier par favoris</span></a>
			<a class="btn btn--add noPadding" href=#><span>Trier par Retweet</span></a>
		</div>
	</div>
	<div id="blockSearch">
		<input autocomplete="on" type="search" id="hashSearch" name="hashSearch" value="liberation" />
		<button id="btnSearch" name="btnSearch">
			<img src="css/images/search-icon.png" title="Search" />
		</button>
		<div id="more_options_wrapper">
			<span id="more_options">Plus d'options</span>
		</div>
	</div>
