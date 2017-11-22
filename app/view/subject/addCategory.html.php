<div class="content">
    <header>
    	<h1>Dodaj kategorię</h1>
        <a title="Wróć" class="floatMenu circle bOrange" href="<?=$this->url('/subject/'.$id.'/view'); ?>"><i class="fa fa-mail-reply"></i></a>
    </header>
    <main class="main p20">
        <form action="<?=$this->url('/subject/'.$id.'/category/add') ?>" method="post">
        	<label>
        		Nazwa:
        		<input type="text" name="nazwa" placeholder="Wpisz nazwę..." value="<?=$form['fields']['nazwa']?>" />
        	</label>
            <p class="formError"><?=$form['info']['nazwa']?></p>
            <label>
        	   <input type="submit" value="Dodaj" class="fl"/>
            </label>
            <div class="clear"></div>
        </form>
    </main>
</div>