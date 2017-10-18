<div class="content">
    <header>
        <h1>Zmiana hasła</h1>
        <ul class="floatMenu">
            <li><a title="Wróć" class="circle bOrange" href="<?=$this->url('/user/setting'); ?>"><i class="fa fa-mail-reply"></i></a></li>
        </ul>
    </header>
    <main class="main p20">
        <form action="<?=$this->url('/user/setting/password') ?>" method="post">
            <label>
                Stare hasło:
                <input type="password" name="stare_haslo" placeholder="Wpisz stare hasło" />
            </label>
            <p class="formError"><?=$form['info']['stare_haslo']?></p>
            <label>
                Nowe hasło:
                <input type="password" name="nowe_haslo" placeholder="Wpisz nowe hasło" />
            </label>
            <p class="formError"><?=$form['info']['nowe_haslo']?></p>
            <label>
                Powtórz hasło:
                <input type="password" name="powtorne_haslo" placeholder="Powtórz nowe hasło"  />
            </label>
            <p class="formError"><?=$form['info']['powtorne_haslo']?></p>
            <label>
                <input type="submit" name"aktualizuj" value="Zmień"/>
            </label>
            <div class="clear"></div>
        </form>
    </main>
</div>