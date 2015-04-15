<?php

require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Application;
use Delegator\POBoxRestrictions\Console\Command\BuildCommand;
use Delegator\POBoxRestrictions\Console\Command\CheckCommand;
use Delegator\POBoxRestrictions\Console\Command\CleanCommand;

$package = simplexml_load_file('package.xml');
$application = new Application();
$application->setName('Delegator - POBoxRestrictions extension make tool');
$application->setVersion($package->version);
$application->add(new BuildCommand);
$application->add(new CheckCommand);
$application->add(new CleanCommand);
$application->run();
