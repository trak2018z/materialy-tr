<div class="content">
    <header>
        <h1>Rejestracja konta dla studentów</h1>
    </header>
    <main class="main p20">
        <form action="<?=$this->url('/user/register/student') ?>" method="post">
            <label>
                Nazwa kierunku:
                <input type="text" name="kierunek" placeholder="Wpisz nazwę kierunku..." value="<?=$form['fields']['kierunek']?>"/>
            </label>
            <p class="formError"><?=$form['info']['kierunek']?></p>
            <label>
                Skrót kierunku:
                <input type="text" name="skrot" placeholder="Wpisz skrót kierunku..." value="<?=$form['fields']['skrot']?>"/>
            </label>
            <p class="formError"><?=$form['info']['skrot']?></p>
            <label>
                Hasło:
                <input type="password" name="haslo" placeholder="Wpisz hasło..." value="<?=$form['fields']['haslo']?>"/>
            </label>
            <p class="formError"><?=$form['info']['haslo']?></p>
            <label>
                Login:
                <input type="text" name="login" id="login" placeholder="Wpisz login..." value="<?=$form['fields']['login']?>"/>
            </label>
            <p class="formError"><?=$form['info']['login']?></p>
            <label>
               <input type="submit" value="Rejestruj"/>
            </label>
            <div class="clear"></div>
        </form>
    </main>
</div>