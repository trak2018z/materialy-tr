<div class="content">
    <header>
    	<h1>Rejestracja konta dla nauczycieli</h1>
    </header>
    <main class="main p20">
        <form action="<?=$this->url('/user/register/teacher') ?>" method="post">
        	<label>
        		Imie:
        		<input type="text" onchange="inner();" name="imie" id="imie" placeholder="Wpisz imię..." value="<?=$form['fields']['imie']?>"/>
        	</label>
            <p class="formError"><?=$form['info']['imie']?></p>
        	<label>
        		Nazwisko:
        		<input type="text" onchange="inner();" name="nazwisko" id="nazwisko" placeholder="Wpisz nazwisko..." value="<?=$form['fields']['nazwisko']?>"/>
        	</label>
            <p class="formError"><?=$form['info']['nazwisko']?></p>
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