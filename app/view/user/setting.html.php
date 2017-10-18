<div class="content">
    <header>
          <h1>Twój profil</h1>
        <ul class="floatMenu">
            <li><a title="Zmień hasło." class="circle bOrange" href="<?=$this->url('/user/setting/password'); ?>"><i class="fa fa-key"></i></a></li>
        </ul>
    </header>
    <main class="main p20">
          <form action="<?=$this->url('/user/setting') ?>" method="post">
            <label>
                Imie:
                <input type="text" name="imie" value="<?=$_SESSION['user']['imie']?>" />                
            </label>
            <p class="formError"><?=$form['info']['imie']?></p>
            <label>
                Nazwisko:
                <input type="text" name="nazwisko" value="<?=$_SESSION['user']['nazwisko']?>" />
            </label>
            <p class="formError"><?=$form['info']['nazwisko']?></p>
            <label>
                <input type="submit" name="aktualizuj" value="Aktuzalizuj"/>
            </label>
            <div class="clear"></div>
        </form>
    </main>
</div>