<?php


namespace App\Security;

use App\Entity\Participant as AppUser;
use Symfony\Component\Security\Core\Exception\AccountExpiredException;
use Symfony\Component\Security\Core\Exception\DisabledException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
    {
        if (!$user instanceof AppUser) {
            return;
        }

        // Si l'utilisateur est désactivé
        if ($user->isActif()==false) {
            throw new DisabledException('Votre compte est désactivé');
        }
    }

    public function checkPostAuth(UserInterface $user)
    {
        if (!$user instanceof AppUser) {
            return;
        }

        // Si l'utilisateur est désactivé
        if ($user->isActif()==false) {
            throw new DisabledException('Votre compte est désactivé');
        }
    }
}