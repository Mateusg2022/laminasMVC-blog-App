<?php

namespace Album\Model;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class AlbumTableFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName,  ?array $options = null): AlbumTable
    {
        $dbAdapter = $container->get(AdapterInterface::class);
        $resultSetPrototype = new ResultSet();
        //isso diz ao resultSetPrototype: sempre que você receber uma linha da tabela como resultado, transforme essa linha em um objeto da classe Album."
        $resultSetPrototype->setArrayObjectPrototype(new Album());
        $tableGateway = new TableGateway('album', $dbAdapter, null, $resultSetPrototype);
        return new AlbumTable($tableGateway);
    }
}

//O TableGateway precisa saber como montar um objeto Album com os dados retornados do banco.
//Para isso, ele usa o padrão Prototype 

//Em vez de fazer isso sempre:
//new Album()

//Ele faz:
//clone $albumPrototype;