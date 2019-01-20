call ..\sysvars.bat
SET COMPOSER_PHAR=%XAMPP_DIR%\composer\composer.phar
%PHP_EXE% %COMPOSER_PHAR% selfupdate
%PHP_EXE% %COMPOSER_PHAR% global require "fxp/composer-asset-plugin:1.4.*" -v
pause
