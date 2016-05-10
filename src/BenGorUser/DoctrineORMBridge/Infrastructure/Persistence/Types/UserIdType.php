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

namespace BenGorUser\DoctrineORMBridge\Infrastructure\Persistence\Types;

use BenGorUser\User\Domain\Model\UserId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

/**
 * Doctrine ORM user id custom type class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class UserIdType extends GuidType
{
    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof UserId) {
            return $value->id();
        }

        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new UserId($value);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'user_id';
    }
}
