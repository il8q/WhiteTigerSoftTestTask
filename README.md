### Примечание для проверяющих
1) Так как с Yii я раньше не работал, то много времени потратил на изучение теории. Давно(4 года назад, на бакалавриате)
работал с Symfony.
2) Кроме того старался делать побыстрее, поэтому, возможно, применены неоптимальные решения.
3) В проекте две ветки: master и features/1_api_and_admin_page

### Вопросы по заданию
1) Нужно ли было делать pretty url-ы для API? Об этом ничего не было сказано, поэтому не стал делать, потому-что быстрее
2) Когда добавлял api, нужно было добавлять контроллер. По итогу получилось два контроллера BlogController и 
BlogapiController Первый отвечает за CRUD, второй относится к api. Yii имя BlogApiController не распознает, имя 
сущности должно состоять из одного слова. Как лучше сделать? Можно было бы в один контроллер все поместить, но тогда 
будет нарушен принцип единственной отвественности.
3) В постановке задачи указаны "Сценарий работы в Мобильном приложении". Их нужно было реализовывать? 
Название проекта - API и Админка для мобильного приложения "Блог". Следует ли из этого названия, что ранее упомянутые 
сценарии написаны только для описания контекста?

### Установка и настройка
Использованное ПО: OpenServer, Advanced REST client.

Использовал не MAMP, потому-что у меня windows 8, не давно переустанавливал винду из-за того что ПО куллера сбилось(
ничего не помогало, была windows 10, но загрузочную флешку оставил у родителей), а в версии для windows 8 используется 
более старые версии необходимого ПО и более старая версия php.
У OpenServer такой проблемы нет, и доступны все функции.
1) Скачать пакеты:


    php composer.phar update

2) Перед запуском в конфиг Apache добавить, заменив пути на нужные:


    <VirtualHost *:80>
        ServerName frontend.test
        DocumentRoot G:\Work\WhiteTigerSoftTestTask\frontend\web
        <Directory  "G:\Work\WhiteTigerSoftTestTask\frontend\web">
            Options +Indexes +FollowSymLinks +MultiViews
            AllowOverride All
            Require all granted
    
            # use mod_rewrite for pretty URL support
            RewriteEngine on
            # If a directory or a file exists, use the request directly
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteCond %{REQUEST_FILENAME} !-d
            # Otherwise forward the request to index.php
            RewriteRule . index.php
        </Directory>
    </VirtualHost>
    
    <VirtualHost *:80>
        ServerName backend.test
        DocumentRoot G:\Work\WhiteTigerSoftTestTask\backend\web
        <Directory  "G:\Work\WhiteTigerSoftTestTask\backend\web">
            Options +Indexes +FollowSymLinks +MultiViews
            AllowOverride All
            Require all granted
    
            # use mod_rewrite for pretty URL support
            RewriteEngine on
            # If a directory or a file exists, use the request directly
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteCond %{REQUEST_FILENAME} !-d
            # Otherwise forward the request to index.php
            RewriteRule . index.php
        </Directory>
    </VirtualHost>

