<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Website
<a href="https://chanhxemientay.vercel.app">ChanhXe</a>

## About This Project

This is a Laravel project configured with Swoole Server through Docker. Here are a list of enviroment dependency:

-   PHP ^8.2.
-   Swoole Server through Laravel Octane
-   Laravel Sail

## Local Setup

### Install directly into wsl2 (recommended)

Here are the steps to set up local environment (recommended [windows terminal's](https://apps.microsoft.com/store/detail/windows-terminal/9N0DX20HK701) linux subsystem shell as the main cli)

1. clone this project directly into your wsl2 system, i.e `\\wsl$\Ubuntu\home\<your-username>\<your-local-folder-name>`
2. `cd ./<your-local-folder-name>`
3. run the bash file `init.sh` to install PHP depednencies and set up `.env` file: `bash init.sh` or `sudo bash init.sh`
4. run the bash file `firstStart.sh` to actually build your Docker image and container, please be aware that it could take up to 5 minutes to pull the images and build your containers: `bash firstStart.sh` or `sudo bash firstStart.sh`
5. now you will have a fully configured Laravel Octane application running on Swoole in Docker. The next time you start the app you just need to start it through your Docker GUI or with command `./vendor/bin/sail up`, or `sail up` if you have [configured your alias](https://laravel.com/docs/sail#configuring-a-shell-alias)

### Install into Windows and mount to wsl2

    **TODO**

## Local Development

    Hot reload is configured and enabled, so you don't need to manually call [`sail artisan octane:reload`] or [`sail artisan octane:stop` and `sail artisan octane:start`] again.
