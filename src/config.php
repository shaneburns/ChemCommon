<?php
namespace ChemCommon;
/**
 * Startup
 */
class config
{
    public array $stdSettings;
    public array $settings;

    function __construct(array $settings)
    {
        // Default settings setup
        $this->stdSettings = array(
            "dr" => $_SERVER['DOCUMENT_ROOT'],
            "ds" => DIRECTORY_SEPARATOR,
            'ENV_DETAILS_PATH' => null,
            'PROJECT_NAMESPACE' => null,
            'CORE_NAMESPACE' => null,
            'CONTROLLER_NAMESPACE' => 'controllers',
            'DEFAULT_CONTROLLER' => 'home',
            'DEFAULT_ACTION' => 'index',
            'DEFAULT_VERIFICATION_CONTROLLER' => 'verification',
            'DEFAULT_VERIFICATION_ACTION' => 'requestAccessForm',
            'VERIFY_ACCESS_ACTION' => 'validateAccess'
        );
        $this->settings = array_merge($this->stdSettings, $settings);
    }

}