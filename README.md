# JasperReports for PHP and Laravel Framework

[![Latest Stable Version](https://poser.pugx.org/dericktan/phpjasper/v/stable)](https://packagist.org/packages/dericktan/phpjasper)
[![License](https://poser.pugx.org/dericktan/phpjasper/license)](https://packagist.org/packages/dericktan/phpjasper)
[![Monthly Downloads](https://poser.pugx.org/dericktan/phpjasper/d/monthly)](https://packagist.org/packages/dericktan/phpjasper)
[![Total Downloads](https://poser.pugx.org/dericktan/phpjasper/downloads)](https://packagist.org/packages/dericktan/phpjasper)

**Is using Linux servers?**

Do not forget to grant permission 777 for the directory **/vendor/dericktan/phpjasper/src/JasperStarter/bin** and the file binary **jasperstarter**

##Introduction

This package aims to be a solution to compile and process JasperReports (.jrxml & .jasper files).

###Why?

Did you ever had to create a good looking Invoice with a lot of fields for your great web app?

I had to, and the solutions out there were not perfect. Generating *HTML* + *CSS* to make a *PDF*? WTF? That doesn't make any sense! :)

Then I found **JasperReports** the best open source solution for reporting.

###What can I do with this?

Well, everything. JasperReports is a powerful tool for **reporting** and **BI**.

**From their website:**

> The JasperReports Library is the world's most popular open source reporting engine. It is entirely written in Java and it is able to use data coming from any kind of data source and produce pixel-perfect documents that can be viewed, printed or exported in a variety of document formats including HTML, PDF, Excel, OpenOffice and Word.

I recommend using [Jaspersoft Studio](http://community.jaspersoft.com/project/jaspersoft-studio) to build your reports, connect it to your datasource (ex: MySQL, POSTGRES), loop thru the results and output it to PDF, XLS, DOC, RTF, ODF, etc.

*Some examples of what you can do:*

* Invoices
* Reports
* Listings

Package to generate reports with [JasperReports 6](http://community.jaspersoft.com/project/jasperreports-library) library through [JasperStarter v3](http://jasperstarter.sourceforge.net/) command-line tool.

##Requirements

* Java JDK 1.8
* PHP [exec()](http://php.net/manual/function.exec.php) function
* [optional] [Mysql Connector](http://dev.mysql.com/downloads/connector/j/) (if you want to use database)
* [optional] [PostgreSQL Connector](https://jdbc.postgresql.org/download.html) (if you want to use database)
* [optional] [Jaspersoft Studio](http://community.jaspersoft.com/project/jaspersoft-studio) (to draw and compile your reports)

##Installation

###Java

Check if you already have Java installed:

```
$ java -version
java version "1.8.0_65"
Java(TM) SE Runtime Environment (build 1.8.0_65-b17)
Java HotSpot(TM)  Client VM (build 25.65-b01, mixed mode, sharing)
```

If you get:

	command not found: java

Then install it with: (Ubuntu/Debian)

	$ sudo apt-get install default-jdk

Now run the `java -version` again and check if the output is ok.

##Install

Install [Composer](http://getcomposer.org) if you don't have it.
```
composer require dericktan/phpjasper
```
Or in your 'composer.json' file add:

```javascript
{
    "require": {
		"dericktan/phpjasper": "1.*"
    }
}
```

And the just run:

	composer install

and thats it.

##Examples

###The *Hello World* example.

Go to the examples directory in the root of the repository (`vendor/dericktan/phpjasper/examples`).
Open the `hello_world.jrxml` file with iReport or with your favorite text editor and take a look at the source code.

#### Compiling

First we need to compile our `JRXML` file into a `JASPER` binary file. We just have to do this one time.

**Note:** You don't need to do this step if you are using *Jaspersoft Studio*. You can compile directly within the program.

```php

require __DIR__ . '/vendor/autoload.php';

use JasperPHP\JasperPHP;

$input = __DIR__ . '/vendor/dericktan/phpjasper/examples/hello_world.jrxml';

$jasper = new JasperPHP;
$jasper->compile($input)->execute();
```

This commando will compile the `hello_world.jrxml` source file to a `hello_world.jasper` file.

####Processing

Now lets process the report that we compile before:

```php

require __DIR__ . '/vendor/autoload.php';

use JasperPHP\JasperPHP;

$input = __DIR__ . '/vendor/dericktan/phpjasper/examples/hello_world.jasper';
$output = __DIR__;

$jasper = new JasperPHP;

$jasper->process(
	$input,
	$output,
	array("pdf", "rtf")
)->execute();
```

Now check the examples folder! :) Great right? You now have 2 files, `hello_world.pdf` and `hello_world.rtf`.

Check the *API* of the  `compile` and `process` functions in the file `src/JasperPHP/JasperPHP.php` file.

####Listing Parameters

Querying the jasper file to examine parameters available in the given jasper report file:

```php

require __DIR__ . '/vendor/autoload.php';

use JasperPHP\JasperPHP;

$input = __DIR__ . '/vendor/dericktan/phpjasper/examples/hello_world_params.jrxml';

$jasper = new JasperPHP;
$output = $jasper->list_parameters($input)->execute();

foreach($output as $parameter_description)
    print $parameter_description . '<pre>';
```

###Advanced example - using a database

We can also specify parameters for connecting to database:

```php

require __DIR__ . '/vendor/autoload.php';

use JasperPHP\JasperPHP;    

$input = __DIR__ . '/vendor/dericktan/phpjasper/examples/hello_world.jrxml';   
$output = __DIR__ . '/vendor/dericktan/phpjasper/examples';    

private $conn;

public function __construct()
{
    $this->conn = [
        'driver' => 'postgres',
        'username' => 'DB_USERNAME',
        'password' => 'DB_PASSWORD',
        'host' => 'DB_HOST',
        'database' => 'DB_DATABASE',
        'schema' => 'DB_SCHEMA',
        'port' => '5432'
    ];
}    

$jasper = new JasperPHP;

$jasper->process(
        $input,
        $output,
        array("pdf", "rtf"),
        array("php_version" => phpversion()),
        $this->conn, 
        true, 
        true, 
        'in-ID' //LOCALE *note 2
)->execute();
```
**Note**

For a complete list of locales see [Supported Locales](http://www.oracle.com/technetwork/java/javase/java8locales-2095355.html)

###Using JasperPHP with Laravel 5.*

1. Install [Composer](http://getcomposer.org) if you don't have it.
```
composer require dericktan/phpjasper
```
Or in your 'composer.json' file add:

```javascript
{
    "require": {
		"dericktan/phpjasper": "1.*"
    }
}
```
2. And the just run:

	**composer update**

3. Add to your config/app.php providers array:

	**JasperPHP\JasperPHPServiceProvider::class,**

4. Create a folder **/report** on **/public directory**

5. Copy the file **hello_world.jrxml** in **/vendor/dericktan/phpjasper/examples** from directory: **/public/report**

6. Run **php artisan serve**

7. Access **localhost:8000/reports**

8. Check the directory **/public/report**. You now have 3 files, `hello_world.pdf`, `hello_world.rtf` and `hello_world.xml`.

**Below the code you will use in your route.php**

```php
use JasperPHP\JasperPHP;

Route::get('/reports', function () {

    $output = public_path() . '/report/'.time().'_hello_world';
    $report = new JasperPHP;
    $report->process(
    	public_path() . '/report/hello_world.jrxml',
        $output,
        array('pdf', 'rtf', 'xml'),
        array(),
        array()  
        )->execute();
});
```
In this example we generate reports pdf, rtf and xml.


###Reports from a xml in PHP/Laravel 5.*

See how easy it is to generate a report with a source an XML file:

```php

use JasperPHP\JasperPHP;

public function xmlToPdf()
    {
        $output = public_path() . '/report/'.time().'_CancelAck';
        $ext = "pdf";
        $data_file = public_path() . '/report/CancelAck.xml';
        $driver = 'xml';
        $xml_xpath = '/CancelResponse/CancelResult/ID';
		
        $jasper = new JasperPHP;
        
        $jasper->process(
            public_path() . '/report/CancelAck.jrxml',
            $output,
            array($ext),
            array(),
            array('data_file' => $data_file, 'driver' => $driver, 'xml_xpath' => $xml_xpath),                   
            false,
            false
        )->execute();

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.time().'_CancelAck.'.$ext);
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Content-Length: ' . filesize($output.'.'.$ext));
        flush();
        readfile($output.'.'.$ext);
        unlink($output.'.'.$ext);

    }
```
**Note:**

To use the example above you must copy the sample files located at:

**\vendor\dericktan\phpjasper\examples\CancelAck.jrxml**
and
**\vendor\dericktan\phpjasper\examples\CancelAck.xml**
to folder:
**\public\report**


###Reports from a JSON File in PHP/Laravel 5.*

See how easy it is to generate a report with a source an JSON file:

```php

use JasperPHP\JasperPHP;

public function jsonToPdf()
    {
        $output = public_path() . '/report/'.time().'_Contacts';
        $ext = "pdf";
        $driver = 'json';
        $json_query= "contacts.person";
        $data_file = public_path() . '/report/contacts.json';

        $jasper = new JasperPHP;

        $jasper->process(
            public_path() . '/report/json.jrxml',
            $output,
            array($ext),
            array(),
            array('data_file' => $data_file, 'driver' => $driver, 'json_query' => $json_query
        )->execute();

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.time().'_Contacts.'.$ext);
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Content-Length: ' . filesize($output.'.'.$ext));
        flush();
        readfile($output.'.'.$ext);
        unlink($output.'.'.$ext);

    }
```

**Note:**

To use the example above you must copy the sample files located at:

**\vendor\dericktan\phpjasper\examples\json.jrxml**
and
**\vendor\dericktan\phpjasper\examples\contacts.json**
to folder:
**\public\report**

###MySQL

We ship the [MySQL connector](http://dev.mysql.com/downloads/connector/j/) (v5.1.39) in the `/src/JasperStarter/jdbc/` directory.

###PostgreSQL

We ship the [PostgreSQL](https://jdbc.postgresql.org/) (v9.4-1203) in the `/src/JasperStarter/jdbc/` directory.

##Performance

Depends on the complexity, amount of data and the resources of your machine (let me know your use case).

I have a report that generates a *Invoice* with a DB connection, images and multiple pages and it takes about **3/4 seconds** to process. I suggest that you use a worker to generate the reports in the background.

##Thanks

Thanks to [Cenote GmbH](http://www.cenote.de/) for the [JasperStarter](http://jasperstarter.sourceforge.net/) tool.

##Questions?

Drop me a line on Skype [leandro.bittencourt16] or E-Mail [leandrocintrabitencourt@gmail.com]

Drop me a line on Skype [danielrodrigueslima] or E-Mail [danielrodrigues-ti@hotmail.com]

Drop me a line on E-Mail [derick.tan988@gmail.com]

##License

MIT
