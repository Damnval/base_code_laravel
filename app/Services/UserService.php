<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Collection;

class UserService
{
    /**
     * Initialize Repository to use
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Will get all User
     *
     * @param array $with
     * @return Collection
     */
    public function getAllUsers(array $with = []): Collection
    {
        return $this->userRepository->getAllUser();
    }

    /**
     * Will get a specific user
     *
     * @param integer $id
     * @param array $with
     * @return User|null
     */
    public function getUser(int $id, array $with = []): ?User
    {
        $with = [
            'address'
        ];

        $user = $this->userRepository->getUser($id, $with);

        return $user;
    }

    /**
     * Update user details
     *
     * @param array $attributes
     * @param integer $id
     * @return User|null
     */
    public function updateUser(array $attributes, int $id): ?User
    {
        $user = $this->userRepository->updateUser($attributes, $id);
        // Address is not an entity. It depends on User model
        $this->userRepository->UpdateUserAddress($user, $attributes);
        // load the newly save relationship
        $user->load('address');

        return $user;
    }

    /**
     * Store a new User
     *
     * @param array $attribute
     * @return User
     */
    public function storeUser(array $attribute): User
    {
        $user = $this->userRepository->storeUser($attribute);
        // Address is not an entity. It depends on User model
        $this->userRepository->saveUserAddress($user, $attribute);
        // load the newly save relationship
        $user->load('address');

        return $user;
    }

    /**
     * Delete a specific user
     *
     * @param integer $id
     * @return boolean
     */
    public function deleteUser(int $id): bool
    {
        return $this->userRepository->deleteUser($id);
    }
}
