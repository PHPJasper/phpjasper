# PHPJasper
_A PHP Report Generator_

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/geekcom/phpjasper/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/geekcom/phpjasper/?branch=master)
[![Latest Stable Version](https://img.shields.io/packagist/v/geekcom/phpjasper.svg?style=flat-square)](https://packagist.org/packages/geekcom/phpjasper)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.0-blue.svg?style=flat-square)](https://php.net/)
[![License](https://poser.pugx.org/geekcom/phpjasper/license)](https://packagist.org/packages/geekcom/phpjasper)

### Docs
[![Language-pt_BR](https://img.shields.io/badge/pt__BR-100%25-green.svg)](https://github.com/PHPJasper/phpjasper/blob/master/docs/pt_BR/LEIA-ME_pt_BR.md)

### About
PHPJasper is the best solution to compile and process JasperReports (.jrxml & .jasper files) just using PHP, in short: to generate reports using PHP.

**Notes:** 
* PHPJasper Can be used regardless of your PHP Framework
* For PHP versions less than 7.0 see: [v1.16](https://github.com/PHPJasper/phpjasper/releases/tag/v1.16)
* [Here](https://github.com/PHPJasper/examples) are several examples of how to use PHPJasper


### Why PHPJasper?

Did you ever had to create a good looking Invoice with a lot of fields for your great web app?

I had to, and the solutions out there were not perfect. Generating *HTML* + *CSS* to make a *PDF*? That doesn't make any sense! :)

Then I found **JasperReports** the best open source solution for reporting.

### What can I do with this?

Well, everything. JasperReports is a powerful tool for **reporting** and **BI**.

**From their website:**

> The JasperReports Library is the world's most popular open source reporting engine. It is entirely written in Java and it is able to use data coming from any kind of data source and produce pixel-perfect documents that can be viewed, printed or exported in a variety of document formats including HTML, PDF, Excel, OpenOffice and Word.

It is recommended using [Jaspersoft Studio](http://community.jaspersoft.com/project/jaspersoft-studio) to build your reports, connect it to your datasource (ex: MySQL, POSTGRES), loop thru the results and output it to PDF, XLS, DOC, RTF, ODF, etc.

*Some examples of what you can do:*

* Invoices
* Reports
* Listings

## Requirements

* PHP 7.0 or above
* Java JDK 1.8

## Optional

* [Mysql JDBC Driver](http://dev.mysql.com/downloads/connector/j/) (If you want to use a database)
* [PostgreSQL JDBC Driver](https://jdbc.postgresql.org/download.html) (If you want to use a database)
* [Microsoft JDBC Drivers](https://www.microsoft.com/en-US/download/details.aspx?id=11774) (If you want to use a database)
* [Jaspersoft Studio](http://community.jaspersoft.com/project/jaspersoft-studio) (to draw and compile your reports)

### Java(JDK)

Check if you already have Java installed:

```
$ javac -version
javac version 1.8.0_101
```

If you get:

    command not found: javac

Then install it with: (Ubuntu/Debian)

    $ sudo apt-get install default-jdk

To install on: (centOS/Fedora)

    # yum install java-1.8.0-openjdk.x86_64

To install on windows visit the link-> [JDK](http://www.oracle.com/technetwork/pt/java/javase/downloads/jdk8-downloads-2133151.html) and look for the most appropriate version for your system.

Now run the `javac -version` again and check if the output is ok.

---------------------------------------------------------------------------------------------------------------------------

## Installation

Install [Composer](http://getcomposer.org) if you don't have it.
```
composer require geekcom/phpjasper
```
Or in your file'composer.json' add:

```json
{
    "require": {
        "geekcom/phpjasper": "^2.7"
    }
}
```

And the just run:

    composer install

and thats it.

----------------------------------------------------------------------------------------------------------------------------

## Examples

### The *Hello World* example.

Go to the examples directory in the root of the repository (`vendor/geekcom/phpjasper/examples`).
Open the `hello_world.jrxml` file with Jaspersoft Studio or with your favorite text editor and take a look at the source code.

#### Compiling

First we need to compile our `JRXML` file into a `JASPER` binary file. We just have to do this one time.

**Note 1:** You don't need to do this step if you are using *Jaspersoft Studio*. You can compile directly within the program.

```php

require __DIR__ . '/vendor/autoload.php';

use PHPJasper\PHPJasper;

$input = __DIR__ . '/vendor/geekcom/phpjasper/examples/hello_world.jrxml';   

$jasper = new PHPJasper;
$jasper->compile($input)->execute();
```

This commando will compile the `hello_world.jrxml` source file to a `hello_world.jasper` file.

#### Processing

Now lets process the report that we compile before:

```php

require __DIR__ . '/vendor/autoload.php';

use PHPJasper\PHPJasper;

$input = __DIR__ . '/vendor/geekcom/phpjasper/examples/hello_world.jasper';  
$output = __DIR__ . '/vendor/geekcom/phpjasper/examples';    
$options = [ 
    'format' => ['pdf', 'rtf'] 
];

$jasper = new PHPJasper;

$jasper->process(
    $input,
    $output,
    $options
)->execute();
```

Now check the examples folder! :) Great right? You now have 2 files, `hello_world.pdf` and `hello_world.rtf`.

Check the *methods* `compile` and `process` in `src/JasperPHP.php` for more details

#### Listing Parameters

Querying the jasper file to examine parameters available in the given jasper report file:

```php

require __DIR__ . '/vendor/autoload.php';

use PHPJasper\PHPJasper;

$input = __DIR__ . '/vendor/geekcom/phpjasper/examples/hello_world_params.jrxml';

$jasper = new PHPJasper;
$output = $jasper->listParameters($input)->execute();

foreach($output as $parameter_description)
    print $parameter_description . '<pre>';
```

### Using database to generate reports

We can also specify parameters for connecting to database:

```php
require __DIR__ . '/vendor/autoload.php';

use PHPJasper\PHPJasper;    

$input = '/your_input_path/your_report.jasper';   
$output = '/your_output_path';
$options = [
    'format' => ['pdf'],
    'locale' => 'en',
    'params' => [],
    'db_connection' => [
        'driver' => 'postgres', //mysql, ....
        'username' => 'DB_USERNAME',
        'password' => 'DB_PASSWORD',
        'host' => 'DB_HOST',
        'database' => 'DB_DATABASE',
        'port' => '5432'
    ]
];

$jasper = new PHPJasper;

$jasper->process(
        $input,
        $output,
        $options
)->execute();
```

**Note 2:**

For a complete list of locales see [Supported Locales](http://www.oracle.com/technetwork/java/javase/java8locales-2095355.html)

### Using MSSQL DataBase

```php
require __DIR__ . '/vendor/autoload.php';

use PHPJasper\PHPJasper;

$input = '/your_input_path/your_report.jasper or .jrxml';   
$output = '/your_output_path';
$jdbc_dir = __DIR__ . '/vendor/geekcom/phpjasper/bin/jaspertarter/jdbc';
$options = [
    'format' => ['pdf'],
    'locale' => 'en',
    'params' => [],
    'db_connection' => [
        'driver' => 'generic',
        'host' => '127.0.0.1',
        'port' => '1433',
        'database' => 'DataBaseName',
        'username' => 'UserName',
        'password' => 'password',
        'jdbc_driver' => 'com.microsoft.sqlserver.jdbc.SQLServerDriver',
        'jdbc_url' => 'jdbc:sqlserver://127.0.0.1:1433;databaseName=Teste',
        'jdbc_dir' => $jdbc_dir
    ]
];

$jasper = new PHPJasper;

$jasper->process(
        $input,
        $output,
        $options
    )->execute();
```

### Reports from a XML

```php
require __DIR__ . '/vendor/autoload.php';

use PHPJasper\PHPJasper;

$input = '/your_input_path/your_report.jasper';   
$output = '/your_output_path';
$data_file = __DIR__ . '/your_data_files_path/your_xml_file.xml';
$options = [
    'format' => ['pdf'],
    'params' => [],
    'locale' => 'en',
    'db_connection' => [
        'driver' => 'xml',
        'data_file' => $data_file,
        'xml_xpath' => '/your_xml_xpath'
    ]
];

$jasper = new PHPJasper;

$jasper->process(
    $input,
    $output,
    $options
)->execute();
```

### Reports from a JSON

```php
require __DIR__ . '/vendor/autoload.php';

use PHPJasper\PHPJasper;

$input = '/your_input_path/your_report.jasper';   
$output = '/your_output_path';

$data_file = __DIR__ . '/your_data_files_path/your_json_file.json';
$options = [
    'format' => ['pdf'],
    'params' => [],
    'locale' => 'en',
    'db_connection' => [
        'driver' => 'json',
        'data_file' => $data_file,
        'json_query' => 'your_json_query'
    ]
];

$jasper = new PHPJasper;

$jasper->process(
    $input,
    $output,
    $options
)->execute();
```

### MySQL

We ship the [MySQL connector](http://dev.mysql.com/downloads/connector/j/) (v5.1.39) in the `/src/JasperStarter/jdbc/` directory.

### PostgreSQL

We ship the [PostgreSQL](https://jdbc.postgresql.org/) (v9.4-1203) in the `/src/JasperStarter/jdbc/` directory.

### MSSQL

[Microsoft JDBC Drivers 6.0, 4.2, 4.1, and 4.0 for SQL Server
](https://www.microsoft.com/en-us/download/details.aspx?displaylang=en&id=11774).

## Performance

Depends on the complexity, amount of data and the resources of your machine (let me know your use case).

I have a report that generates a *Invoice* with a DB connection, images and multiple pages and it takes about **3/4 seconds** to process. I suggest that you use a worker to generate the reports in the background.

## Thanks

[Cenote GmbH](http://www.cenote.de/) for the [JasperStarter](http://jasperstarter.sourceforge.net/) tool.

[JetBrains](https://www.jetbrains.com/) for the [PhpStorm](https://www.jetbrains.com/phpstorm/) and all great tools.


## [Questions?](https://github.com/PHPJasper/phpjasper/issues)

Open a new [Issue](https://github.com/PHPJasper/phpjasper/issues) or look for a closed issue


## [License](https://github.com/PHPJasper/phpjasper/blob/master/LICENSE)

MIT

## [Contribute](https://github.com/PHPJasper/phpjasper/blob/master/CONTRIBUTING.md)

Contribute to the community PHP, make a fork!