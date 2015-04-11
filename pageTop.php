<?php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	include "includes/db_common.php";
?>
<!doctype html>
<html lang="en">
<head>
	<title>Streamero</title>
	<link rel="stylesheet" media="screen and (max-width: 960px)" href="/css/mobile.css" />
	<link rel="stylesheet" media="screen and (min-width: 961px)" href="/css/global.css" />
	<meta name="viewport" content="width=device-width" />
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	<script type="text/javascript" src="http://a.vimeocdn.com/js/froogaloop2.min.js"></script>
	<script type="text/javascript" src="/js/global.js"></script>
	<script type="text/javascript" src="/js/swfobject.js"></script>

	<script>
  	//add some jquery functionality to the main movie list
		$( document ).ready(function() {
		  $(".movie_list").sortable({
		  	  cursor: 'move',
			  stop: function( event, ui ) {
				  updateMovieList();
			  }
			});

			$('.movie_list li .move_to_top').live('click', function() {
			    $(this).closest("li").prependTo('.movie_list ');
			    updateMovieList();
			});

			$('.movie_list li .move_to_bottom').live('click', function() {
			    $(this).closest("li").appendTo('.movie_list ');
			    updateMovieList();
			});
		});

		function updateMovieList() {
			var data = $('.movie_list').sortable('serialize');
			// console.log(data);
			$.ajax({
				type: "POST",
				url: "/ajax/reorderMovies.php",
				data: data,
				success: function(data)
				{
					//alert(data);
				}
			});
		}
	</script>

	<style type="text/css">
		.clearfix:after {
		content: ".";
		display: block;
		height: 0;
		clear: both;
		visibility: hidden;
		}
	</style>

	<!--[if IE]>
		<style type="text/css">
			.clearfix {
			zoom: 1;     /* triggers hasLayout */
			display: block;     /* resets display for IE/Win */
			}  /* Only IE can see inside the conditional comment
			and read this CSS rule. Don't ever use a normal HTML
			comment inside the CC or it will close prematurely. */
		</style>
	<![endif]-->

</head>
<body class="<?= $page_class ?>">
	<h1 class="rolling home_logo" >
		<a href="/"><span class="logo_0">stream</span><span class="logo_1">e</span><span class="logo_2">r</span><span class="logo_3">o</span></a>
	</h1>
	<div id="main_menu">
		<a href="watch.php">watch</a>
		<a href="about.php">about</a>
		<?php if ($loggedIn):?>
			<a href="addMovie.php">add video</a>
			<a href="/">my videos</a>
			<a href="profile.php">profile</a>
			<a href="logout.php">logout</a>
		<?php else: ?>
			<a href="register.php">register</a>
			<a href="login.php">login</a>
		<?php endif;?>
	</div>
