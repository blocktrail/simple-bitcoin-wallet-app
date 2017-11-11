Simple Bitcoin Wallet
=====================

This a simple example of a personal Bitcoin wallet, built using the [Blocktrail Bitcoin API](https://www.blocktrail.com/) and [Laravel framework.](http://laravel.com/).
You can use it to get started on integrating Bitcoin data in your own php applications.

### Requirements
***On Linux*** you need to install the following packages:
```
sudo apt-get install php5-bcmath php5-intl php5-gmp php5-mcrypt
sudo php5enmod mcrypt
```

*** On Windows *** you need to enable the following extensions in your `php.ini` if not already done:
```
extension=php_intl.dll  
extension=php_gmp.dll  
```

You will also need [composer](https://getcomposer.org/) for package management in the backend.


### Getting Started
##### 1. Copy the code
First clone this repository and copy the `env.example.php` to a file called `env.php` . This contains certain environment specific variables used in the app, including datbase connection settings and API keys.  
Now run `composer update` to download all the required packages.

##### 2. Get your API keys
Go to [www.blocktrail.com](https://www.blocktrail.com/) and sign up for a free API account.
Create an API key, and then add this with the corresponding secret to the `env.php` file.

For email functionality we use [Mailgun](https://mailgun.com). Sign up for an api key and then also add these to the `env.php` file. You can skip this step if you don't want to use the email feature.  
*(note that the .env.php file has been added to the .gitignore. You should always keep your API details secret)*

##### 3. Set up the server
run `php artisan serve` to quickly setup a nice little local server serve the app. Alternatively you can set up [Laravel Homestead](http://laravel.com/docs/4.2/homestead), the pre-packaged Vagrant virtual machine that provides you with a quick and easy local web server environment.

##### 4. Run the migrations and seed the database
If you've set up homestead then all the database config is ready for you to run migrations and database seeding. If not, then you need to set up your database and add the details to the `env.php`. When done you can run `php artisan migrate --seed` on homestead/locally to create the database tables and run the table seeders.


##### 5. You're good to go
With the server up and running now, simply navigate to [http://localhost:8000](http://localhost:8000) (or your homestead server) to see the simple wallet and block explorer at work.
A user and initial wallet has been created through the table seeders. You can log in with `email: test@test.com` `password: test`.

##### 6. Things to know
For webhooks to be created and used your server needs to be accessible via a public domain. When developing you can achieve this easily through the use of a tunnel.
[ngrok](https://ngrok.com/) allows you to easily set up a tunnel between your local environment and an external domain (either controlled by you, or a free subdomain on their domain).  
If you set up a tunnel to your local server, go into the `env.php` file and set the `'APP_URL'` setting to be the public URL. You'll need to do this before you run the database seeder, so that the initial wallet and webhook is created with the correct url.

*** Windows Developers ***  
A note for windows developers: you may encounter an issue in php with cURL and SSL certificates, where cURL is unable to verify a server's cert with a CA ((error 60)[http://curl.haxx.se/libcurl/c/libcurl-errors.html]).  
Too often the suggested solution is to disable ssl cert verification in cURL, but this completely defeats the point of using SSL. Instead you should take two very simple steps to solve the issue permanently:  

1. download `cacert.pem` from the [curl website](http://curl.haxx.se/docs/caextract.html). This is a bundle of trusted CA root certs extracted from mozilla.org. Save it in a folder within your php installation.  
2. open your `php.ini` and add/edit the following line (use an absolute path to where you placed the cert bundle):  
  ```
  curl.cainfo = C:\php\certs\cacert.pem
  ```


### Need Help?
Get in contact with us at [devs@blocktrail.com](mailto://devs@blocktrail.com) and we'll be happy to help you in any way we can.

A tutorial will be coming soon describing the steps to creating this personal Bitcoin wallet with Laravel.
