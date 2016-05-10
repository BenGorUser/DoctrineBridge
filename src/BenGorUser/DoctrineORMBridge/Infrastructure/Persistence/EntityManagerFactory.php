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

namespace BenGorUser\DoctrineORMBridge\Infrastructure\Persistence;

use BenGorUser\DoctrineORMBridge\Infrastructure\Persistence\Types\UserGuestIdType;
use BenGorUser\DoctrineORMBridge\Infrastructure\Persistence\Types\UserIdType;
use BenGorUser\DoctrineORMBridge\Infrastructure\Persistence\Types\UserRolesType;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

/**
 * Doctrine ORM entity manager factory class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class EntityManagerFactory
{
    /**
     * Creates an entity manager instance enabling mappings and custom types.
     *
     * @param mixed $aConnection Connection parameters as db driver
     * @param bool  $isDevMode   Enables the dev mode, by default is enabled
     *
     * @return EntityManager
     */
    public function build($aConnection, $isDevMode = true)
    {
        Type::addType('user_id', UserIdType::class);
        Type::addType('user_guest_id', UserGuestIdType::class);
        Type::addType('user_roles', UserRolesType::class);

        return EntityManager::create(
            $aConnection,
            Setup::createYAMLMetadataConfiguration([__DIR__ . '/Mapping'], $isDevMode)
        );
    }
}
