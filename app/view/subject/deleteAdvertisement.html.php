<div class="content">
    <header>
    	<h1>Potwierdz usunięcie ogłoszenia</h1><h2><?=$advertisement->tytul?></h1>
        <a title="Wróć" class="floatMenu circle bOrange" href="<?=$this->url('/subject/'.$id.'/view'); ?>"><i class="fa fa-mail-reply"></i></a>
    </header>
    <main class="main p20">
        <form action="<?=$this->url('/subject/'.$id.'/advertisement/'.$id2.'/delete') ?>" method="post">
            <label>
        	   <input type="submit" value="Kasuj" name="potwierdz" class="fl"/>
            </label>
            <div class="clear"></div>
        </form>
    </main>
</div>