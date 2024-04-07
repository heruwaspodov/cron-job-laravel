<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About

The last time I used Laravel was Laravel 5.8, now Laravel has the latest version, version 11. In the latest version
laravel support the cron and scheduler task.
In this repository, i try to create cron and scheduler in laravel.

## Dependency

- Composer
- PHP version ^ 8.2
- Redis
- PostgreSql

## Preparation

- copy `.env.example` to `.env` (configuration for database and redis can adjust)
- run command `composer install`
- if you use the other database or redis which has empty data, you can fill the data without waiting for the cron to
  run.
- run the code below to fill in the data users. The params of `--limit` can be adjusted and automatically update the
  data count in
  redis.
  #### `php artisan app:fetch-users --limit=100`
- run the code below to fill in the data daily and calculate
  #### `php artisan  app:daily-calculate`
- register to crontab `crontab -e`, and don't forget to save after adding the script!
- change the path_project to your local path of the project in this command
  #### `* * * * * php /path_project/artisan schedule:run >> /dev/null 2>&1`

## Run

#### `php artisan serve`

![img.png](public%2Fimg.png)
