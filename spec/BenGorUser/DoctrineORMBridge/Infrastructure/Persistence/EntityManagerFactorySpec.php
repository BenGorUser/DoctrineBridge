<?php

/*
 * This file is part of the BenGorUser package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\BenGorUser\DoctrineORMBridge\Infrastructure\Persistence;

use BenGorUser\DoctrineORMBridge\Infrastructure\Persistence\EntityManagerFactory;
use BenGorUser\User\Domain\Model\User;
use Doctrine\ORM\EntityManager;
use PhpSpec\ObjectBehavior;

/**
 * Spec file of EntityManager class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class EntityManagerFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(EntityManagerFactory::class);
    }

    function it_get_user_of_id()
    {
        $this->build([
            'driver'   => 'pdo_mysql',
            'user'     => 'root',
            'password' => '',
            'dbname'   => 'bengor_user_db',
        ], true)->shouldReturnAnInstanceOf(EntityManager::class);
    }
}
