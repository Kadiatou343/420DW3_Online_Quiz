<?php
declare(strict_types=1);

namespace ProjectUtilities;

use Business\Domain\User;

/**
 * Classe représentant une liste (array) d'utilisateur
 */
class ListUser
{
    /**
     * @var User[]
     * L'array qui contient des objets de User
     */
    private array $listUsers = [];

    /**
     * @return User[]
     * La méthode pour obtenir le tableau de User
     */
    public function getListUsers(): array
    {
        return $this->listUsers;
    }

    /**
     * @param User $user
     * @return void
     * La méthode pour ajouter un élément à l'array
     */
    public function addUser(User $user): void
    {
        $this->listUsers[] = $user;
    }
}