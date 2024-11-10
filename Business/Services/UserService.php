<?php
declare(strict_types=1);

namespace Business\Services;

use Business\Domain\User;
use DataAccess\DAOs\UserDAO;
use Exception;
use ProjectUtilities\ListUser;
use ProjectUtilities\UserRole;

/**
 * Classe représentant le controller de l'utilisateur
 */
class UserService
{
    /**
     * @var UserDAO
     * Le DAO de l'utilisateur
     */
    private UserDAO $userDAO;

    public function __construct()
    {
        $this->userDAO = new UserDAO();
    }

    /**
     * @param string $lastName
     * @param string $firstName
     * @param string $email
     * @param string $passwordHash
     * @param string|UserRole $role
     * @return User
     * La méthode pour créer un nouvel utilisateur (joueur)
     */
    public function registerUserGamer(string          $lastName,
                                      string          $firstName,
                                      string          $email,
                                      string          $passwordHash,
                                      string|UserRole $role = UserRole::GAMER->value): User
    {
        $user = new User($lastName, $firstName, $email, $role, $passwordHash);
        return $this->userDAO->create($user);
    }

    /**
     * @param string $lastName
     * @param string $firstName
     * @param string $email
     * @param string $passwordHash
     * @param string|UserRole $role
     * @return User
     * La méthode pour ajouter un utilisateur (admin)
     */
    public function addUserAdmin(string          $lastName,
                                 string          $firstName,
                                 string          $email,
                                 string          $passwordHash,
                                 string|UserRole $role = UserRole::ADMIN->value): User
    {
        $user = new User($lastName, $firstName, $email, $role, $passwordHash);
        return $this->userDAO->create($user);
    }

    /**
     * @param User $user
     * @return User
     * @throws Exception
     * Mise à jour
     */
    public function updateUser(User $user) : User
    {
        return $this->userDAO->update($user);
    }

    /**
     * @param User $user
     * @return void
     * @throws Exception
     * Suppresion
     */
    public function deleteUser(User $user) : void
    {
        $this->userDAO->delete($user);
    }

    /**
     * @return ListUser
     * Obtenir tous les utilisateurs
     */
    public function getAllUsers() : ListUser
    {
        return $this->userDAO->getAll();
    }


}