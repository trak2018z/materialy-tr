<div class="content">
    <header>
        <h1>Użytkownicy</h1>
    </header>
    <main class="main">
        <table>
            <tr>
                <th>Login</th>
                <th>Imie</th>
                <th>Nazwisko</th>
                <th>Nazwa</th>
                <th>Skrót</th>
                <th>Typ konta</th>              
                <th class="tar">Opcje</th>
            </tr>
                <?php foreach ($users as $value): ?>
        			<tr>
                    <td><?=$value->login?></td>
                    <td><?=$value->imie?></td>
                    <td><?=$value->nazwisko?></td>
                    <td><?=$value->nazwa?></td>
                    <td><?=$value->skrot?></td>
                    <td><?=$value->typ_konta?></td>
                    <td>
                        <ul class="tableTools">
                            <li><a href="<?=$this->url('/manager/'.$value->idUzytkownik.'/edit')?>"><i class="fa fa-edit"></i> Edytuj</a></li>
                        </ul>
                    </td>
                    </tr>
                <?php endforeach; ?>
        </table>
    </main>
</div>