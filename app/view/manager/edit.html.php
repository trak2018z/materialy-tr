<div class="content">
    <header>
        <h1>Użytkownik <?=$usr->login ?> - Edycja</h1>
        <a title="Wróć" class="floatMenu circle bOrange" href="<?=$this->url('/manager/view'); ?>"><i class="fa fa-mail-reply"></i></a>
    </header>
    <main class="main p20">
    <form action="<?=$this->url('/manager/'.$usr->idUzytkownik.'/edit') ?>" method="post">
        <?php if($usr->typ_konta == 'teacher' || $usr->typ_konta == 'admin'):?>
        <label>
            Imie:
            <input type="text" name="imie" value="<?=$usr->imie ?>"/>
        </label>
        <?php endif;?>
        <?php if($usr->typ_konta == 'teacher' || $usr->typ_konta == 'admin'):?>
        <label>
            Nazwisko:
            <input type="text" name="nazwisko" value="<?=$usr->nazwisko ?>"/>
        </label>
        <?php endif;?>
        <?php if($usr->typ_konta == 'student'):?>
        <label>
            Nazwa kierunku:
            <input type="text" name="nazwa" value="<?=$usr->nazwa ?>"/>
        </label>
        <?php endif;?>
        <?php if($usr->typ_konta == 'student'):?>
        <label>
            Skrót:
            <input type="text" name="skrot" value="<?=$usr->skrot ?>"/>
        </label>
        <?php endif;?>
        <label>
            Typ konta:
            <select name="typ_konta">
                <option value="admin" <?php if($usr->typ_konta == 'admin') echo 'selected="selected"'; ?>>Administrator</option>
                <option value="student" <?php if($usr->typ_konta == 'student') echo 'selected="selected"'; ?>>Student</option>
                <option value="teacher" <?php if($usr->typ_konta == 'teacher') echo 'selected="selected"'; ?>>Nauczyciel</option>
            </select>   
        </label>
        <p class="formError"><?=$form['info']['typ_konta']?></p>
        <label>
            Hasło:
            <input type="password" name="haslo" />
        </label>
        <label>
            <input type="submit" value="Zapisz"/>
        </label>
        <div class="clear"></div>
    </form>
    </main>
</div>