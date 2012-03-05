<?php

require_once dirname(__FILE__) . '/GettextExtractor.class.php';

$outputFile = $argv[1];
//$outputFile = 'output.po';
$inputFiles = array_slice($argv, 2);
//$inputFiles = array('Tests/testfile.php', 'Tests/testfile.phtml');

$ge = new GettextExtractor();

$ge->filters['php'] = array('PHP');
$ge->filters['phtml'] = array('PHP', 'NetteCurlyBrackets');

$data = $ge->extract($inputFiles);

$ge->write($outputFile);

echo 'OK!';

//var_dump($data);