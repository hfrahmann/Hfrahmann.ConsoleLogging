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
        $chromephpPath = FLOW_PATH_PACKAGES . 'Libraries/ccampbell/chromephp/ChromePHP.php';
        if(file_exists($chromephpPath))
            require_once($chromephpPath);

        parent::boot($bootstrap);
    }

}

?>