Simple Bitcoin Wallet
=====================

This a simple example of a personal Bitcoin wallet, built using the [Blocktrail Bitcoin API](https://www.blocktrail.com/) and [Laravel framework.](http://laravel.com/).
You can use it to get started on integrating Bitcoin data in your own php applications.

###Requirements
You need [composer](https://getcomposer.org/) for package management in the backend.


###Getting Started
#####1. Copy the code
Clone the repository and run `composer update` to download the required packages.

#####2. Get your API keys
Go to [www.blocktrail.com](https://www.blocktrail.com/) and sign up for a free API account.
Create an API key, and then add this to `.env.local.php` for your local environment, and/or to `end.php` if in your production environment.

For email functionality we use [Mailgun](https://mailgun.com). Sign up for an api key and then also add these to the the `env.local.php` and/or `env.php` files:

    <?php     
      return array(
        'BLOCKTRAIL_KEY' => 'MY_API_KEY',
        'BLOCKTRAIL_SECRET' => 'MY_API_SECRET',

        'MAILGUN_DOMAIN' => 'MY_MAILGUN_DOMAIN',
        'MAILGUN_SECRET' => 'MY_MAILGUN_SECRET',
      );
*(note that these files have been added to the .gitignore. You should always keep your API details secret)*

#####3. Set up the server
run `php artisan serve` to quickly setup a nice little local server serve the app. Alternatively you can set up [Laravel Homestead](http://laravel.com/docs/4.2/homestead), the pre-packaged Vagrant virtual machine that provides you with a quick and easy local web server environment.

#####4. Run the migrations and seed the database
If you've set up homestead then all the database config is ready for you to run migrations and database seeding. If not, then setup your database and add the details to the database config file.
Then run `php artisan migrate --seed` on homestead/locally to create the database tables and run the table seeders.


#####5. You're good to go
With the server up and running now, simply navigate to [http://localhost:8000](http://localhost:8000) (or your homestead server) to see the simple wallet and block explorer at work.
A user and initial wallet has been created through the table seeders. You can log in with `email: test@test.com` `password: test`.

#####6. Things to know
For webhook creation and use your server needs to be accessible via a public domain. When developing you can achieve this easily through the use of a tunnel.
[ngrok](https://ngrok.com/) allows you to easily set up a tunnel between your local environment and an external domain (either controlled by you, or a free subdomain on their domain).




###Need Help?
Get in contact with us at [devs@blocktrail.com](mailto://devs@blocktrail.com) and we'll be happy to help you in any way we can.

A tutorial will be coming soon describing the steps to creating this Bitcoin block explorer with Laravel.
