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
        }

        throw new \LogicException('This code should not be reached!');
    }

    /**
     * Détermine si l'utilisateur authentifié peut visualiser le tableau de bord des tutoriels
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
     * Détermine si l'utilisateur authentifié peut modifier un tutoriel
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
     * Détermine si l'utilisateur authentifié est l'auteur du tutoriel
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