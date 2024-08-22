<?php
namespace ChemCommon;

// use const PROJECT_NAMESPACE;
/**
* Chemistry
 */
class startup
{
    public config $config;
    private result $result;

    function __construct(config $config){
        // Store config locally
        $this->config = $config;
        
        try{
            $this->DefineEnvConstants($config->settings);

            if(is_null(PROJECT_NAMESPACE) || is_null(ENV_DETAILS_PATH)){
                $this->result = new result("FATAL CHEMISTRY APPLICATION ERROR :: - \nThe expected PROJECT_NAMESPACE or ENV_DETAILS_PATH variables were not located in the defined constants scope.");
                $this->result->display();
                die();
            }
            // Parse .env file for
            $this->putEnvVars(parse_ini_file(ENV_DETAILS_PATH));

            // Require SSL if designated
            if(getenv('requireSSL') && (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off")) $this->sslRedirect();

            if(getenv('ENVIRONMENT') === 'development'){
                error_reporting(E_ALL);
                ini_set('display_errors', 1);
            }else{
                error_reporting(0);
                ini_set('display_errors', 0);
            }

        }catch(\Exception $e){
            $this->result = new result($e, 500);
            $this->result->display();
        }
    }

    public function putEnvVars(array $vars) : void
    {
        foreach($vars as $key => $val) putenv($key."=".$val);
    }
    
    public function DefineEnvConstants(array $constants) : void
    {
        foreach($constants as $var => $val ){
            if(!defined($var)){
                define($var, $val);
            }
        }
    }

    private function sslRedirect() : void
    {
        // Permanently redirect please
        $this->result = new result(null, 301, ['Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']]);
        $this->result->display();
        exit;
    }
}