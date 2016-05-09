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

namespace BenGorUser\User\Infrastructure\Persistence\Doctrine\ORM\Types;

use BenGorUser\User\Domain\Model\UserRole;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\JsonArrayType;

/**
 * Doctrine ORM user role collection custom type class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
final class UserRolesType extends JsonArrayType
{
    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        $roles = array_map(function (UserRole $role) {
            return $role->role();
        }, $value);

        return json_encode($roles);
    }

    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $userRoles = array_map(function ($role) {
            return new UserRole($role);
        }, json_decode($value));

        return $userRoles;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'user_roles';
    }
}
