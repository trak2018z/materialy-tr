<div class="content">
    <header>
    	<h1>Dodaj prowadzącego do przedmiotu</h1>
        <a title="Wróć" class="floatMenu circle bOrange" href="<?=$this->url('/subject/'.$id.'/view'); ?>"><i class="fa fa-mail-reply"></i></a>
    </header>
    <main class="main p20">
        <form action="<?=$this->url('/subject/'.$id.'/leader/add') ?>" method="post">
        	<label>Nauczyciele:<select name="nauczyciel">
                    <?php foreach ($users as $value): ?>
                        <?php if($value->idUzytkownik == $_SESSION['user']['idUzytkownik']) continue; ?>
                        <option value="<?=$value->idUzytkownik?>"><?=$value->imie?> <?=$value->nazwisko?></option>
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