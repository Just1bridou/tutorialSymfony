<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use DateTime;

class CreateUserCommand extends Command
{
    /**
     * Nom de la commande
     */
    protected static $defaultName = 'app:create-user';

    private $entityManager;
    private $userRepository;
    private $userPasswordEncoderInterface;

    /**
     * CreateUserCommand constructor.
     *
     * @param EntityManagerInterface        $entityManager
     * @param UserRepository                $userRepository
     * @param UserPasswordEncoderInterface  $userPasswordEncoderInterface
     */
    public function __construct(EntityManagerInterface $entityManager, UserRepository $userRepository, UserPasswordEncoderInterface $userPasswordEncoderInterface)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->userPasswordEncoderInterface = $userPasswordEncoderInterface;

        parent::__construct();
    }


    /**
     * Configuration de la commande
     * @return void
     */
    protected function configure(): void
    {
        $this
            ->setDescription('Créé un nouvel utilisateur.')
            ->setHelp('Cetter commande permet de créer un nouveau compte utilisateur.')
        ;

    }

    /**
     * Exécution de la commande
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return int|null|void
     */

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // username
        $username = $io->ask('Identifiant de connexion', 'admin', function ($username) {
            $existingUser = $this->userRepository->findBy(['username' => $username]);

            if (!empty($existingUser)) {
                throw new Exception('Cet identifiant est déjà utilisé');

            } else if (is_numeric($username) || is_array($username) || strlen($username) > 180) {
                throw new Exception('La valeur n\'est pas valide');
            }

            return $username;
        });
        $io->write($username, true);

        // email
        $email = $io->ask('Adresse mail', 'admin@domain.com', function ($email) {
            $existingUser = $this->userRepository->findBy(['email' => $email]);

            if (!empty($existingUser)) {
                throw new Exception('Cette adresse mail est déjà utilisée');

            } else if (is_numeric($email) || is_array($email) || strlen($email) > 180) {
                throw new Exception('La valeur n\'est pas valide');
            }

            return $email;
        });
        $io->write($email, true);

        // password
        $password = $io->ask('Mot de passe', null, function ($password) {
            if (empty($password) || is_array($password) || is_numeric($password) || strlen($password) > 255) {
                throw new Exception('La valeur n\'est pas valide');
            }

            return $password;
        });
        $io->write($password, true);

        // roles
        $roles = $io->ask('Rôles', '["ROLE_SUPER_ADMIN"]', function ($rolesInput) {
            $roles = json_decode($rolesInput, true);
            if (!is_array($roles)) {
                throw new Exception('La valeur n\'est pas valide');
            }

            return $roles;
        });
        $io->write($roles, true);

        // city
        $city = $io->ask('Ville', 'Paris', function ($city) {
            if (empty($city) || is_array($city) || is_numeric($city) || strlen($city) > 255) {
                throw new Exception('La valeur n\'est pas valide');
            }

            return $city;
        });
        $io->write($city, true);

        // zip
        $zip = $io->ask('Code postal', '75000', function ($zip) {
            if (empty($zip) || is_array($zip) || strlen($zip) > 15) {
                throw new Exception('La valeur n\'est pas valide');
            }

            return $zip;
        });
        $io->write($zip, true);

        // address
        $address = $io->ask('Adresse', '1 rue Capitale', function ($address) {
            if (empty($address) || is_array($address) || is_numeric($address) || strlen($address) > 255) {
                throw new Exception('La valeur n\'est pas valide');
            }

            return $address;
        });
        $io->write($address, true);

        // birthday
        $birthday = $io->ask('Date de naissance', '1970-01-01', function ($birthday) {
            $d = DateTime::createFromFormat('Y-m-d', $birthday);
            if (!($d && $d->format('Y-m-d') === $birthday)) {
                throw new Exception('La valeur n\'est pas valide');
            }

            return $birthday;
        });
        $io->write($birthday, true);

        // is banned
        $isBanned = $io->choice('Utilisateur banni', ['Oui', 'Non'], 'Non');
        $io->write($isBanned, true);

        // is verified
        $isVerified = $io->choice('Utilisateur vérifié', ['Oui', 'Non'], 'Oui');
        $io->write($isVerified, true);
        

        // Création de l'utilisateur
        $user = new User();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword(
            $this->userPasswordEncoderInterface->encodePassword(
                $user,
                $password
            )
        );
        $user->setRoles($roles);
        $user->setCity($city);
        $user->setZip($zip);
        $user->setAddress($address);
        $user->setBirthday(DateTime::createFromFormat('Y-m-d', $birthday));
        $user->setIsBanned($isBanned);
        $user->setIsVerified($isVerified);

        try {
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $io->success('L\'utilisateur a été créé ;)');

        } catch (Exception $exception) {
            $io->error('Impossible de créer l\'utilisateur.');
        }

        return Command::SUCCESS;

    }
}