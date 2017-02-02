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

use BenGorUser\DoctrineORMBridge\Infrastructure\Persistence\DoctrineORMUserRepository;
use BenGorUser\User\Domain\Model\User;
use BenGorUser\User\Domain\Model\UserEmail;
use BenGorUser\User\Domain\Model\UserId;
use BenGorUser\User\Domain\Model\UserRepository;
use BenGorUser\User\Domain\Model\UserToken;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Persisters\Entity\EntityPersister;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\UnitOfWork;
use PhpSpec\ObjectBehavior;

/**
 * Spec file of DoctrineORMUserRepository class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class DoctrineORMUserRepositorySpec extends ObjectBehavior
{
    function let(EntityManager $manager, ClassMetadata $metadata)
    {
        $this->beConstructedWith($manager, $metadata);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DoctrineORMUserRepository::class);
    }

    function it_implements_user_doctrine_repository()
    {
        $this->shouldImplement(UserRepository::class);
    }

    function it_extends_entity_repository()
    {
        $this->shouldHaveType(EntityRepository::class);
    }

    function it_get_user_of_id(User $user, EntityManager $manager)
    {
        $manager->find(null, 'user-id', null, null)->shouldBeCalled()->willReturn($user);

        $this->userOfId(new UserId('user-id'))->shouldReturn($user);
    }

    function it_get_all(
        User $user,
        EntityManager $manager,
        UnitOfWork $unitOfWork,
        EntityPersister $entityPersister
    ) {
        $manager->getUnitOfWork()->shouldBeCalled()->willReturn($unitOfWork);
        $unitOfWork->getEntityPersister(null)->shouldBeCalled()->willReturn($entityPersister);
        $entityPersister->loadAll(
            [],
            null,
            null,
            null
        )->shouldBeCalled()->willReturn([$user]);

        $this->all()->shouldReturn([$user]);
    }

    function it_get_user_of_email(
        User $user,
        EntityManager $manager,
        UnitOfWork $unitOfWork,
        EntityPersister $entityPersister
    ) {
        $manager->getUnitOfWork()->shouldBeCalled()->willReturn($unitOfWork);
        $unitOfWork->getEntityPersister(null)->shouldBeCalled()->willReturn($entityPersister);
        $entityPersister->load(
            ['email.email' => 'bengor@user.com'],
            null,
            null,
            [],
            null,
            1,
            null
        )->shouldBeCalled()->willReturn($user);

        $this->userOfEmail(new UserEmail('bengor@user.com'))->shouldReturn($user);
    }

    function it_get_user_of_confirmation_token(
        User $user,
        EntityManager $manager,
        UnitOfWork $unitOfWork,
        EntityPersister $entityPersister
    ) {
        $manager->getUnitOfWork()->shouldBeCalled()->willReturn($unitOfWork);
        $unitOfWork->getEntityPersister(null)->shouldBeCalled()->willReturn($entityPersister);
        $entityPersister->load(
            ['confirmationToken.token' => 'confirmation-token'],
            null,
            null,
            [],
            null,
            1,
            null
        )->shouldBeCalled()->willReturn($user);

        $this->userOfConfirmationToken(new UserToken('confirmation-token'))->shouldReturn($user);
    }

    function it_get_user_of_invitation_token(
        User $user,
        EntityManager $manager,
        UnitOfWork $unitOfWork,
        EntityPersister $entityPersister
    ) {
        $manager->getUnitOfWork()->shouldBeCalled()->willReturn($unitOfWork);
        $unitOfWork->getEntityPersister(null)->shouldBeCalled()->willReturn($entityPersister);
        $entityPersister->load(
            ['invitationToken.token' => 'invitation-token'],
            null,
            null,
            [],
            null,
            1,
            null
        )->shouldBeCalled()->willReturn($user);

        $this->userOfInvitationToken(new UserToken('invitation-token'))->shouldReturn($user);
    }

    function it_get_user_of_remember_password_token(
        User $user,
        EntityManager $manager,
        UnitOfWork $unitOfWork,
        EntityPersister $entityPersister
    ) {
        $manager->getUnitOfWork()->shouldBeCalled()->willReturn($unitOfWork);
        $unitOfWork->getEntityPersister(null)->shouldBeCalled()->willReturn($entityPersister);
        $entityPersister->load(
            ['rememberPasswordToken.token' => 'remember-password-token'],
            null,
            null,
            [],
            null,
            1,
            null
        )->shouldBeCalled()->willReturn($user);

        $this->userOfRememberPasswordToken(new UserToken('remember-password-token'))->shouldReturn($user);
    }

    function it_persist(EntityManager $manager, User $user)
    {
        $manager->persist($user)->shouldBeCalled();

        $this->persist($user);
    }

    function it_remove(EntityManager $manager, User $user)
    {
        $manager->remove($user)->shouldBeCalled();

        $this->remove($user);
    }

    function it_gets_the_user_table_size(
        EntityManager $manager,
        QueryBuilder $queryBuilder,
        Expr $expr,
        Expr\Func $func,
        AbstractQuery $query
    ) {
        $manager->createQueryBuilder()->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->expr()->shouldBeCalled()->willReturn($expr);
        $queryBuilder->select('u')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->from(null, 'u', null)->shouldBeCalled()->willReturn($queryBuilder);

        $func->__toString()->willReturn('COUNT(user.id)');
        $expr->count('u.id')->shouldBeCalled()->willReturn($func);
        $queryBuilder->select($func)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
        $query->getSingleScalarResult()->shouldBeCalled()->willReturn(2);

        $this->size()->shouldReturn(2);
    }
}
