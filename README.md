![PHPJasper logo](docs/images/phpjasper.png)
<!-- ALL-CONTRIBUTORS-BADGE:START - Do not remove or modify this section -->

# PHPJasper
_A PHP Report Generator_

[![Build Status](https://travis-ci.org/PHPJasper/phpjasper.svg?branch=master)](https://travis-ci.org/PHPJasper/phpjasper)
[![Coverage Status](https://coveralls.io/repos/github/PHPJasper/phpjasper/badge.svg?branch=master)](https://coveralls.io/github/PHPJasper/phpjasper?branch=master)
[![Latest Stable Version](https://poser.pugx.org/geekcom/phpjasper/v/stable)](https://packagist.org/packages/geekcom/phpjasper)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%207.2-blue.svg?style=flat-square)](https://php.net/)
[![Total Downloads](https://poser.pugx.org/geekcom/phpjasper/downloads)](https://packagist.org/packages/geekcom/phpjasper)
[![License](https://poser.pugx.org/geekcom/phpjasper/license)](https://packagist.org/packages/geekcom/phpjasper)
[![PHPStan](https://img.shields.io/badge/PHPStan-enabled-brightgreen.svg?style=flat)](https://github.com/phpstan/phpstan)
[![All Contributors](https://img.shields.io/badge/all_contributors-12-orange.svg?style=flat-square)](#contributors-)
<!-- ALL-CONTRIBUTORS-BADGE:END -->

### Docs

[![Language-pt_BR](https://img.shields.io/badge/pt__BR-100%25-green.svg?style=flat-square)](https://github.com/PHPJasper/phpjasper/blob/master/docs/pt_BR/LEIA-ME_pt_BR.md)

### About
PHPJasper is the best solution to compile and process JasperReports (.jrxml & .jasper files) just using PHP, in short: to generate reports using PHP.

#### Our channel on discord
https://discord.gg/7FpDnQ

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

* PHP 7.2 or above
* Java JDK 1.8

## Optional

* Any `jdbc` drivers to generate reports from a database (MySQL, PostgreSQL, MSSQL...), must be copied to a folder `bin/jasperstarter/jdbc`
* We ship the [PostgreSQL](https://jdbc.postgresql.org/) (42.2.9) in the `bin/jasperstarter/jdbc` directory.
* We ship the [MySQL connector](http://dev.mysql.com/downloads/connector/j/) (v5.1.48) in the `bin/jasperstarter/jdbc` directory.
* [Microsoft JDBC Drivers SQL Server
](https://docs.microsoft.com/en-us/sql/connect/jdbc/download-microsoft-jdbc-driver-for-sql-server?view=sql-server-ver15).
* [Jaspersoft Studio](http://community.jaspersoft.com/project/jaspersoft-studio) (to draw your reports).

## Installation

Install [Composer](http://getcomposer.org) if you don't have it.
```
composer require geekcom/phpjasper
```
Or in your file'composer.json' add:

```json
{
    "require": {
        "geekcom/phpjasper": "^3.2.0"
    }
}
```

And the just run:

    composer install

and thats it.

----------------------------------------------------------------------------------------------------------------------------

## PHPJasper with Docker

With Docker CE and docker-compose installed just run:

* `docker-compose up -d`
* `docker exec -it phpjasper composer install`

To execute tests:

* `docker exec -it phpjasper sudo composer test` or
* `docker exec -it phpjasper sudo composer testdox`

To see coverage manually of tests, execute the file: `tests/log/report/index.html`

_Help us writing new tests, make a fork_ :)

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
## Contributors ✨

Thanks goes to these wonderful people ([emoji key](https://allcontributors.org/docs/en/emoji-key)):

<!-- ALL-CONTRIBUTORS-LIST:START - Do not remove or modify this section -->
<!-- prettier-ignore-start -->
<!-- markdownlint-disable -->
<table>
  <tr>
    <td align="center"><a href="https://twitter.com/geekcom2"><img src="https://avatars2.githubusercontent.com/u/3955933?v=4" width="100px;" alt=""/><br /><sub><b>Daniel Rodrigues</b></sub></a><br /><a href="#infra-geekcom" title="Infrastructure (Hosting, Build-Tools, etc)">🚇</a> <a href="#maintenance-geekcom" title="Maintenance">🚧</a> <a href="https://github.com/PHPJasper/phpjasper/commits?author=geekcom" title="Code">💻</a></td>
    <td align="center"><a href="http://www.leandrobitencourt.com.br"><img src="https://avatars2.githubusercontent.com/u/13982234?v=4" width="100px;" alt=""/><br /><sub><b>Leandro Bitencourt</b></sub></a><br /><a href="https://github.com/PHPJasper/phpjasper/commits?author=lavela" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/vitormattos"><img src="https://avatars3.githubusercontent.com/u/1079143?v=4" width="100px;" alt=""/><br /><sub><b>Vitor Mattos</b></sub></a><br /><a href="https://github.com/PHPJasper/phpjasper/commits?author=vitormattos" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/rafaelqueiroz"><img src="https://avatars0.githubusercontent.com/u/275919?v=4" width="100px;" alt=""/><br /><sub><b>Rafael Queiroz</b></sub></a><br /><a href="https://github.com/PHPJasper/phpjasper/commits?author=rafaelqueiroz" title="Code">💻</a></td>
    <td align="center"><a href="http://dave.codes"><img src="https://avatars0.githubusercontent.com/u/5477476?v=4" width="100px;" alt=""/><br /><sub><b>Dave Bould</b></sub></a><br /><a href="https://github.com/PHPJasper/phpjasper/commits?author=dbould" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/ThiagoAlves31"><img src="https://avatars1.githubusercontent.com/u/32931011?v=4" width="100px;" alt=""/><br /><sub><b>ThiagoAlves31</b></sub></a><br /><a href="https://github.com/PHPJasper/phpjasper/commits?author=ThiagoAlves31" title="Code">💻</a></td>
    <td align="center"><a href="http://www.jadsonbr.com.br"><img src="https://avatars3.githubusercontent.com/u/10354607?v=4" width="100px;" alt=""/><br /><sub><b>Jadson Ribeiro</b></sub></a><br /><a href="https://github.com/PHPJasper/phpjasper/commits?author=jadsonbr" title="Code">💻</a></td>
  </tr>
  <tr>
    <td align="center"><a href="http://www.boaglio.com"><img src="https://avatars0.githubusercontent.com/u/6140?v=4" width="100px;" alt=""/><br /><sub><b>Fernando Boaglio</b></sub></a><br /><a href="https://github.com/PHPJasper/phpjasper/commits?author=boaglio" title="Code">💻</a></td>
    <td align="center"><a href="https://rahulja.in"><img src="https://avatars3.githubusercontent.com/u/1639945?v=4" width="100px;" alt=""/><br /><sub><b>Rahul Jain</b></sub></a><br /><a href="https://github.com/PHPJasper/phpjasper/commits?author=xRahul" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/lecneri"><img src="https://avatars2.githubusercontent.com/u/431453?v=4" width="100px;" alt=""/><br /><sub><b>Luiz Eduardo</b></sub></a><br /><a href="https://github.com/PHPJasper/phpjasper/commits?author=lecneri" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/davidribeiro"><img src="https://avatars0.githubusercontent.com/u/11426456?v=4" width="100px;" alt=""/><br /><sub><b>David Ribeiro</b></sub></a><br /><a href="https://github.com/PHPJasper/phpjasper/commits?author=davidribeiro" title="Code">💻</a></td>
    <td align="center"><a href="https://allenjd3.github.io"><img src="https://avatars3.githubusercontent.com/u/8092154?v=4" width="100px;" alt=""/><br /><sub><b>James Allen</b></sub></a><br /><a href="https://github.com/PHPJasper/phpjasper/commits?author=allenjd3" title="Code">💻</a></td>
  </tr>
</table>

<!-- markdownlint-enable -->
<!-- prettier-ignore-end -->
<!-- ALL-CONTRIBUTORS-LIST:END -->

This project follows the [all-contributors](https://github.com/all-contributors/all-contributors) specification. Contributions of any kind welcome!
