call ..\sysvars.bat
SET COMPOSER_PHAR=%XAMPP_DIR%\composer\composer.phar
%PHP_EXE% %COMPOSER_PHAR% %*
pause
