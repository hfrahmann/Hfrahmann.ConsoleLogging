<?php
namespace TYPO3\ConsoleLogging;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "TYPO3.Logging".         *
 *                                                                        */

use TYPO3\Flow\Package\Package as BasePackage;

/**
 *
 */
class Package extends BasePackage {

    /**
     * Invokes custom PHP code directly after the package manager has been initialized.
     *
     * @param \TYPO3\Flow\Core\Bootstrap $bootstrap The current bootstrap
     * @return void
     */
    public function boot(\TYPO3\Flow\Core\Bootstrap $bootstrap) {
        define("TYPO3_CONSOLELOGGING_PACKAGEKEY", "TYPO3.ConsoleLogging");

        parent::boot($bootstrap);
    }

}

?>