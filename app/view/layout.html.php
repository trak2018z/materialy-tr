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
			<?php if (!empty($user)): ?>
				<div class="logo fL">
					<p><?php if($user['typ_konta'] == 'teacher' || $user['typ_konta'] == 'admin') echo $user['imie'] . ' ' . $user['nazwisko']; else echo $user['nazwa'] . ' ( '.$user['skrot'].' )';?></p>
					<div class="circle"><i class="fa fa-user"></i></div>
					<ul class="dropdownMenu">
						<li><a href="<?=$this->url('/user/setting') ?>">Profil</a></li>
						<li><a href="<?=$this->url('/logout') ?>">Wyloguj</a></li>
					</ul>
				</div>
			<?php endif; ?>
			<ul class="m20">
				<li><a href="<?=$this->url('/home') ?>">Strona główna</a></li>
				<li><a href="<?=$this->url('/subject/show') ?>">Przedmioty</a></li>
				<?php if (empty($user)): ?>
					<li><a href="<?=$this->url('/login') ?>">Zaloguj</a></li>	
				<?php endif; ?>
				<?php if ($this->hasAccess('manager_view')): ?>
					<li><a href="<?=$this->url('/manager/view') ?>">Uzytkownicy</a></li>
				<?php endif; ?>
			</ul>
		</nav>
		<aside class="informations bgDanger">
			<noscript><p class="error"><p>Twoja przeglądarka nie obsługuje JavaScript.<br />Prosimy o włączenie JavaScript w celu poprawnego działania strony.</p></noscript>
		</aside>
		<?php if (isset($error) || isset($success)): ?>
			<aside class="informations <?=(isset($error)?'bgDanger':'bgSuccess') ?>">
				<p>
					<?php if (isset($error)): ?><?=$error?><?php endif; ?>
					<?php if (isset($success)): ?><?=$success?><?php endif; ?>
				</p>
				<span class="closeInformations"><i class="fa fa-close"></i></span>
			</aside>
        <?php elseif (false === empty($form['info'])): ?>
            <aside class="informations <?=((false === $form['info']['_success'])?'bgDanger':'bgSuccess') ?>">
                <p>
                    <?=$form['info']['_html']?>
                </p>
                <span class="closeInformations"><i class="fa fa-close"></i></span>
            </aside>
		<?php endif; ?>
		<?php $this->inc($content); ?>
		<footer class="main">&copy; <?=date('Y');?> Paweł Wolak | <a href="<?=$this->url('/contact') ?>">Kontakt</a></footer>
	</body>
</html>



