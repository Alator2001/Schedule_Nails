<?php

function getCurrentAndNextMonth() {
    // Получаем текущую дату
    $currentDate = new DateTime();

    // Получаем номер текущего месяца
    $currentMonthNumber = $currentDate->format('n');

    // Массив с названиями месяцев
    $monthNames = [
        1 => 'Январь',
        2 => 'Февраль',
        3 => 'Март',
        4 => 'Апрель',
        5 => 'Май',
        6 => 'Июнь',
        7 => 'Июль',
        8 => 'Август',
        9 => 'Сентябрь',
        10 => 'Октябрь',
        11 => 'Ноябрь',
        12 => 'Декабрь'
    ];

    // Получаем название текущего месяца
    $currentMonth = $monthNames[$currentMonthNumber];

    // Переходим к следующему месяцу
    $currentDate->add(new DateInterval('P1M'));

    // Получаем номер следующего месяца
    $nextMonthNumber = $currentDate->format('n');

    // Получаем название следующего месяца
    $nextMonth = $monthNames[$nextMonthNumber];

    return [
        'currentMonth' => $currentMonth,
        'nextMonth' => $nextMonth
    ];
}


function editTelegramMessage($token, $chat_id, $step, $mysqli) {
    $sql = "SELECT message_id FROM msg_webhook WHERE chat_id = '$chat_id' AND text = '/' ORDER BY id DESC LIMIT 1";
    $result = $mysqli->query($sql);
    $message_id = $result->fetch_assoc();
    switch ($step) {
//Главное меню
        case 1:
            $getQuery = array(
                "chat_id" => $chat_id,
                "message_id" => $message_id['message_id'],
                "text" => 'Моя анкета:',
                'reply_markup' => json_encode(array(
                    'inline_keyboard' => array(
                        array(
                            array(
                            'text' => 'Записаться',
                            'callback_data'=>'/singup',
                            ),
                        ),
                        array(
                            array(
                            'text' => 'Моя запись',
                            'callback_data'=>'/myentry',
                            ),
                        ),
                    ),
                )),
            );
            break;
//Меню Новая запись
        //Пилочный обычный
        case 2:
            $getQuery = array(
                "chat_id" => $chat_id,
                "message_id" => $message_id['message_id'],
                "text" => 'Моя анкета:',
                'reply_markup' => json_encode(array(
                    'inline_keyboard' => array(
                        array(
                            array(
                            'text' => 'Пилочный',
                            'callback_data'=>'/sawing',
                            ),
                        ),
                        array(
                            array(
                            'text' => 'Обычный',
                            'callback_data'=>'/common',
                            ),
                        ),
                        array(
                            array(
                            'text' => 'Справка',
                            'callback_data'=>'/help',
                            ),
                        ),
                        array(
                            array(
                            'text' => '<< Назад',
                            'callback_data'=>'/backtomainmenu',
                            ),
                        ),
                    ),
                )),
            );
            break;
        //Гель Гель-лак
        case 2.1:
            $getQuery = array(
                "chat_id" => $chat_id,
                "message_id" => $message_id['message_id'],
                "text" => 'Моя анкета:',
                'reply_markup' => json_encode(array(
                    'inline_keyboard' => array(
                        array(
                            array(
                            'text' => 'Гель',
                            'callback_data'=>'/gel',
                            ),
                        ),
                        array(
                            array(
                            'text' => 'Гель-лак',
                            'callback_data'=>'/gelpolish',
                            ),
                        ),
                        array(
                            array(
                            'text' => 'Справка',
                            'callback_data'=>'/help',
                            ),
                        ),
                        array(
                            array(
                            'text' => '<< Назад',
                            'callback_data'=>'/backtoselecttype',
                            ),
                        ),
                    ),
                )),
            );
            break;
        //Выбор месяца
        case 3:
            $months = getCurrentAndNextMonth();
            $getQuery = array(
                "chat_id" => $chat_id,
                "message_id" => $message_id['message_id'],
                "text" => 'Моя анкета:',
                'reply_markup' => json_encode(array(
                    'inline_keyboard' => array(
                        array(
                            array(
                            'text' => $months[0],
                            'callback_data'=>'/current',
                            ),
                        ),
                        array(
                            array(
                            'text' => $months[1],
                            'callback_data'=>'/next',
                            ),
                        ),
                        array(
                            array(
                            'text' => 'Справка',
                            'callback_data'=>'/help',
                            ),
                        ),
                        array(
                            array(
                            'text' => '<< Назад',
                            'callback_data'=>'/backtoselectcoating',
                            ),
                        ),
                    ),
                )),
            );
            break;
    }
                
    $ch = curl_init("https://api.telegram.org/bot". $token ."/editMessageText?" . http_build_query($getQuery));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_exec($ch);
    curl_close($ch);
    return;
}


