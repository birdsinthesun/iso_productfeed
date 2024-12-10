# Erste Schritte Microservice #


1. Windows PowerShell herunterladen und installieren

2. Xampp herunterladen und installieren

3. Composer für Windows herunterladen und installieren



### wichtige Doku Links ###
https://symfony.com/doc/current/index.html
https://getbootstrap.com/docs/5.3/getting-started/introduction/
https://symfony.com/doc/current/frontend/asset_mapper.html
https://symfony.com/bundles/SassBundle/current/index.html
https://packagist.org/packages/thomaspark/bootswatch
https://bootswatch.com/lux/

### wichtige Shell Befehle ###

    cd/
     set PATH=C:\Programme\xampp\php\;%PATH%

    cd C:\xampp\htdocs
    Invoke-Expression (New-Object System.Net.WebClient).DownloadString('https://get.scoop.sh')
    Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser
    Invoke-RestMethod -Uri https://get.scoop.sh | Invoke-Expression

    composer create-project symfony/skeleton:"7.0.*" rats

    cd C:\xampp\htdocs\rats
    scoop install symfony-cli
    scoop update symfony-cli

#### Asset Mapper ####
    php bin/console importmap:require bootstrap
    php bin/console debug:asset-map

#### Symfony ####
    symfony help
    symfony cache:clear
    symfony check:requirements
    php bin/console debug:router page_lucky
    php bin/console cache:pool:clear --all

#### Composer ####
    composer require git
    composer require symfony/apache-pack
    composer require twig
    composer require symfony/asset-mapper symfony/asset symfony/twig-pack
    composer require flex
    composer require twbs/bootstrap
    composer require symfonycasts/sass-bundle
    composer require thomaspark/bootswatch
    composer require symfony/runtime
    composer require symfony/runtime
    composer clear-cache
    composer cache:clear
    composer update


#### SaSS Compiling ####
    php bin/console sass:build --watch

#### prod ####
    php bin/console asset-map:compile