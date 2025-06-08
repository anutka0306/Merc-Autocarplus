<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BotController extends AbstractController
{
    const TOKEN = '7061105523:AAG_TsmypzumDdj7o29XcoDCTPBQSfbmv60';
    const CHATID = '-1002012952797';

    #[Route('/send_mail', name: 'app_mail')]
    public function send(Request $request): JsonResponse
    {
        $arr = [
            'Имя клиента: ' => $request->request->get('username'),
            'Телефон клиента: ' => $request->request->get('phone'),
            /*'Сервис: ' => $request->request->get('service'),*/
            '%0AФорма была отправлена со страницы: ' => 'https://autocarplus.ru' . $request->request->get('page')
        ];

        $txt = '<u><b><i>В техцентр поступил запрос на обратный звонок. %0A%0A</i></b></u>';
        foreach ($arr as $key => $value) {
            $txt .= '<b>' . $key . '</b>' . $value . '%0A';
        }
        fopen('https://api.telegram.org/bot' . self::TOKEN . '/sendMessage?chat_id=' . self::CHATID . '&parse_mode=html&text=' . $txt, 'r');


        $roistatData = array(
            'roistat' => isset($_COOKIE['roistat_visit']) ? $_COOKIE['roistat_visit'] : 'nocookie',
            'key' => 'YZmjNiEzNjgwY2JkNmY4MTgyNjljZDM5MGZmNDBhODI6MjU4ODc5', // Ключ для интеграции с CRM, указывается в настройках интеграции с CRM.
            'name' => $request->request->get('username'), // Имя клиента
            'phone' => $request->request->get('phone'), // Номер телефона клиента
            'order_creation_method' => '', // Способ создания сделки (необязательный параметр). Укажите то значение, которое затем должно отображаться в аналитике в группировке "Способ создания заявки"
            'is_need_callback' => '0',  // Если указано значение '1', на номер клиента будет инициироваться обратный звонок после создания заявки в Roistat (независимо от того, включен ли обратный звонок в Ловце лидов).
            //Если указано значение '0', для данной формы обратный звонок инициироваться не будет (даже если в Ловце лидов включен обратный звонок).
            'callback_phone' => '<Номер для переопределения>', // Переопределяет номер, указанный в настройках обратного звонка.
            'sync' => '0', //
            'is_need_check_order_in_processing' => '1', // Настройка стандартной проверки заявок на дубли.
            // Если установлено значение '1', на дубли будут проверяться заявки за последние 12 часов только в статусах группы "В работе".
            // Если установлено значение '0', будут проверяться все заявки за последние 12 часов.
            // Данный параметр не участвует в пользовательской проверке на дубли.
            'is_need_check_order_in_processing_append' => '1', // Если создана дублирующая заявка, в нее будет добавлен комментарий об этом
            'is_skip_sending' => '1', // Не отправлять заявку в CRM.
            'fields' => array(
                // Массив дополнительных полей. Если дополнительные поля не нужны, оставьте массив пустым.
                // Примеры дополнительных полей смотрите в таблице ниже.
                // Помимо массива fields, который используется для сделки, есть еще массив client_fields, который используется для установки полей контакта.
                "charset" => "Windows-1251", // Сервер преобразует значения полей из указанной кодировки в UTF-8.
            ),
        );

        file_get_contents("https://cloud.roistat.com/api/proxy/1.0/leads/add?" . http_build_query($roistatData));
        return new JsonResponse(['success' => true]);
    }
}