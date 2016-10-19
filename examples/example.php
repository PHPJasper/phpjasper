<?php

require __DIR__ . '/../src/JasperPHP/JasperPHP.php';

$outputPdfRtf = __DIR__;
$jasperFile = __DIR__ . '/hello_world.jasper';
$jrxmlFile = __DIR__ . '/hello_world.jrxml';
$jrxmlParamsFile = __DIR__ . '/hello_world_params.jrxml';

$jasper = new JasperPHP\JasperPHP;

// compiling jrxml file into jasper file
$jasper->compile($jrxmlFile)->execute();

// processing jasper file into pdf and rtf
$jasper->process(
    $jasperFile,
    $outputPdfRtf,
    array("pdf", "rtf")
)->execute();

// Listing Parameters of jasper file
$jasperParameters = $jasper->list_parameters($jrxmlParamsFile)->execute();
print "<h2>Listing Parameters of jasper file</h2>\n";
foreach($jasperParameters as $parameter_description) {
    print "<pre>" . $parameter_description . "</pre>\n";
}