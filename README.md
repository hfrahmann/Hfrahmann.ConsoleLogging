Hfrahmann.ConsoleLogging
========================

A Console-Logging-Package for TYPO3 Flow with FirePHP and ChromePHP

Configuration
-------------

Add this to your Settings.yaml

``` yaml
Hfrahmann:
  ConsoleLogging:
    # Enable ConsoleLogging in Development context (Default=true)
    EnableDevelopment: true

    # Enable ConsoleLogging in Production context (Default=false)
    EnableProduction: false

    # Enable ConsoleLogging for SQL-Querys (Default=false)
    SqlLogging: true

    # Enable ConsoleLogging for ActionController-Requests (Default=false)
    ActionControllerLogging: true

    # Enable ConsoleLogging for Request-Infos (Default=false)
    RequestInfoLogging: true

```

Example
-------

``` php
class MyTYPO3FlowClass {

    /**
     * @var \Hfrahmann\ConsoleLogging\Logger
     * @Flow\Inject
     */
    protected $consoleLog;

    public function exampleMethod() {
        $this->consoleLog->info("Lorem Ipsum");
        $this->consoleLog->warn($someObject, "optional label");
        $this->consoleLog->error("something went wrong!", "Errorlabel");
    }

}
```

You can also add groups to the log.

``` php
$this->consoleLog->group("Grouplabel");
$this->consoleLog->info("Groupcontent #1");
$this->consoleLog->info("Groupcontent #2");
$this->consoleLog->groupEnd();
```


Licence
-------

This package is licensed under the MIT licence.