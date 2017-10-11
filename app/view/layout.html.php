<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>System udostępniania materiałów</title>
		<link rel="stylesheet" href="<?=$this->assets('/web/css/style.css')?>"/>
		<script src="<?=$this->assets('/web/js/jquery-1.10.2.js')?>"></script>
 		<script src="<?=$this->assets('/web/js/main.js')?>"></script>
	</head>
	<body>
		<nav class="main">
				<div class="logo fL">
					<p></p>
					<div class="circle"><i class="fa fa-user"></i></div>
					<ul class="dropdownMenu">
						<li><a href="<?=$this->url('/user/setting') ?>">Profil</a></li>
						<li><a href="<?=$this->url('/logout') ?>">Wyloguj</a></li>
					</ul>
				</div>
			<ul class="m20">
				<li><a href="<?=$this->url('/home') ?>">Strona główna</a></li>
					<li><a href="<?=$this->url('/subject/show') ?>">Przedmioty</a></li>
					<li><a href="<?=$this->url('/login') ?>">Zaloguj</a></li>	
			</ul>
		</nav>
		<aside class="informations bgDanger">
			<noscript><p class="error"><p>Twoja przeglądarka nie obsługuje JavaScript.<br />Prosimy o włączenie JavaScript w celu poprawnego działania strony.</p></noscript>
		</aside>
		<?php $this->inc($content); ?>
		<footer class="main">&copy; <?=date('Y');?> Paweł Wolak | <a href="<?=$this->url('/contact') ?>">Kontakt</a></footer>
	</body>
</html>



