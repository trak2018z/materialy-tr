<div class="content">
    <header>
    	<h1>Potwierdz usunięcie przedmiotu</h1><h2><?=$subject->nazwa?></h2>
    </header>
    <main class="main p20">
        <form action="<?=$this->url('/subject/'.$id.'/delete') ?>" method="post">
            <label>
        	   <input type="submit" value="Kasuj" name="potwierdz"/>
            </label>
            <div class="clear"></div>
        </form>
    </main>
</div>