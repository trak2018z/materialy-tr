Prosta biblioteka do walidacji formularzy (PHP, JS, HTML)
========================================================

# Domyślne zasady walidacji
| Nazwa zasady        | Treść komunikatu. |
| --- | --- |
| notNull             | To pole nie może być puste.|
| isEmail             | To nie jest poprawny adres email.|
| isPhone             | To nie jest prawidłowy numer telefonu.|
| minLength           | Wartość jest za krótka (min. $1 znaków).|
| maxLength           | Wartość jest za długa (max. $1 znaków).|
| isLt                | Wartość powinna być mniejsza niż $i.|
| isGt                | Wartość powinna być większa od $1.|
| isLe                | Wartość powinna być mniejsza lub równa niż $1.|
| isGe                | Wartość powinna być większa lub równa od $1.|
| isSex               | Niewłaściwa płeć.|
| isPostCode          | Niepoprawny kod pocztowy.|
| isLengthBetween     | Długość powinna zawierać się pomiędzy $1 i $2 znaków.|
| isIn                | Nieprawidłowa wartość.|
| isInt               | Wartość powinna zawierać liczby całkowite.|
| isFloat             | Wartość powinna zawierać liczby rzeczywiste.|
| isBool              | Wartość powinna zawierać wartość logiczną.|
| isNick              | Niepoprawny nick.|
| inRange             | Wartość powinna zawierać się w przedziale $1 i $2.|
| isDate              | To nie jest poprawny format daty.|
| isNotFutureDate     | Data zawiera się w nieprawidłowym zakresie.|
| isProperFileSize    | Podany plik jest zbyt duży, maks. $2MB.|
| isProperFileSizeApi | Podany plik jest zbyt duży, maks. $1MB.|
| inOpenRange         | Wartość powinna zawierać się w przedziale $1 i $2.|
| isFileType          | Niepoprawny format pliku ($1)|

#HTML:
## Komunikat ogólny
```html
<div class="validate-report-block">{$form.info._html}</div>
```

## Status walidacji
 - ```form.info._success = true``` Jeśli sukces.
 - ```form.info._success = false``` Jeśli wystąpiły błędy.

## Wyświetlanie pola
```html
<div class="{if $form.info.Mileage}error{/if}">
    <input type="text" name="Mileage" value="{$form.fields.Mileage}" />
</div>
<!-- Komunikat. -->
{if $form.info.Mileage}
    <span class="red form_validate" data-valid="Mileage">{$form.info.Mileage}</span>
{/if}
```

## Wyświetlanie formularza
```html
<form class="ajaxForm" data-onsubmit="validate">...</form>
```

# PHP:
## Kontroler
Przykładowy kod php akcji w kontrolerze.

```php
<?php
    /* ... */

    public function sendMessage()
    {
        if (FALSE === $this->isPostData()) {
            // Przypisywanie wartości domyślnych do formularza,
            // przydatne na przykład podczas edycji.
            $aDefault = array(
                         'Name'     => 'Jan',
                         'LastName' => 'Kowalski',
                        );
            ContactValidator::appendToView($this->ui, $aDefault);

            return $this->ui->display('contact.tpl');

        }//end if

        $oValidate = new ContactValidator();
        if (TRUE === $oValidate->isValid()) {
            // Walidacja przeszła poprawnie.
            // wysyłamy e-mail
            $oMessage = new Message(...);
            return $this->redirect('/kontakt');

        } else {
            // Walidacja nie przeszła poprawnie,
            // zapisujemy dane z formularza i komunikaty błędów i robimy przekierowanie.
            $oValidate->saveGlobally();
            return $this->redirect('/kontakt');

        }//end if

    }//end sendMessage()

    /* ... */
?>
```

## Walidacja bez tworzenia klasy.
Do prostej walidacji można wykorzystać istniejącą metodę Universal i przypisać zasady walidacji po utworzeniu obiektu.

```php
<?php
    $oValidate = new \vendor\validator\Universal;
    $oValidate->checkRule('Files', 'isProperFileSize', $aFiles, array('receipt', 1));

    if (TRUE === $oValidate->isValid()) {
        // ...
    }//end if

    // ...

?>
```

## Core PHP
### Pliki biblioteki
 - ```Validator.class.php``` Główny silnik,
 - ```Universal.class.php``` uniwersalna klasa,
 - ```Rules.class.php``` zasady walidacji (isEmail, isPhone etc.).

