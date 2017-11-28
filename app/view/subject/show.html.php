<div class="content">
    <header>
        <h1>Lista przedmiotów</h1>
        <?php if($user['typ_konta'] == 'teacher' || $user['typ_konta'] == 'admin'): ?>
            <a title="Dodaj przedmiot" class="floatMenu circle bOrange" href="<?=$this->url('/subject/add'); ?>"><i class="fa fa-plus"></i></a>
        <?php endif; ?>   
    </header>
    <main class="main p20">
        <?php if($user['typ_konta'] == 'admin'): ?>
            <h2>Wszystkie przedmioty: </h2>
        <?php else: ?>    
            <h2>Twoje przedmioty: </h2>
        <?php endif;?>
        <table id="subs">
            <tr>
                <td>
                    <form method="POST" action="<?=$this->url('/subject/search'); ?>" id="searchForm">
                        Wyszukaj: <input type="text" name="searchSubject">
                    </form>
                </td><td></td>
            <tr>
                <th>Nazwa przedmiotu</th>
                <th>Ostatnia aktualizacja przedmiotu</th>
            </tr>
        </table>
        <?php if($user['typ_konta'] == 'teacher'): ?>
        <hr>
        <h2>Prowadzone przedmioty:</h2>
        <table>
            <tr>
                <th>Nazwa przedmiotu</th>
                <th>Ostatnia aktualizacja przedmiotu</th>
            </tr>
                <?php foreach ($leaderSubject as $value): ?>
                    <tr>
                    <td><a href="<?=$this->url('/subject/'.$value->idPrzedmiot.'/view')?>"><i class="fa fa-graduation-cap fa-1x"></i> <?=$value->nazwa?></a></td>
                    <td><?=$value->aktualizacja?></td>
                    </tr>
                <?php endforeach; ?>
        </table>
        <?php endif;?>
    </main>
</div>