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
        <div>
          <hr>   
          <header>
          <h1 class="title">Ogłoszenia:</h1>
          <?php if($this->isAdmin() || $this->isTeacher()): ?>
            <a title="dodaj" href="<?=$this->url('/subject/'.$id.'/advertisement/add'); ?>" class="circle bOrange addNewElement"><i class="fa fa-plus"></i></a>
          <?php endif; ?>         
          </header>
            <table>
                <tr>
                    <th><b>Tytuł</b></th>
                    <th><b>Treść</b></th>
                    <th><b>Data</b></th>
                    <?php if($this->isAdmin() || $this->isTeacher()): ?>          
                    <th class="tar"><b>Opcje</b></th>
                    <?php endif; ?>
                </tr>
                    <?php foreach ($advertisements as $value): ?>
                        <tr>
                        <td><?=$value->tytul?></td>
                        <td><?=$value->tresc?></td>
                        <td><?=$value->data?></td>
                        <?php if($this->isAdmin() || $this->isTeacher()): ?>
                        <td>
                            <ul class="tableTools">
                                <li><a href="<?=$this->url('/subject/'.$id.'/advertisement/'.$value->idOgloszenia.'/delete'); ?>"><i class="fa fa-remove"></i> Kasuj</a></li>
                            </ul>
                        </td>
                        <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
            </table>
        </div>
        <div>
            <hr/> 
            <header>
                <h1 class="title">Materiały:</h1>
            <?php if($this->isAdmin() || $this->isTeacher()): ?>
                <a title="dodaj" href="<?=$this->url('/subject/'.$id.'/category/add'); ?>" class="circle bOrange addNewElement"><i class="fa fa-plus"></i></a>
            <?php endif; ?> 
            </header>
            <?php if($this->isAdmin() || $this->isTeacher()): ?>       
                <?php                   
                    echo '<ol class="tree">';
                    foreach ($categories as $v1) {
                        if(empty($v1[0][0]->idKategoria)) break;
                        echo '<li class="li">';
                        echo '<div class="folder">';
                        echo '<form action="'.$this->url('/subject/'.$id.'/category/'.$v1[0][0]->idKategoria.'/edit').'" method="post" class="ajaxForm">';
                        echo '<input type="text" name="nazwa" value="'.$v1[0][0]->kat.'" size="20" class="mini"/>';
                        echo '</form>';
                        echo '<a href="'.$this->url('/subject/'.$id.'/category/'.$v1[0][0]->idKategoria.'/delete').'" class="confirmDelete"><i class="fa fa-remove"></i> Kasuj kategorie</a>';
                        echo '</div><input type="checkbox" />';
                        echo '<ol>';
                        echo '<li><a title="dodaj" href="'.$this->url('/subject/'.$id.'/subcategory/'.$v1[0][0]->idKategoria.'/add').'" >Utwórz katalog</a></li>';
                        foreach ($v1 as $v2) {
                            if(empty($v2[0]->idPodkategoria)) break;
                            echo '<li class="li">';
                            echo '<div class="folder">';
                            echo '<form action="'.$this->url('/subject/'.$id.'/subcategory/'.$v2[0]->idPodkategoria.'/edit').'" method="post" class="ajaxForm">';
                            echo '<input type="text" name="nazwa" value="'.$v2[0]->pod.'" size="20" class="mini"/>';
                            echo '</form>';
                            echo '<a href="'.$this->url('/subject/'.$id.'/subcategory/'.$v2[0]->idPodkategoria.'/delete').'" class="confirmDelete"><i class="fa fa-remove"></i> Kasuj podkategorie</a>';
                            echo '</div><input type="checkbox" />';
                            echo '<ol><li>';
                            echo '<div class="flip">Dodaj plik</div>';
                            echo '<div class="panel">
                                    <form action="'.$this->url('/subject/'.$id.'/subcategory/'.$v2[0]->idPodkategoria.'/add/file').'" method="post" enctype="multipart/form-data" class="fileForm">
                                    <label>Nazwa: <input type="text" name="nazwa" class="in"/></label>
                                    <label>Plik: <input type="file" name="file" class="in"/></label>
                                    <label><input type="submit" value="Dodaj plik" name="submit"/></label>
                                    </form></div>';       
                            echo '</li>';
                            foreach ($v2 as $v3){
                                if(empty($v3->idPlik)) break;
                                echo '<li class="file"><a href="../../file/'.$v3->idPlik.'/'.strstr($v3->nz, '.', true).'" target="_blank" title="'.$v3->tytul.strstr($v3->nz, '.', false).'">'.$v3->tytul.'</a><a href="'.$this->url('/subject/'.$id.'/file/'.$v3->idPlik.'/delete').'" class="confirmDelete"><i class="fa fa-remove"></i> Usuń plik</a></li>';
                            }
                            echo '</ol>';
                            echo '</li>';
                        }
                        echo '</ol>';
                        echo '</li>';
                    }
                    echo '</ol>';
                ?>
            <?php else: ?>
            <?php
            echo '<ol class="tree">';
            foreach ($categories as $v1) {
                        if(empty($v1[0][0]->idKategoria)) break;
                        echo '<li class="li">';
                        echo '<label for="kat'.$v1[0][0]->idKategoria.'">'.$v1[0][0]->kat.'</label><input type="checkbox" id="kat'.$v1[0][0]->idKategoria.'"/>';
                        echo '<ol>';
                        foreach ($v1 as $v2) {
                            if(empty($v2[0]->idPodkategoria)) break;
                            echo '<li class="li">';
                            echo '<label for="sub'.$v2[0]->idPodkategoria.'">'.$v2[0]->pod.'</label><input type="checkbox" id="sub'.$v2[0]->idPodkategoria.'"/>';
                            echo '<ol>';
                            foreach ($v2 as $v3){
                                if(empty($v3->idPlik)) break;
                                echo '<li class="file"><a href="../../file/'.$v3->idPlik.'/'.strstr($v3->nz, '.', true).'" target="_blank" title="'.$v3->tytul.strstr($v3->nz, '.', false).'">'.$v3->tytul.'</a></li>';
                            }
                            echo '</ol>';
                            echo '</li>';
                        }
                        echo '</ol>';
                        echo '</li>';
                    }
             echo '</ol>';
            ?>
            <?php endif; ?>  
        </div>
    </main>
</div>