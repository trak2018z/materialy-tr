<div class="content">
    <header>
    <?php if($this->isStudent()): ?>
    <h1><?=$subject->nz ?></h1>
    <?php else: ?>
        <form action="<?=$this->url('/subject/'.$id.'/edit'); ?>" method="post" class="ajaxForm">
            <input type="text" name="nazwa" value="<?=$subject->nz ?>" class="ajaxForm" size="30"/>
        </form>
    <?php endif; ?> 
        <ul class="floatMenu">
            <li><a title="Wróć" class="circle bOrange" href="<?=$this->url('/subject/show'); ?>"><i class="fa fa-mail-reply"></i></a></li> 
        <?php if($user['typ_konta'] == 'teacher' || $user['typ_konta'] == 'admin'): ?>
             <li><a title="Usuń" class="circle bOrange" href="<?=$this->url('/subject/'.$id.'/confirm/delete'); ?>"><i class="fa fa-trash-o"></i></a></li>
             <li><a title="Prowadzący" class="circle bOrange" href="<?=$this->url('/subject/'.$id.'/leader/add'); ?>"><i class="fa fa-users"></i></a></li>
        <?php endif; ?>     
           </ul>
    </header>
    <main class="main p10">
        <div><header>
            <h1 class="title">Informacje:</h1>
            </header>
            <table>
                <tr>
                    <th><b>Koordynator przedmiotu</b></th>
                    <th><b>Prowadzący przedmiot</b></th>
                    <th><b>Nazwa kierunku</b></th>         
                    <th><b>Skrót kierunku</b></th> 
                    <th><b>Ostatnia aktualizacja</b></th> 
                </tr>
                <tr>
                    <td><?=$subject->imie ?> <?=$subject->nazwisko ?></td>
                    <td>
                        <ul>
                            <?php foreach ($leaders as $value): ?>
                                <li style="list-style-type:disc;">
                                <?=$value->imie ?> <?=$value->nazwisko ?>
                                <?php if($this->isAdmin() || $this->isTeacher()): ?>
                                <a title="kasuj" href="<?=$this->url('/subject/'.$id.'/leader/'.$value->idUzytkownik.'/delete'); ?>"><i class="fa fa-remove"></i></a>
                                <?php endif; ?> 
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </td>
                    <td><?=$usr->nazwa ?></td>         
                    <td><?=$usr->skrot ?></td> 
                    <td><?=$subject->aktualizacja ?></td> 
                </tr>
            </table>
        </div>
    </main>
</div>