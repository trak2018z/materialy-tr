<?php

// Baza danych
\core\BaseModel::setUser('mysql');
\core\BaseModel::setPass('mysql');
\core\BaseModel::setHost('localhost');
\core\BaseModel::setName('materialy');

// Widok
\core\View::setAssets('');

// Użytkownik
\model\UsersModel::$SALT = 'fdqwgvfGFDg4w3$%5^%$#^%hgfdCXBGrty4^%$#y ';