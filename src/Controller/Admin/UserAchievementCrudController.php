<?php

namespace App\Controller\Admin;

use App\Entity\UserAchievement;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserAchievementCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return UserAchievement::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('user'),
            AssociationField::new('achievement'),
        ];
    }
}