### Przykładowa klasa walidatora
```php
<?php
namespace modules\contact\validator;

use modules\validator\Validator;

class ContactValidator extends Validator
{
    /**
     * // Opcjonalnie
     */
    public function init()
    {
        // Opcjonalnie tutaj możemy ustawić nową klasę z metodami walidacji.
        $this->setRule(new \modules\contact\validator\ContactRules);

    }//end init()


    public function getName()
    {
        return 'contact';

    }//end getName


    /**
     * Metoda zwracająca zasady walidacji.
     *
     * @return array
     */
    public function getRules()
    {
        return array(
                'NAME'          => array(
                                    'notNull',
                                    array('maxLength', array(100)),
                                   ),
                'EMAIL'         => array(
                                    'notNull',
                                    'isEmail',
                                   ),
                'TOPIC'         => array(
                                    'notNull',
                                    array('isLengthBetween', array(10, 100)),
                                   ),
                'CONTENT'       => array(
                                    'notNull',
                                   ),
                'PHONE'         => array(
                                    'notNull',
                                   ),
                'DELIVERY_DATE' => array(
                                    'notNull',
                                   ),
                'ID_DELIVERY'   => array(
                                    'notNull',
                                   ),
               );

    }//end getRules()


    /**
     * // Opcjonalnie
     */
    public function getMessages($locale, $source='default') {
        $aMessages['pl-PL']['default'] = array(
                                          'name' => array(
                                                     'not_empty' => 'Zniżka AC powinna mieć wartość od 0 do 100%.',
                                                    ),
                                          'phone' => array(
                                                      'phone' => 'To nie jest prawidłowy numer telefonu.',
                                                     ),
                                         );
        $aMessages['pl-PL']['api']     = $aMessages['pl']['default'];

        return $aMessages[$locale][$source];

    }//end setMessages()
}
?>
```

### Własne zasady walidacji
Przykładowa klasa.

- Nazwa metody odpowiada nazwie zasady używanej w klasie Rules.
- W klasie walidacji musi zostać załadowany plik z zasadami w metodzie init().
- Metoda zasady musi zwracać TRUE w przypadku gdy walidacja przeszła poprawnie, lub FALSE w przeciwnym przypadku.
- Metoda może zwracać typ string, oznaczający komunikat, w przypadku bardziej rozbudowanej zasady.

```php
<?php
namespace modules\expenses\validator;

class ExpensesRules extends \vendor\validator\Rules {
    /**
     * Sprawdza czy jest to prawidłowa kategoria wydatków.
     *
     * @param integer $testObject Testowana wartość.
     *
     * @return boolean
     */
    public function isExpenseCategory($testObject)
    {
        return TRUE;

    }//end isExpenseCategory()


    /**
     * Przykład rozbudowanej zasady.
     */
    public function isSomething($testObject)
    {
        if (1 > $testObject) {
            return 'Jakiś komunikat 1.';

        } else if (2 > $testObject) {
            return 'Jakiś komunikat 2.';

        } // ... //end if

    }//end isHuman()
}
?>
```

# JS
```js
$(".ajaxForm").submit(function(e) {
    AjaxForm(this, e);
    return false;
});
```

## Core JS

```js
/**
 * Przesyła formularze ajaxowo.
 *
 * Opcje formularza:
 *   [opcjonalnie]
 *     - data-onsubmit="nazwa_funkcji"
 *       nazwa_funkcji Nazwa funkcji, która ma zostać wykonana po załadowaniu treści.
 *         Funkcja musi być zadeklarowana w przestrzeni nazw AjaxForm np:
 *         HTML: <form ... data-onsubmit="test">...</form>
 *         JS:   AjaxForm.test = function() { console.log('test'); }
 * Formularz musi mieć klasę 'ajaxForm'.
 */
var AjaxForm = function(target, e) {
    var $this      = $(target),
        url        = $this.attr('action'),
        serialized = $this.serialize(),
        onsubmit   = $this.data('onsubmit');
    e.preventDefault();
    if (serialized) {
        serialized += '&__AJAX_REQUEST__=true';
    } else {
        serialized = '__AJAX_REQUEST__=true';
    }

    $.ajax({
        type: "POST",
        url: url,
        data: serialized,
        success: function(data) {
            if (typeof onsubmit != 'undefined' && onsubmit != null && onsubmit != '') {
                AjaxForm[onsubmit](data, $this);
            }
        }
    });

}//end AjaxForm()
```

### Moduły

Metody wykonujące się po wysłaniu formularza i odebraniu go z kodem http=200 jeśli w form ustawione jest data-onsubmit="nazwaMetody".

```js
/**
 * Rozszerza walidację, czyści pola jeśli sukces.
 * @return void
 */
AjaxForm.validate = function(data, $form)
{
    AjaxForm.validateForm(data, $form);

    if (data._success == true) {
        $form.find('input[type="password"]').val('');
        $form.find('input[type="text"], textarea, input[type="password"]').val('');
    }//end if

}//end validate()


/**
 * Obsługa podstawowej walidacji pól według danych przychodzących z serwera.
 * @return void
 */
AjaxForm.validateForm = function(data, $form)
{
    // Ustawia wiadomość domyślną.
    $('.validate-report-block').html(data['_html']);
    //typ komunikatu
    $('.validate-report-block').removeClass('red').removeClass('green');
    if(data._success == true) {
        $('.validate-report-block').addClass('green');
    }
    else {
        $('.validate-report-block').addClass('red');
    }

    // Usuwa informację o błędzie.
    $form.find('input, textarea, select').closest('.input').removeClass('error');
    // Czyści pola typu password domyślnie.
    $form.find('input[type="password"]').val('');
    // Czyści komunikaty błędów.
    $('.form_validate').html('');
    if (typeof data['_success'] == 'undefined' || data['_success'] == false) {
        for (key in data) {
            $('input[name="'+key+'"],select[name="'+key+'"], textarea[name="'+key+'"]').closest('.input').addClass('error');
            $('.form_validate[data-valid="'+key+'"]').html(data[key]);
        }
    }

}//end validateForm()
```