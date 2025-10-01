# Скопировать пример в рабочий .env
cp .env.example .env

# Сгенерировать APP_KEY
./vendor/bin/sail php artisan key:generate

# Применить миграции
./vendor/bin/sail php artisan migrate