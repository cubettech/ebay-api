# Ebay Package 

    With this package we can retrieve seller list and ebay listing details of a logged in user.


## Requirements
    
    - PHP >=5.3
    
    - Laravel >=4.0
    
    - Illuminate/support 4.1.*


## Installation

This package is installable with Composer. Visit https://getcomposer.org/ for composer installation.

First you need to install laravel framework in your project folder. Run following command in terminal.

    $composer create-project laravel/laravel your-project-name --prefer-dist
    
Visit http://laravel.com/docs/installation for more documentation about laravel installation.

Give read and write permission to app/storage folder in the installed project.Then do the following.

    $ cd your-project-name
    
    $ composer require cubet/ebay dev-master
    
Add following line of code to the 'providers' array in app/config/app.php  

    Cubet\Ebay\EbayServiceProvider
    
Now you can access our package by pointing to the package function like this :

    http://localhost/project-folder/your-project-name/public/getebay
    
Note :

For testing purpose we used a sandbox test account. You can change all those test ebay keys to production level keys     in the vendor/cubet/ebay/src/config/config.php file.


## License

This Package is licensed under the [MIT License](http://opensource.org/licenses/MIT)


