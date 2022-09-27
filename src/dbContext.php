<?php
namespace ChemCommon;

use Doctrine\DBAL;
use Doctrine\Common;
use Monolog\Logger;
use TheCodingMachine\TDBM;

class dbContext
{
    public TDBM\TDBMService $ctx;

    function __construct(){
        $connectionParams = array(
            'user' => getenv('username'),
            'password' => getenv('password'),
            'host' => getenv('servername'),
            'dbname' => getenv('dbname'),
            'driver' => getenv('driver')
        );
        $DBALconfig = new DBAL\Configuration();
        $dbConnection = DBAL\DriverManager::getConnection($connectionParams, $DBALconfig);

        // The bean and DAO namespace that will be used to generate the beans and DAOs. These namespaces must be autoloadable from Composer.
        $baseSpace = (CORE_NAMESPACE != null) ? CORE_NAMESPACE : PROJECT_NAMESPACE;
        $beanNamespace = $baseSpace .'\\Beans';
        $daoNamespace = $baseSpace .'\\Daos';
        $cache = new Common\Cache\ArrayCache();
        $logger = new Logger('cantina-app'); // $logger must be a PSR-3 compliant logger (optional).

        // Let's build the configuration object
        $configuration = new TDBM\Configuration(
            $beanNamespace,
            $daoNamespace,
            $dbConnection,
            null,    // An optional "naming strategy" if you want to change the way beans/DAOs are named
            $cache,
            null,    // An optional SchemaAnalyzer instance
            $logger, // An optional logger
            []       // A list of generator listeners to hook into code generation
        );

        // The TDBMService is created using the configuration object.
        $this->ctx = new TDBM\TDBMService($configuration);
    }

}