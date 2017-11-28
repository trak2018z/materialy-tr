<div class="content">
    <header>
    	<h1>Dodaj ogłoszenie</h1>
        <a title="Wróć" class="floatMenu circle bOrange" href="<?=$this->url('/subject/'.$id.'/view'); ?>"><i class="fa fa-mail-reply"></i></a>
    </header>
    <main class="main p20">
        <form action="<?=$this->url('/subject/'.$id.'/advertisement/add') ?>" method="post">
        	<label>
        		Tytuł:
        		<input type="text" name="tytul" placeholder="Wpisz tytuł..." value="<?=$form['fields']['tytul']?>"/>
        	</label>
            <p class="formError"><?=$form['info']['tytul']?></p>
            <label>
                Treść:
                <textarea name="tresc" maxlength="200" placeholder="<?php if(!empty($form['fields']['tresc'])): echo $form['fields']['tresc']; else: ?>Wpisz treść...<?php endif;?>"></textarea>
            </label>
            <p class="formError"><?=$form['info']['tresc']?></p>
            <label>
        	   <input type="submit" value="Dodaj"/>
            </label>
            <div class="clear"></div>
        </form>
    </main>
</div>