<div class="content">
    <header>
    	<h1>Potwierdz usunięcie prowadzącego</h1><h2><?=$advertisement->tytul?></h1>
    </header>
    <main class="main p20">
        <form action="<?=$this->url('/subject/'.$id.'/leader/'.$id2.'/delete') ?>" method="post">
            <label>
        	   <input type="submit" value="Kasuj" name="potwierdz"/>
            </label>
            <div class="clear"></div>
        </form>
    </main>
</div>