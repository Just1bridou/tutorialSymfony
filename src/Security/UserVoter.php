<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class UserVoter extends Voter
{
    const TUTO_DASHBOARD = 'tuto_dashboard';

    protected function supports(string $attribute, $subject): bool
    {
        if (!in_array($attribute, [self::TUTO_DASHBOARD])) {
            return false;
        }

        if (!$subject instanceof User) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $loggedUser = $token->getUser();

        if (!$loggedUser instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        /** @var User $user */
        $author = $subject;

        switch ($attribute) {
            case self::TUTO_DASHBOARD:
                return $this->canView($loggedUser, $author);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canView(User $loggedUser, User $author): bool
    {
        return $loggedUser === $author;
    }
}