"# typisch-tango-yii2" 

git init

git remote add origin https://github.com/bartullus/typisch-tango-yii2.git

git pull origin master

composer update

yii migrate --migrationPath=@yii/i18n/migrations/