function sendTelegramMessage($token, $chat_id, $text, $reg_step, $mysqli) {
    switch ($reg_step) {
//Отправка текста
        case 0:
            $getQuery = array(
                "chat_id" 	=> $chat_id,
                "text" => $text,
                'disable_notification' => true,
            );
            break;
//Главное меню
        case 1:
            $getQuery = array(
                "chat_id" 	=> $chat_id,
                "text" => $text,
                'disable_notification' => true,
                'reply_markup' => json_encode(array(
                    'inline_keyboard' => array(
                        array(
                            array(
                            'text' => 'Записаться',
                            'callback_data'=>'/singup',
                            ),
                        ),
                        array(
                            array(
                            'text' => 'Моя запись',
                            'callback_data'=>'/myentry',
                            ),
                        ),
                    ),
                )),
            );
            break;
//Меню Новая запись
        //Пилочный-Обычный
        case 2:
            $getQuery = array(
                "chat_id" 	=> $chat_id,
                "text" => $text,
                'disable_notification' => true,
                'reply_markup' => json_encode(array(
                    'inline_keyboard' => array(
                        array(
                            array(
                            'text' => 'Пилочный',
                            'callback_data'=>'/sawing',
                            ),
                        ),
                        array(
                            array(
                            'text' => 'Обычный',
                            'callback_data'=>'/common',
                            ),
                        ),
                        array(
                            array(
                            'text' => 'Справка',
                            'callback_data'=>'/help',
                            ),
                        ),
                        array(
                            array(
                            'text' => '<< Назад',
                            'callback_data'=>'/backtomainmenu',
                            ),
                        ),
                    ),
                )),
            );
            break;
        //Гель Гель-лак    
        case 2.1:
            $getQuery = array(
                "chat_id" 	=> $chat_id,
                "text" => $text,
                'disable_notification' => true,
                'reply_markup' => json_encode(array(
                    'inline_keyboard' => array(
                        array(
                            array(
                            'text' => 'Гель',
                            'callback_data'=>'/gel',
                            ),
                        ),
                        array(
                            array(
                            'text' => 'Гель-лак',
                            'callback_data'=>'/gelpolish',
                            ),
                        ),
                        array(
                            array(
                            'text' => 'Справка',
                            'callback_data'=>'/help',
                            ),
                        ),
                        array(
                            array(
                            'text' => '<< Назад',
                            'callback_data'=>'/backtoselecttype',
                            ),
                        ),
                    ),
                )),
            );
            break;
        case 3:
            $months = getCurrentAndNextMonth();
            $getQuery = array(
                "chat_id" 	=> $chat_id,
                "text" => $text,
                'disable_notification' => true,
                'reply_markup' => json_encode(array(
                    'inline_keyboard' => array(
                        array(
                            array(
                            'text' => $months[0],
                            'callback_data'=>'/current',
                            ),
                        ),
                        array(
                            array(
                            'text' => $months[1],
                            'callback_data'=>'/next',
                            ),
                        ),
                        array(
                            array(
                            'text' => 'Справка',
                            'callback_data'=>'/help',
                            ),
                        ),
                        array(
                            array(
                            'text' => '<< Назад',
                            'callback_data'=>'/backtoselectcoating',
                            ),
                        ),
                    ),
                )),
            );
            break;
    }   
}

