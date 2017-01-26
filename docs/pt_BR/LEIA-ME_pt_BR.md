# PHPJasper

[![Build Status](https://travis-ci.org/geekcom/phpjasper.svg?branch=master)](https://travis-ci.org/geekcom/phpjasper)
[![CircleCI](https://circleci.com/gh/geekcom/phpjasper/tree/master.svg?style=shield)](https://circleci.com/gh/geekcom/phpjasper/tree/master)
[![StyleCI](https://styleci.io/repos/46984485/shield?branch=master)](https://styleci.io/repos/46984485)
[![Latest Stable Version](https://poser.pugx.org/geekcom/phpjasper/v/stable)](https://packagist.org/packages/geekcom/phpjasper)
[![Total Downloads](https://poser.pugx.org/geekcom/phpjasper/downloads)](https://packagist.org/packages/geekcom/phpjasper)
[![Latest Unstable Version](https://poser.pugx.org/geekcom/phpjasper/v/unstable)](https://packagist.org/packages/geekcom/phpjasper)
[![License](https://poser.pugx.org/geekcom/phpjasper/license)](https://packagist.org/packages/geekcom/phpjasper) 
[![Bitcoin Donations](https://img.shields.io/badge/bitcoin-donation-orange.svg)](https://blockchain.info/address/1LqwqcMfNuNzq6S671z1HjM61MpBuFCGqg)

###Documentação
[![Language-en_US](https://img.shields.io/badge/en__US-100%25-green.svg)](https://github.com/geekcom/phpjasper/blob/master/README.md)
[![Language-de_DE](https://img.shields.io/badge/de__DE-10%25-red.svg)](https://github.com/geekcom/phpjasper/blob/master/docs/de_DE/LESEN-MICH.md)


###Sobre a biblioteca

Este pacote é a solução perfeita para compilar e processar relatórios Jasper (.jrxml & .jasper) com PHP puro ou através do Laravel Framework.

**Seu servidor é Linux?**

Não esqueça de fornecer permissão 777 para o diretório
**/vendor/geekcom/phpjasper/src/JasperStarter/bin** e para o arquivo binário **jasperstarter**

**Precisa gerar relatórios em Python?**

Conheça a biblioteca **[pyreport](https://github.com/jadsonbr/pyreport)**

###Por quê preciso do PHPJasper?

Alguma vez você precisou de um relatório simples ou complexo em PHP para seu sistema web?

Eu já precisei e fui em busca de algumas soluções, a maioria delas é complexa e você precisa escrever *HTML* + *CSS* para gerar um *PDF*, isso não faz sentido, além de ser muito trabalhoso :)

Apresento para vocês **JasperReports** a melhor solução open source que existe para relatórios.

###O que eu posso fazer com isso?

**Texto extraido do site JasperSoft:**

> A biblioteca JasperReports é o mecanismo de geração de relatórios de código aberto mais popular do mundo. É inteiramente escrito em Java e é capaz de usar dados provenientes de qualquer tipo de fonte de dados e gerar documentos perfeitos que podem ser visualizado, impressom ou exportadom em uma variedade de formatos de documentos, incluindo HTML, PDF, Excel, OpenOffice e Word .

*Exemplos do que você pode fazer:*

* Faturas
* Relatórios
* Listas


##Requisitos

* Java JDK 1.8
* PHP [exec()](http://php.net/manual/function.exec.php) function

##Opcional

* [Mysql JDBC Driver](http://dev.mysql.com/downloads/connector/j/) (se você pretende usar esse tipo de banco de dados)
* [PostgreSQL JDBC Driver](https://jdbc.postgresql.org/download.html) (se você pretende usar esse tipo de banco de dados)
* [Microsoft JDBC Drivers](https://www.microsoft.com/en-US/download/details.aspx?id=11774) (se você pretende usar esse tipo de banco de dados)
* [Jaspersoft Studio](http://community.jaspersoft.com/project/jaspersoft-studio) (para escrever e compilar seus relatórios)

###Instalando o Java(JDK)

Verifique se o JDK está instalado:

```
$ javac -version
javac version 1.8.0_101
```

Se você receber a resposta:

    command not found: javac

Então você precisa instalar, para o (Ubuntu/Debian) rode o comando:

    $ sudo apt-get install default-jdk

Para instalar no (centOS/Fedora) faça o seguinte:

    # yum install java-1.8.0-openjdk.x86_64

Para instalar no Windows visite o link-> [JDK](http://www.oracle.com/technetwork/pt/java/javase/downloads/jdk8-downloads-2133151.html) e veja qual a versão mais apropriada para o seu Sistema Operacional.

Agora rode novamente o comando `javac -version` e veja se deu tudo certo.

---------------------------------------------------------------------------------------------------------------------------

##Instalando a biblioteca PHPJasper

Instale o [Composer](http://getcomposer.org), e rode o comando:

```
composer require geekcom/phpjasper
```

Ou crie um arquivo 'composer.json' e adicione o trecho:

```javascript
{
    "require": {
        "geekcom/phpjasper": "1.*"
    }
}
```

E execute o comando:

    composer install

é isso, você tem a biblioteca instalada e pronta para uso.

----------------------------------------------------------------------------------------------------------------------------

##Exemplos

###*Hello World* PHPJasper.

Vá para o diretório de exemplos na raiz do repositório (`vendor/copam/phpjasper/examples`).
Abra o arquivo `hello_world.jrxml` com o JasperStudio ou seu editor favorito  e dê uma olhada no código.

#### Compilando

#### Compilando

Primeiro precisamos compilar o arquivo com a extensão `.JRXML` em um arquivo binário do tipo `.JASPER`

**Nota 1:** Caso você não queira usar o *Jaspersoft Studio*. É possivel compilar o seu arquivo .jrxml da seguinte forma:

```php

require __DIR__ . '/vendor/autoload.php';

use JasperPHP\JasperPHP;

$input = __DIR__ . '/vendor/geekcom/phpjasper/examples/hello_world.jrxml';   

$jasper = new JasperPHP;
$jasper->compile($input)->execute();
```

Esse comando compila o arquivo fonte `hello_world.jrxml` em um arquivo binário `hello_world.jasper`.

####Processando

Agora vamos processar o nosso relatório que foi compilado acima:

```php

require __DIR__ . '/vendor/autoload.php';

use JasperPHP\JasperPHP;

$input = __DIR__ . '/vendor/geekcom/phpjasper/examples/hello_world.jasper';  
$output = __DIR__ . '/vendor/geekcom/phpjasper/examples';    

$jasper = new JasperPHP;

$jasper->process(
    $input, //input
    $output, //output
	['pdf', 'rtf'], //formats
	[],    //parameters
	[],    //data_source
	'en'   //locale
)->execute();
```

Agora olhe a pasta **/examples** :) Ótimo trabalho? Você tem  2 arquivos, `hello_world.pdf` e `hello_world.rtf`.

####Listando parâmetros

Como consultar o arquivo jrxml para examinar os parâmetros disponíveis no relatório:

```php

require __DIR__ . '/vendor/autoload.php';

use JasperPHP\JasperPHP;

$input = __DIR__ . '/vendor/geekcom/phpjasper/examples/hello_world_params.jrxml';

$jasper = new JasperPHP;
$output = $jasper->list_parameters($input)->execute();

foreach($output as $parameter_description)
    print $parameter_description . '<pre>';
```

###Relatórios a partir de um banco de dados

Adicione os parâmetros específicos para conexão com seu banco de dados:

```php
require __DIR__ . '/vendor/autoload.php';

use JasperPHP\JasperPHP;    

$input = '/pasta_de_entrada/seu_relatorio.jasper';   
$output = '/pasta_de_saida';
$format = 'pdf'; //formato do relatorio
$locale = 'pt_BR'; //idioma do relatorio

$jasper = new JasperPHP;

$jasper->process(
        $input,
        $output,
        $format,
        [], //parametros
        [
            'driver' => 'postgres',
            'username' => 'DB_USERNAME',
            'password' => 'DB_PASSWORD',
            'host' => 'DB_HOST',
            'database' => 'DB_DATABASE',
            'schema' => 'DB_SCHEMA',
            'port' => '5432'
	 ],
        $locale
)->execute();
```

**Nota 2:**

Para a lista completa de idiomas suportados veja o link [Supported Locales](http://www.oracle.com/technetwork/java/javase/java8locales-2095355.html)

###Relatórios com banco de dados MSSQL

```php

require __DIR__ . '/vendor/autoload.php';

use JasperPHP\JasperPHP;

$input = '/pasta_de_entrada/seu_relatorio.jasper ou .jrxml';   
$output = '/pasta_de_saida';
$format = 'pdf'; //formato do relatorio
$locale = 'pt_BR'; //idioma do relatorio

$jdbc_dir = __DIR__ . '/vendor/geekcom/phpjasper/src/JasperStarter/jdbc/';

$jasper = new JasperPHP;

$jasper->process(
        $input,
        $output,
        $format,
        [], //parametros
        [
            'driver' => 'generic',
            'host' => '127.0.0.1',
            'port' => '1433',
            'database' => 'DataBaseName',
            'username' => 'UserName',
            'password' => 'password',
            'jdbc_driver' => 'com.microsoft.sqlserver.jdbc.SQLServerDriver',
            'jdbc_url' => 'jdbc:sqlserver://127.0.0.1:1433;databaseName=Teste',
            'jdbc_dir' => $jdbc_dir
        ],
        $locale
    )->execute();
```

###[opcional] Como usar PHPJasper com Laravel 5 em diante

* Instale o [Composer](http://getcomposer.org)
```
composer require geekcom/phpjasper
```
Ou crie um arquivo 'composer.json' e adicione o trecho:

```javascript
{
    "require": {
        "geekcom/phpjasper": "1.*"
    }
}
```

* Rode o comando:

    **composer update**

* Adicione o provider ao array providers em config/app.php:

    **JasperPHP\JasperPHPServiceProvider::class,**

* Crie a pasta **/report** em **/public directory**

* Copie o arquivo **hello_world.jrxml** em **/vendor/geekcom/phpjasper/examples** para a pasta: **/public/report**

* Copie o código abaixo para seu arquivo **route.php**

**Nota 3:** no Laravel 5.3 os arquivos de rota estão localizados em **/routes** 

```php
use JasperPHP\JasperPHP;

Route::get('/reports', function () {
    
    $report = new JasperPHP;
    
    $report->process(
        public_path() . '/report/hello_world.jrxml', //entrada 
        public_path() . '/report/'.time().'_hello_world', //saida
        ['pdf', 'rtf', 'xml'], //formats
        [], //parametros
        [],  //fonte de dados
        '', //idioma do relatorio
        )->execute();
});
```

* Rode **php artisan serve**

* Acesse **localhost:8000/reports**

* Abra a pasta **/public/report**. você terá 3 arquivos, `hello_world.pdf`, `hello_world.rtf` e `hello_world.xml`.

Neste exemplo nós geramos relatórios com as seguintes extensões pdf, rtf and xml.


###[Opcional] Relatórios a partir de um arquivo xml em PHP/Laravel 5 em diante

Veja como é fácil gerar um relatório com uma fonte de um arquivo JSON:

```php

use JasperPHP\JasperPHP;

public function xmlToPdf()
    {
        $output = public_path() . '/report/'.time().'_CancelAck';
        $ext = "pdf";
        $data_file = public_path() . '/report/CancelAck.xml';
        $driver = 'xml';
        $xml_xpath = '/CancelResponse/CancelResult/ID';
        $locale = 'pt_BR';
        
        $php_jasper = new JasperPHP;
        
        $php_jasper->process(
            public_path() . '/report/CancelAck.jrxml', //input
            $output, //saida
            [$ext], //formatos
            [], //parametros
            ['data_file' => $data_file, 'driver' => $driver, 'xml_xpath' => $xml_xpath], //fonte de dados
            $locale //idioma
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


**Não esqueça de escrever sua rota**

```php
Route::get('reports/xml', 'ReportsController@xmlToPdf');
```
**simplesmente acesse**:

http://localhost:8000/reports/xml

**Nota 3:** 
Para usar o exemplo acima você precisa copiar os arquivos localizados em:

**\vendor\geekcom\phpjasper\examples\CancelAck.jrxml** 
e
**\vendor\geekcom\phpjasper\examples\CancelAck.xml** 

para a pasta:

**\public\report** 


###[opcional] Relatórios a partir de um arquivo JSON em PHP/Laravel 5 em diante

```php

use JasperPHP\JasperPHP;

public function jsonToPdf()
    {
        $output = public_path() . '/report/'.time().'_Contacts';
        $ext = "pdf";
        $driver = 'json';
        $json_query= "contacts.person";
        $data_file = public_path() . '/report/contacts.json';
        $locale = 'pt_BR';
            
        $php_jasper = new JasperPHP;
        
        $php_jasper->process(
            public_path() . '/report/json.jrxml', //entrada
            $output, //saida
            [$ext], //formato
            [], //parametro
            ['data_file' => $data_file, 'driver' => $driver, 'json_query' => $json_query],
            $locale //idioma
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

**Escreva sua rota**

```php
Route::get('reports/json', 'ReportsController@jsonToPdf');
```

**acesse**:

http://localhost:8000/reports/json

**Nota 4:**

Copie os arquivos em

**\vendor\geekcom\phpjasper\examples\json.jrxml**
e
**\vendor\geekcom\phpjasper\examples\contacts.json**

Para:

**\public\report**


###MySQL

Incluímos o [MySQL connector](http://dev.mysql.com/downloads/connector/j/) (v5.1.39) na pasta `/src/JasperStarter/jdbc/`

###PostgreSQL

Incluímos também o [PostgreSQL](https://jdbc.postgresql.org/) (v9.4-1203) na pasta `/src/JasperStarter/jdbc/`

###MSSQL

[Microsoft JDBC Drivers 6.0, 4.2, 4.1, and 4.0 for SQL Server
](https://www.microsoft.com/en-us/download/details.aspx?displaylang=en&id=11774).

##Performance

Depende da complexidade do seu relatório.

##Agradecimentos

[Cenote GmbH](http://www.cenote.de/) pelo [JasperStarter](http://jasperstarter.sourceforge.net/) tool.

[JetBrains](https://www.jetbrains.com/) pelo [PhpStorm](https://www.jetbrains.com/phpstorm/) e seu grande apoio.


##[Dúvidas?](https://github.com/geekcom/phpjasper/issues)

Abra uma [Issue](https://github.com/geekcom/phpjasper/issues) ou procure por Issues antigas


##[Licença](https://github.com/geekcom/phpjasper/blob/master/LICENSE)

MIT

##[Contribuição](https://github.com/geekcom/phpjasper/blob/master/CONTRIBUTING.md)

Contribua com a comunidade PHP e Laravel, sinta-se à vontade para contribuir, faça um fork !!
