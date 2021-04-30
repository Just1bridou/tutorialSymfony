<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class UserVoter extends Voter
{
    const TUTO_DASHBOARD = 'tuto_dashboard';
    const TUTO_EDIT = 'tuto_edit';
    const TUTO_CREATE = 'tuto_create';
    const TUTO_PLAY = 'tuto_play';

    protected function supports(string $attribute, $subject): bool
    {
        if (!in_array($attribute, [self::TUTO_DASHBOARD, self::TUTO_EDIT, self::TUTO_CREATE, self::TUTO_PLAY])) {
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
            case self::TUTO_EDIT:
                return $this->canEdit($loggedUser, $author);
            case self::TUTO_CREATE:
                return $this->canCreate();
            case self::TUTO_PLAY:
                return $this->canPlay();
        }

        throw new \LogicException('This code should not be reached!');
    }

    /**
     * Check if the logged user can see the tutorial's dashboard
     * 
     * @param User  $loggedUser
     * @param User  $author
     * 
     * @return bool
     */
    private function canView(User $loggedUser, User $author): bool
    {
        return $this->isAuthor($loggedUser, $author);
    }

    /**
     * Check if the logged user can edti a tutorial
     * 
     * @param User  $loggedUser
     * @param User  $author
     * 
     * @return bool
     */
    private function canEdit(User $loggedUser, User $author): bool
    {
        return $this->isAuthor($loggedUser, $author);
    }

    /**
     * Check if can create
     */
    private function canCreate(): bool
    {
        return true;
    }

    /**
     * Check if can play a quiz
     */
    private function canPlay(): bool
    {
        return true;
    }

    /**
     * Check if the logged user is the tutorial's author
     * 
     * @param User  $loggedUser
     * @param User  $author
     * 
     * @return bool
     */
    private function isAuthor(User $loggedUser, User $author): bool
    {
        return $loggedUser === $author;
    }
}