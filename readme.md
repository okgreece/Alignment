```bash
#clone the repo
git clone https://github.com/okgreece/Alignment.git

#run composer
composer install

#create an .env file from .env.example
cp .env.example .env

#change your database credentials using your favorite text editor

#run the Job Que
sudo -u www-data php artisan queue:listen --timeout=600 --sleep=30
```
