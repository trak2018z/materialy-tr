<div class="content small">
    <header>
    	<h1>Logowanie</h1>
    </header>
    <div class="main p20">
        <form action="<?=$this->url('/login') ?>" method="post" class="flexible">
        	<label>
        		<input type="text" name="login" placeholder="Wpisz login..." value="<?=$form['fields']['login']?>"/>
        	</label>
            <p class="formError"><?=$form['info']['login']?></p>
        	<label>
        		<input type="password" name="haslo" placeholder="Wpisz hasło..." value="<?=$form['fields']['haslo']?>"/>
        	</label>
            <p class="formError"><?=$form['info']['haslo']?></p>
            <label>
                <input type="submit" name="zaloguj" value="Zaloguj"/>
            </label>
            <div class="clear"></div>
        </form>
    </div>
</div>