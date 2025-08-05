<?php
//The first argument is the application container, and is required; if you implement the FactoryInterface, you must also define a second argument, $requestedName, which is the service name mapping to the factory, and an optional third argument, $options, 
namespace Blog\Factory;

use Interop\Container\ContainerInterface;
use Blog\Model\Post;
use Blog\Model\LaminasDbSqlRepository;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Hydrator\ReflectionHydrator;
use Laminas\ServiceManager\Factory\FactoryInterface;

class LaminasDbSqlRepositoryFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new LaminasDbSqlRepository(
            $container->get(AdapterInterface::class),
            new ReflectionHydrator(),
            new Post('', '')
        );
    }
}