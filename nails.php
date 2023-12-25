<?php

include 'lib.php';

ini_set('log_errors', 1);
ini_set('error_log', '/home/g/ghulqul/facehookapp.ru/public_html/source/FaceApp/PHP_errors_test3.log');
error_reporting(E_ERROR); // Устанавливаем уровень ошибок

$token = '6660548794:AAHhy82DMJtws1NlMj7VIx0_zDw8c_MswWk';

$root_user = "daniil_starcev";

$host = 'localhost';
$user = 'ghulqul_face_app';
$password = 'A951753d!81902018B';
$database = 'ghulqul_face_app';

$data = json_decode(file_get_contents('php://input'), TRUE);

$update_id = $data['update_id'];
$message_id = $data['message']['message_id'] ?? $data['callback_query']['message']['message_id'];
$chat_id = $data['message']['chat']['id'] ?? $data['callback_query']['message']['chat']['id'];
$username = $data['message']['from']['username'] ?? $data['callback_query']['from']['username'];
$text = $data['message']['text'] ?? $data['callback_query']['data'];

function processSwitchCommand($token, $chat_id, $text, $mysqli) {
    switch ($text) {
//Главное меню
        case '/start':
            sendTelegramMessage ($token, $chat_id, 'Главное меню:', 1, $mysqli);
            break;
//Меню Новая запись
        case '/singup':
            editTelegramMessage ($token, $chat_id, 'Выберите тип:', 2, $mysqli);      
            break;
//Вернуться в Главное меню              
        case '/backtomainmenu':
            editTelegramMessage ($token, $chat_id, 'Главное меню:', 1, $mysqli); 
            break;
//Выбор типа            
        case '/sawing':
            editTelegramMessage ($token, $chat_id, 'Выберите покрытие:', 2.1, $mysqli);      
            break;    
        case '/common':
            editTelegramMessage ($token, $chat_id, 'Выберите покрытие:', 2.1, $mysqli);      
            break;  
//Вернуться в выбор типа              
        case '/backtoselecttype':
            editTelegramMessage ($token, $chat_id, 'Выберите тип:', 2, $mysqli); 
            break;    
//Выбор покрытия            
        case '/gel':
            editTelegramMessage ($token, $chat_id, 'Выберите месяц:', 3, $mysqli);      
            break;  
        case '/gelpolish':
            editTelegramMessage ($token, $chat_id, 'Выберите месяц:', 3, $mysqli);      
            break;   
//Вернуться в выбор покрытия              
        case '/backtoselectcoating':
            editTelegramMessage ($token, $chat_id, 'Выберите покрытие:', 2.1, $mysqli); 
            break;                
//Выбор месяца            
        case '/current':
  
            break;  
        case '/next':
 
            break;
//Меню Моя запись        
        case '/myentry':
            sendTelegramMessage ($token, $chat_id, '', 1, $mysqli);
            break;
    }
    return;
}