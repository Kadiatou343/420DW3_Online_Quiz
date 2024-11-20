<?php
declare(strict_types=1);

namespace Business\Services;

use Business\Domain\User;
use DataAccess\DAOs\UserDAO;
use Exception;
use InvalidArgumentException;
use ProjectUtilities\ListUser;
use ProjectUtilities\UserRole;

/**
 * Classe représentant le controller de l'utilisateur
 */
class UserService
{
    /**
     * @var ?UserDAO
     * Le DAO de l'utilisateur
     */
    private ?UserDAO $userDAO;

    /**
     * Le constructeur initialise le DAO
     */
    public function __construct()
    {
        $this->userDAO = new UserDAO();
    }

    /**
     * @param User $user
     * @return User
     * La méthode pour créer un nouvel utilisateur (joueur)
     */
    public function registerUserGamer(User $user): User
    {
        return $this->userDAO->create($user);
    }

    /**
     * @param string $email
     * @param string $password
     * @return bool|User
     * Verifier les credentials d'un utilisateur lors de la connexion
     */
    public function logInUser(string $email, string $password) : bool|User
    {
        $user = $this->userDAO->getByEmail($email);

        if ($user === null) {
            throw new InvalidArgumentException("User not found !");
        }

        if (password_verify($password, $user->getPasswordHash())){
            return $user;
        }
        return false;
    }

    /**
     * @param User $user
     * @return bool
     * La methode pour verifier le role d'un utilisateur.
     * Elle retourne true si l'utilisateur a le rôle d'admin et false pour rôle de gamer
     */
    public function VerifyUserRoleAfterLogIn(User $user) : bool
    {
        if ($user->getRole() == UserRole::GAMER->value){
            return false;
        }
        return true;
    }

    /**
     * @param User $user
     * @return User
     * La méthode pour ajouter un utilisateur (admin)
     */
    public function addUserAdmin(User $user): User
    {
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

    /**
     * @param int $id
     * @return User
     * Obtenir un utilisateur par son identifiant
     */
    public function getUserById(int $id) : User
    {
        $user = $this->userDAO->getById($id);

        if ($user === null) {
            throw new InvalidArgumentException("User with Id{id} not found !");
        }

        return $user;
    }

    /**
     * @param string $criteria
     * @return ListUser|null
     * Faire une recherche d'utilisateurs à partir d'une chaine de recherche
     */
    public function searchUsersByString(string $criteria) : ?ListUser
    {
        return $this->userDAO->searchByString($criteria);
    }

    /**
     * @param string $role
     * @return ListUser
     * Filtrer les utilisateurs par leur role.
     * Par defaut le role choisi est admin
     */
    public function filterUsersByRole(string $role = UserRole::ADMIN->value) : ListUser
    {
        return $this->userDAO->filterByRole($role);
    }

    public function __destruct()
    {
        $this->userDAO = null;
    }


}