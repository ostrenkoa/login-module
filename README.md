# PHP login-module

Простой и функциональный модуль логина для использования в любых PHP сайтах. Максимальный упор на простой код и комментирование кода для возможности использования начинающими разработчиками.

## Функции

- Свободная регистрация или только по инвайтам
- Возможность быстрого отключения регистрации новых пользователей
- Возможность включения сервисного режима с авторизацией только для администраторов
- Активация пользователя по e-mail (отключаемая)
- Сброс пароля по e-mail (отключаемый)
- Централизованные настройки дополнительных опций
- Общий адаптивный шаблон для всех форм и сообщений
- Не использует js для корректной работы на любых устройствах
- Возможность быстрого создания перевода на другие языки, весь текст вынесен в отдельный файл

## Требования

- PHP 5.(3,4,5,6), PHP 7.(0.1.2)
- MySQL (есть поддержка SQLite и PgSQL через адаптеры goDB)
- Пожалуйста, используйте как можно более новые версии PHP и базы данных для максимальной защиты информации.

## Зависимости

Необходимые файлы включены в проект.
- goDB - для более удобной работы с базой [https://github.com/vasa-c/go-db](https://github.com/vasa-c/go-db)
- PHPMailer - для отправки писем [https://github.com/PHPMailer/PHPMailer](https://github.com/PHPMailer/PHPMailer)

## Установка

- Создайте базу данных *login* и две таблицы *users* и *invites* в ней используя SQL скрипт в папке `_install`
- Создайте пользователя для доступа к базе данных
- Скопируйте все файлы проекта в корневую директорию сайта
- Укажите данные для доступа к базе в файле `config/config.php`
- Для использования возможности отправки писем активации и восстановления пароля, укажите данные SMTP сервера в файле `config/config.php`. Протестирована работа с сервисом [Яндекс Коннект](https://connect.yandex.ru)
- Настройте основные опции в файле `config/config.php` в соответствии с вашими предпочтениями

## Лицензия

Распространяется под лицензией [MIT](http://www.opensource.org/licenses/mit-license.php).
Вы можете использовать этот скрипт бесплатно для любых личных или коммерческих проектов.
Используемые библиотеки goDB и PHPMailer лицензируются отдельно.

## Поддержка

Любые вопросы можно задать в telegram @ostrenkoa, отвечу по возможности.
