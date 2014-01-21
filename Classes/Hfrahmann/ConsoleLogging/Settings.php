<?php
namespace Hfrahmann\ConsoleLogging;

/*                                                                         *
 * This script belongs to the TYPO3 Flow package "Hfrahmann.ConsoleLogging".    *
 *                                                                         *
 *                                                                         */

use TYPO3\Flow\Annotations as Flow;

/**
 * @Flow\Scope("singleton")
 */
class Settings {

    /**
     * @var array
     */
    protected $settings = array();

    /**
     * @param array $settings
     */
    public function injectSettings(array $settings) {
        $this->settings = $settings;
    }

    /**
     * @return bool
     */
    public function isDevelopmentEnabled() {
        if( isset($this->settings[ 'EnableDevelopment' ]) )
            return $this->settings[ 'EnableDevelopment' ];
        return TRUE;
    }

    /**
     * @return bool
     */
    public function isProductionEnabled() {
        if( isset($this->settings[ 'EnableProduction' ]) )
            return $this->settings[ 'EnableProduction' ];
        return FALSE;
    }

    /**
     * @return bool
     */
    public function isSqlLoggingEnabled() {
        if( isset($this->settings[ 'SqlLogging' ]) )
            return $this->settings[ 'SqlLogging' ];
        return FALSE;
    }

    /**
     * @return bool
     */
    public function isActionControllerLoggingEnabled() {
        if( isset($this->settings[ 'ActionControllerLogging' ]) )
            return $this->settings[ 'ActionControllerLogging' ];
        return FALSE;
    }

    /**
     * @return bool
     */
    public function isRequestInfoLoggingEnabled() {
        if( isset($this->settings[ 'RequestInfoLogging' ]) )
            return $this->settings[ 'RequestInfoLogging' ];
        return FALSE;
    }

}
