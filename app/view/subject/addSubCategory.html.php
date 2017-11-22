<div class="content">
    <header>
    	<h1>Dodaj podkategorię</h1>
        <a title="Wróć" class="floatMenu circle bOrange" href="<?=$this->url('/subject/'.$idPrzedmiot.'/view'); ?>"><i class="fa fa-mail-reply"></i></a>
    </header>
    <main class="main p20">
        <form action="<?=$this->url('/subject/'.$idPrzedmiot.'/subcategory/'.$idKategoria.'/add') ?>" method="post">
        	<label>
        		Nazwa:
        		<input type="text" name="nazwa" placeholder="Wpisz nazwę..." value="<?=$form['fields']['nazwa']?>"/>
        	</label>
            <p class="formError"><?=$form['info']['nazwa']?></p>
            <label>
        	   <input type="submit" value="Dodaj"/>
            </label>
            <div class="clear"></div>
        </form>
    </main>
</div>