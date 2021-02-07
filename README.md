Для запуска ввести команду `docker-compose up` в корне проекта.

Проект будет доступен по адресу: http://magento-test-task.local/. Админ панель: http://magento-test-task.local/admin

Доступы в админку:

admin/password

После того как контейнеры стартанут,  нужно к себе на машину в /etc/host добавить запись. 172.18.0.5 magento-test-task.local.
где 172.18.0.5 - адрес nginx контейнера, который можно узнать выполнив команду:

`docker inspect test-task-nginx | grep "IPAddress"`

При первом запуске, после старта всех контейнеров нужно запустить следующую команду:

`docker exec -it test-task-php-fpm /var/www/setup-magento.sh`

эта команда установит модули, инициализирует проект и заполнит базу тестовыми данными.