Инструкция по установке:
  -composer install
  -скопировать всё из .env-example в .env
  -php artisan key:generate для ключа в .env
  -выбрать бд в .env
  -php artisan migrate --seed (наполнение таблицы users десяти рандомных строчек)
  -php artisan serve
  -можно отправлять запросы к api
