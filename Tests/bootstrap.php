<?php

if (!is_file($autoloadFile = __DIR__.'/../vendor/autoload.php')) {
    throw new \LogicException('Could not find autoload.php in vendor/. Did you run "composer install --dev"?');
}

require $autoloadFile;

require_once __DIR__ . '/../vendor/doctrine/orm/lib/Doctrine/ORM/Mapping/Entity.php';
require_once __DIR__ . '/../vendor/doctrine/orm/lib/Doctrine/ORM/Mapping/Table.php';
require_once __DIR__ . '/../vendor/doctrine/orm/lib/Doctrine/ORM/Mapping/Id.php';
require_once __DIR__ . '/../vendor/doctrine/orm/lib/Doctrine/ORM/Mapping/Column.php';
require_once __DIR__ . '/../vendor/doctrine/orm/lib/Doctrine/ORM/Mapping/GeneratedValue.php';
require_once __DIR__ . '/../vendor/doctrine/orm/lib/Doctrine/ORM/Mapping/OneToMany.php';
require_once __DIR__ . '/../vendor/doctrine/orm/lib/Doctrine/ORM/Mapping/ManyToOne.php';