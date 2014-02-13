# Ebay Package 

    Package to retrieve seller list and ebay listing details of a logged in user.


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

(The MIT License)

Copyright Cubet Techno Labs (c) 2013 info@cubettech.com

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the 'Software'), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED 'AS IS', WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.


