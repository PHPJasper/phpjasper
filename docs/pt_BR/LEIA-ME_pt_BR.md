![PHPJasper logo](../images/phpjasper.png)

# PHPJasper

_Gerador de relatórios PHP_

[![Build Status](https://travis-ci.org/PHPJasper/phpjasper.svg?branch=master)](https://travis-ci.org/PHPJasper/phpjasper)
[![Coverage Status](https://coveralls.io/repos/github/PHPJasper/phpjasper/badge.svg?branch=master)](https://coveralls.io/github/PHPJasper/phpjasper?branch=master)
[![Latest Stable Version](https://poser.pugx.org/geekcom/phpjasper/v/stable)](https://packagist.org/packages/geekcom/phpjasper)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%207.2-blue.svg?style=flat-square)](https://php.net/)
[![Total Downloads](https://poser.pugx.org/geekcom/phpjasper/downloads)](https://packagist.org/packages/geekcom/phpjasper)
[![License](https://poser.pugx.org/geekcom/phpjasper/license)](https://packagist.org/packages/geekcom/phpjasper)
[![PHPStan](https://img.shields.io/badge/PHPStan-enabled-brightgreen.svg?style=flat)](https://github.com/phpstan/phpstan) 

### Documentação
[![Language-en_US](https://img.shields.io/badge/en__US-100%25-green.svg)](https://github.com/PHPJasper/phpjasper/blob/master/README.md)

### Sobre a biblioteca

PHPJasper é a solução perfeita para compilar e processar relatórios Jasper (.jrxml & .jasper) com PHP, ou seja, gerar relatórios com PHP.

**Notas:** 
* PHPJasper pode ser usado independente de seu Framework
* Se você está usando uma versão menor que PHP 7.0 veja: [v1.16](https://github.com/PHPJasper/phpjasper/releases/tag/v1.16)
* [Aqui](https://github.com/PHPJasper/examples) tem vários exemplos de como usar PHPJasper

### Por quê preciso do PHPJasper?

Alguma vez você precisou de um relatório simples ou complexo em PHP para seu sistema web?

Eu já precisei e fui em busca de algumas soluções, a maioria delas é complexa e você precisa escrever *HTML* + *CSS* para gerar um *PDF*, isso não faz sentido, além de ser muito trabalhoso :)

Apresento para vocês **JasperReports** a melhor solução open source que existe para relatórios.

### O que eu posso fazer com isso?

**Texto extraido do site JasperSoft:**

> A biblioteca JasperReports é o mecanismo de geração de relatórios de código aberto mais popular do mundo. É inteiramente escrito em Java e é capaz de usar dados provenientes de qualquer tipo de fonte de dados e gerar documentos perfeitos que podem ser visualizado, impresso ou exportado em uma variedade de formatos de documentos, incluindo HTML, PDF, Excel, OpenOffice e Word .

*Exemplos do que você pode fazer:*

* Faturas
* Relatórios
* Listas

## Requisitos

* PHP 7.2 em diante
* Java JDK 1.8

## Opcional

* Qualquer driver jdbc (MySQL, PostgreSQL, MSSQL...), para ser usado deve ser copiado para a pasta `bin/jasperstarter/jdbc`
* Incluímos o [MySQL connector](http://dev.mysql.com/downloads/connector/j/) (v5.1.48) na pasta `bin/jasperstarter/jdbc`
* Incluímos também o [PostgreSQL](https://jdbc.postgresql.org/) (42.2.9) na pasta `bin/jasperstarter/jdbc`
* [Microsoft JDBC Drivers](https://www.microsoft.com/en-US/download/details.aspx?id=11774) (se você pretende usar esse tipo de banco de dados)
* [Jaspersoft Studio](http://community.jaspersoft.com/project/jaspersoft-studio) (para escrever e compilar seus relatórios)

## Instalando a biblioteca PHPJasper

Instale o [Composer](http://getcomposer.org), e rode o comando:

```
composer require geekcom/phpjasper
```

Ou crie um arquivo 'composer.json' e adicione o trecho:

```json
{
    "require": {
        "geekcom/phpjasper": "^3.2.0"
    }
}
```

E execute o comando:

    composer install

é isso, você tem a biblioteca instalada e pronta para uso.

----------------------------------------------------------------------------------------------------------------------------
## PHPJasper com Docker

Com o Docker CE e o docker-compose instalados basta executar os comandos:

* `docker-compose up -d`
* `docker exec -it phpjasper composer install`

Para rodar os testes dentro do container execute:

* `docker exec -it phpjasper sudo composer test` ou
* `docker exec -it phpjasper sudo composer testdox`

Para ver o coverage basta executar o arquivo: `tests/log/report/index.html`

_Ajude-nos escrevendo novos testes, faça um fork_ :)

----------------------------------------------------------------------------------------------------------------------------

## Exemplos

### *Hello World* PHPJasper.

Vá para o diretório de exemplos na raiz do repositório (`vendor/geekcom/phpjasper/examples`).
Abra o arquivo `hello_world.jrxml` com o JasperStudio ou seu editor favorito  e dê uma olhada no código.

#### Compilando

Primeiro precisamos compilar o arquivo com a extensão `.JRXML` em um arquivo binário do tipo `.JASPER`

**Nota 1:** Caso você não queira usar o *Jaspersoft Studio*. É possivel compilar o seu arquivo .jrxml da seguinte forma:

```php

require __DIR__ . '/vendor/autoload.php';

use PHPJasper\PHPJasper;

$input = __DIR__ . '/vendor/geekcom/phpjasper/examples/hello_world.jrxml';   

$jasper = new PHPJasper;
$jasper->compile($input)->execute();
```

Esse comando compila o arquivo fonte `hello_world.jrxml` em um arquivo binário `hello_world.jasper`.

#### Processando

Agora vamos processar o nosso relatório que foi compilado acima:

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

Agora olhe a pasta **/examples** :) Ótimo trabalho? Você tem  2 arquivos, `hello_world.pdf` e `hello_world.rtf`.

#### Listando parâmetros

Como consultar o arquivo jrxml para examinar os parâmetros disponíveis no relatório:

```php

require __DIR__ . '/vendor/autoload.php';

use PHPJasper\PHPJasper;

$input = __DIR__ . '/vendor/geekcom/phpjasper/examples/hello_world_params.jrxml';

$jasper = new PHPJasper;
$output = $jasper->listParameters($input)->execute();

foreach($output as $parameter_description)
    print $parameter_description . '<pre>';
```

### Relatórios a partir de um banco de dados

Adicione os parâmetros específicos para conexão com seu banco de dados: MYSQL, POSTGRES ou MSSQL:

```php
require __DIR__ . '/vendor/autoload.php';

use PHPJasper\PHPJasper;    

$input = '/your_input_path/your_report.jasper';   
$output = '/your_output_path';
$options = [
    'format' => ['pdf'],
    'locale' => 'pt_BR',
    'params' => [],
    'db_connection' => [
        'driver' => 'postgres',
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

**Nota 2:**

Para a lista completa de idiomas suportados veja o link [Supported Locales](http://www.oracle.com/technetwork/java/javase/java8locales-2095355.html)

### Relatórios com banco de dados MSSQL

```php
require __DIR__ . '/vendor/autoload.php';

use PHPJasper\PHPJasper;

$input = '/your_input_path/your_report.jasper or .jrxml';   
$output = '/your_output_path';
$jdbc_dir = __DIR__ . '/vendor/geekcom/phpjasper/bin/jaspertarter/jdbc';
$options = [
    'format' => ['pdf'],
    'locale' => 'pt_BR',
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

### Relatórios a partir de um arquivo XML

```php
require __DIR__ . '/vendor/autoload.php';

use PHPJasper\PHPJasper;

$input = '/your_input_path/your_report.jasper';   
$output = '/your_output_path';
$data_file = __DIR__ . '/your_data_files_path/your_xml_file.xml';
$options = [
    'format' => ['pdf'],
    'params' => [],
    'locale' => 'pt_BR',
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

### Relatórios a partir de um arquivo JSON

```php
require __DIR__ . '/vendor/autoload.php';

use PHPJasper\PHPJasper;

$input = '/your_input_path/your_report.jasper';   
$output = '/your_output_path';

$data_file = __DIR__ . '/your_data_files_path/your_json_file.json';
$options = [
    'format' => ['pdf'],
    'params' => [],
    'locale' => 'pt_BR',
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

Depende da complexidade do seu relatório.

## Agradecimentos

[Cenote GmbH](http://www.cenote.de/) pelo [JasperStarter](https://bitbucket.org/cenote/jasperstarter/) tool.

[JetBrains](https://www.jetbrains.com/) pelo [PhpStorm](https://www.jetbrains.com/phpstorm/) e seu grande apoio.


## [Dúvidas?](https://github.com/PHPJasper/phpjasper/issues)

Abra uma [Issue](https://github.com/PHPJasper/phpjasper/issues) ou procure por Issues antigas


## [Licença](https://github.com/PHPJasper/phpjasper/blob/master/LICENSE)

MIT

## [Contribuição](https://github.com/PHPJasper/phpjasper/blob/master/CONTRIBUTING.md)

Contribua com a comunidade PHP, faça um fork !!
