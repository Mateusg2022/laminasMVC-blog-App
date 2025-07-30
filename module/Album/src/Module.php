<?php

    namespace Album;

    use Laminas\ModuleManager\Feature\ConfigProviderInterface;

    class Module implements ConfigProviderInterface
    {
        public function getConfig()
        {
            return include __DIR__ . '/../config/module.config.php';
        }
    }

/**
 * The Album module has separate directories for the different types of files we 
 * will have. The PHP files that contain classes within the Album namespace live in 
 * the src/ directory. The view directory also has a sub-folder called album for our 
 * module's view scripts.

 * In order to load and configure a module, Laminas provides a ModuleManager. This will 
 * look for a Module class in the specified module namespace (i.e., Album); in the 
 * case of our new module, that means the class Album\Module, which will be found in 
 * module/Album/src/Module.php.
 */