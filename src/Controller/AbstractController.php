<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as BaseAbstractController;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use Symfony\Contracts\Translation\TranslatableInterface;

abstract class AbstractController extends BaseAbstractController
{
    protected function getUser(): User
    {
        $user = parent::getUser();

        if ($user === null) {
            throw $this->createAccessDeniedException('Access Denied.');
        }

        if (!($user instanceof User)) {
            throw $this->createAccessDeniedException('Expected User, got unexpected type');
        }

        return $user;
    }

    public static function getSubscribedServices(): array
    {
        return array_merge_recursive(parent::getSubscribedServices(), [
            'translator' => TranslatableInterface::class,
            'logger' => LoggerInterface::class,
        ]);
    }
}
