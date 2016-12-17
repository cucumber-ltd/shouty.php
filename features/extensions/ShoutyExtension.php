<?php

use Shouty\Shouty;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Behat\Testwork\ServiceContainer\Extension;
use Behat\Behat\Context\ServiceContainer\ContextExtension;
use Behat\Behat\Context\Initializer\ContextInitializer;
use Behat\Behat\Context\Context;

class ShoutyInitializer implements ContextInitializer
{
    public function __construct()
    {
    }

    public function supportsContext(Context $context)
    {
        return true;
    }

    public function initializeContext(Context $context)
    {
    }
}

class ShoutyExtension implements Extension
{
    public function getConfigKey()
    {
        return 'shouty_initializer';
    }
    public function load(ContainerBuilder $container, array $config)
    {
        $definition = $container->register('shouty_initializer', 'ShoutyInitializer');
        $definition->addTag(ContextExtension::INITIALIZER_TAG);
    }
    public function configure(ArrayNodeDefinition $builder) {}
    public function initialize(ExtensionManager $extensionManager) {}
    public function process(ContainerBuilder $container) {}
}
return new ShoutyExtension;
