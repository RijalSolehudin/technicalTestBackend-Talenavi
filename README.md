# Technical Test Backend - Talenavi

## Fitur
- CRUD Todo
- Export semua data kedalam bentuk Excel Report (include: Total Todos dan total time tracked)
- Export Data kedalam bentuk Excel Report berdasarkan Filter ( status, priority, due_date, dll )
- Generate Chart data berdasarkan status, priority, dan assignee

## Teknologi
- Laravel 11
- MySQL

## Cara Menjalankan
1. Clone repo ini
2. Jalankan `composer install`
3. Copy `.env.example` ke `.env`
4. Jalankan `php artisan migrate --seed`
5. Jalankan server: `php artisan serve`
6. Jangan Lupa nyalakan web servernya

## Endpoint API

 ## CRUD Task Todo ( hanya Read dan Create )
 - GET `/api/todos`     
 - POST `/api/todos` 

 ## Export semua data kedalam bentuk .xlsx (excel Report)
 - GET `/api/todos/export`      

 ## Export data kedalam bentuk .xlsx (excel report) berdasarkan filter
 - GET `/api/todos/export?filter=value|[value]`  

    contoh : http://localhost:800/api/todos/export?assignee=Panjul,Rahma
    
 ## generate Data Chart berdasarkan type
 - GET `/api/chart?type=status|priority|assignee` 

## Author
Rijal Solehudin
