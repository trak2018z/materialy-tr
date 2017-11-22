<div class="content">
    <header>
    	<h1>Dodaj nowy przedmiot</h1>
        <ul class="floatMenu">
            <li><a title="Wróć" class="circle bOrange" href="<?=$this->url('/subject/show'); ?>"><i class="fa fa-mail-reply"></i></a></li>
        </ul>
    </header>
    <main class="main p20">
        <form action="<?=$this->url('/subject/add') ?>" method="post">
        	<label>
        		Nazwa przedmiotu:
        		<input type="text" name="nazwa" placeholder="Wpisz nazwę przedmiotu..." value="<?=$form['fields']['nazwa']?>"/>
        	</label>
            <p class="formError"><?=$form['info']['nazwa']?></p>
        	<label>
                Grupa studentów:
        		<select name="uzytkownik">
                    <?php foreach ($users as $value): ?>
                        <option value="<?=$value->idUzytkownik?>"><?=$value->nazwa?> (<?=$value->skrot?>)</option>
                    <?php endforeach; ?>      
                </select>
        	</label>
            <label>
        	   <input type="submit" value="Dodaj"/>
            </label>
            <div class="clear"></div>
        </form>
    </main>
</div>