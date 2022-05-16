<?php

namespace App\Repositories;

use App\Models\Address;
use App\Models\User;
use Illuminate\Support\Collection;

class UserRepository extends BaseRepository
{
    /**
     * Bind model in constructor
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        // Initialize the Base repository
        parent::__construct($user);
    }

    /**
     * Will return all records of Users
     * Can include its relationship by passing $with
     *
     * @param array $with
     * @return Collection
     */
    public function getAllUser(array $with = []): Collection
    {
        $with = ['address'];

        return $this->getAllRecords($with);
    }

    /**
     * Will save user record
     *
     * @param array $attribute
     * @return User
     */
    public function storeUser(array $attribute): User
    {
        $user = $this->store($attribute);

        return $user;
    }

    /**
     * Will save the address relationship of a user
     *
     * @param User $user
     * @param array $attributes
     * @return void
     */
    public function saveUserAddress(User $user, array $attributes)
    {
        $data_address = new Address();
        $data_address->fill($attributes['address']);

        $user->address()->save($data_address);
    }

    /**
     * Will update the address reslationship of a user
     *
     * @param User $user
     * @param array $attributes
     * @return void
     */
    public function UpdateUserAddress(User $user, array $attributes)
    {
        $user->address()->update($attributes['address']);
    }

    /**
     * Will update a user data
     *
     * @param array $attributes
     * @param integer $id
     * @return User|null
     */
    public function updateUser(array $attributes, int $id): ?User
    {
        return $this->update($attributes, $id);
    }

    /**
     * Will get specific User
     *
     * @param integer $id
     * @param array $with
     * @return User|null
     */
    public function getUser(int $id, array $with = []): ?User
    {
        return $this->show($id, $with);
    }

    /**
     * Will delete a user data
     * For the relationships create an observer that will delete them
     *
     * @param integer $id
     * @return boolean
     */
    public function deleteUser(int $id): bool
    {
        return $this->destroy($id);
    }
}
