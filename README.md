<p align="center"><img src="https://i.imgur.com/vgHcTAp.png" width="300"></p>

<p align="center" style="font-size: 40px">
Tree Certificates Order Page
</p>

## Local Deployment Process

1. Clone the repo to your local project root
2. Run `mv .env.example .env` and modify it with your credentials (note that the app is using mailing, so you will need to put your mailing server details in there)
3. Run `composer install` or `php composer.phar install` depending on the type of Composer installation you have
4. Run `php artisan key:generate`
5. Run `php artisan migrate` to fill your database with testing data
6. Run `php artisan serve` if you want Laravel to create a server for you, it might not be needed if your enviroment is already configured

After steps above are done, you can access the project at `localhost:8000`
