<?php
namespace TYPO3\ConsoleLogging;

/*                                                                         *
 * This script belongs to the TYPO3 Flow package "TYPO3.ConsoleLogger".    *
 *                                                                         *
 *                                                                         */

use TYPO3\Flow\Annotations as Flow;

/**
 *
 * @Flow\Scope("singleton")
 * @api
 */
class Logger {

    /**
     * @var string
     */
    const CLIENT_NONE = "none";

    /**
     * @var string
     */
    const CLIENT_FIREPHP = "firephp";

    /**
     * @var string
     */
    const CLIENT_CHROMEPHP = "chromephp";

    /**
     * @var string
     */
    const TYPE_INFO = "info";

    /**
     * @var string
     */
    const TYPE_WARN = "warn";

    /**
     * @var string
     */
    const TYPE_ERROR = "error";

    /**
     * @var string
     */
    protected $consoleClientType = self::CLIENT_NONE;

    /**
     * @var bool
     */
    protected $isEnabled = FALSE;

    /**
     * @param \TYPO3\Flow\Object\ObjectManagerInterface $objectManager
     * @param \TYPO3\Flow\Core\Bootstrap $bootstrap
     * @param \TYPO3\ConsoleLogging\Settings $settings
     */
    public function __construct(\TYPO3\Flow\Object\ObjectManagerInterface $objectManager,
                                \TYPO3\Flow\Core\Bootstrap $bootstrap,
                                \TYPO3\ConsoleLogging\Settings $settings) {
        if($bootstrap->getContext()->isTesting()        === TRUE
        || ($bootstrap->getContext()->isDevelopment()   === TRUE && $settings->isDevelopmentEnabled()   === TRUE)
        || ($bootstrap->getContext()->isProduction()    === TRUE && $settings->isProductionEnabled()    === TRUE)) {
            $this->isEnabled = TRUE;
        }

        if($this->isEnabled === FALSE)
            return;

        $packageManager = $objectManager->get("TYPO3\\Flow\\Package\\PackageManagerInterface");
        $resourcePath = $packageManager->getPackage(TYPO3_CONSOLELOGGING_PACKAGEKEY)->getResourcesPath();

        $userAgent = '';
        if(array_key_exists('HTTP_USER_AGENT', $_SERVER))
            $userAgent = $_SERVER['HTTP_USER_AGENT'];

        if (strpos($userAgent, 'Firefox') !== FALSE) {
            // include FirePHP from Package firephp.firephpcore
            $firephpPath = $resourcePath
                         . "PHP" . DIRECTORY_SEPARATOR
                         . "FirePHPCore" . DIRECTORY_SEPARATOR
                         . "lib" . DIRECTORY_SEPARATOR
                         . "FirePHPCore" . DIRECTORY_SEPARATOR
                         . "FirePHP.class.php";
            if(file_exists($firephpPath))
                require_once($firephpPath);

            $this->consoleClientType = self::CLIENT_FIREPHP;
        }

        if (strpos($userAgent, 'Chrome') !== FALSE) {
            // include ChromePHP from Resources
            $chromephpPath = $resourcePath
                           . "PHP" . DIRECTORY_SEPARATOR
                           . "chromephp" . DIRECTORY_SEPARATOR
                           . "ChromePhp.php";
            if(file_exists($chromephpPath))
                require_once($chromephpPath);

            $this->consoleClientType = self::CLIENT_CHROMEPHP;
        }
    }

    /**
     * @param mixed $value
     * @param string $label
     * @param string $type
     * @return void
     */
    protected function log($value, $label = "", $type = self::TYPE_INFO) {
        if($this->isEnabled === FALSE)
            return;

        switch($this->consoleClientType) {
            case self::CLIENT_FIREPHP:
                \FirePHP::getInstance(TRUE)->fb($value, $label, $type);
                break;
            case self::CLIENT_CHROMEPHP:
                \ChromePhp::log($label, $value, $type);
                break;
        }
    }

    /**
     * @param mixed $value
     * @param string $label
     * @return void
     */
    public function info($value, $label = NULL) {
        $this->log($value, $label, self::TYPE_INFO);
    }

    /**
     * @param mixed $value
     * @param string $label
     * @return void
     */
    public function warn($value, $label = NULL) {
        $this->log($value, $label, self::TYPE_WARN);
    }

    /**
     * @param mixed $value
     * @param string $label
     * @return void
     */
    public function error($value, $label = NULL) {
        $this->log($value, $label, self::TYPE_ERROR);
    }

    /**
     * @param string $label
     * @param bool $collapsed
     * @return void
     */
    public function group($label = "", $collapsed = TRUE) {
        if($this->isEnabled === FALSE)
            return;

        switch($this->consoleClientType) {
            case self::CLIENT_FIREPHP:
                \FirePHP::getInstance(TRUE)->group($label, array("Collapsed" => $collapsed));
                break;
            case self::CLIENT_CHROMEPHP:
                if($collapsed === TRUE)
                    \ChromePhp::groupCollapsed($label);
                else
                    \ChromePHP::group($label);
                break;
        }
    }

    /**
     * @return void
     */
    public function groupEnd() {
        if($this->isEnabled === FALSE)
            return;

        switch($this->consoleClientType) {
            case self::CLIENT_FIREPHP:
                \FirePHP::getInstance(TRUE)->groupEnd();
                break;
            case self::CLIENT_CHROMEPHP:
                \ChromePhp::groupEnd();
                break;
        }
    }

}

?>
