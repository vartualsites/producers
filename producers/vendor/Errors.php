<?php

namespace Isystems\Vendor;

class Errors {
   public static function getErrorMessage($index = '') {
       $errors = array(
           'INTERNAL_SERVER_ERROR' => 'Błąd serwera',

           'API_NOT_FOUND' => 'Nie znaleziono aplikacji',
           'API_VERSION_NOT_FOUND' => 'Nie znaleziono wersji',
           'ROUTE_NOT_FOUND_OR_METHOD_NOT_ALLOWED' => 'Nie ma takiego adresu bądź metody',

           'UNAUTHORIZED' => 'Brak autoryzacji',
           'MALFORMED_REQUEST_BODY' => 'Nieodpowiednie żądanie',
           'RESOURCE_NOT_FOUND' => 'Nie znaleziono zasobu',
           'INVALID_LANG_CODE_IN_QUERY_STRING' => 'Nieodpowiedni kod języku',
           'INVALID_REQUEST_DATA' => 'Nieodpowiednie dane żądania',
           'INVALID_DATA_FOR_OBJECT' => 'Nie prawidłowe dane'
       );
       return isset($errors[$index]) ? $errors[$index] : 'Nie znaleziono';
   }
}