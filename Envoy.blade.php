@servers(['localhost' => '127.0.0.1'])

{{-- 初始化项目 --}}
@task('init', ['on' => ['localhost'], 'confirm' => true])

{{-- 切换到工作目录 --}}
cd /var/www/html

php artisan db:seed
php artisan passport:client --personal
php artisan migrate
php artisan config:cache
php artisan route:cache
php artisan octane:reload

@endtask
