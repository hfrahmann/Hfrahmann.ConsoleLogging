<?php
namespace TYPO3\ConsoleLogging;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "TYPO3.ConsoleLogging"   *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

/**
 *
 * @Flow\Aspect
 * @Flow\Scope("singleton")
 */
class LoggingAspect {

    /**
     * @var \TYPO3\ConsoleLogging\Settings $settings
     */
    protected $settings;

    /**
     * @var \TYPO3\ConsoleLogging\Logger
     */
    protected $consoleLog;

    /**
     * @param Settings $settings
     */
    public function __construct(\TYPO3\ConsoleLogging\Settings $settings) {
        $this->settings = $settings;
    }

    /**
     * @param Logger $consoleLog
     */
    public function injectConsoleLog(\TYPO3\ConsoleLogging\Logger $consoleLog) {
        $this->consoleLog = $consoleLog;
        $this->logRequestInfo();
    }

    /**
     * Logging request data and memory usage
     */
    public function logRequestInfo() {
        if($this->consoleLog === NULL || $this->settings->isRequestInfoLoggingEnabled() === FALSE)
            return;

        $this->consoleLog->group('Request', FALSE);

        if(isset($_REQUEST))
            $this->consoleLog->info($_REQUEST, 'Request-Data');

        $realUsage = memory_get_peak_usage(true);
        $realUsage = ($realUsage / 1024 / 1024) . ' MB';
        $this->consoleLog->info($realUsage, 'Memory Peak Usage');

        $this->consoleLog->groupEnd();
    }

    /**
     *
     * @param \TYPO3\Flow\AOP\JoinPointInterface $joinPoint
     * @Flow\Before("method(TYPO3\Flow\Persistence\Doctrine\Logging\SqlLogger->startQuery())")
     */
    public function logSqlLogger(\TYPO3\Flow\AOP\JoinPointInterface $joinPoint) {
        if($this->consoleLog === NULL || $this->settings->isSqlLoggingEnabled() === FALSE)
            return;

        $this->consoleLog->group('SQL-Log');
        $this->consoleLog->info($joinPoint->getMethodArgument('sql'), 'Query');
        $this->consoleLog->info($joinPoint->getMethodArgument('params'), 'Params');
        $this->consoleLog->groupEnd();
    }

    /**
     *
     * @param \TYPO3\Flow\AOP\JoinPointInterface $joinPoint
     * @Flow\Before("method(.*Controller.*->(?!initialize).*Action())")
     */
    public function logRequestedControllerAction(\TYPO3\Flow\AOP\JoinPointInterface $joinPoint) {
        if($this->consoleLog === NULL || $this->settings->isActionControllerLoggingEnabled() === FALSE)
            return;

        $this->consoleLog->group('Action Request');
        $this->consoleLog->info($joinPoint->getClassName() . '->' . $joinPoint->getMethodName(), 'Method');
        $this->consoleLog->info($joinPoint->getMethodArguments(), 'Params');
        $this->consoleLog->groupEnd();
    }

}

?>
