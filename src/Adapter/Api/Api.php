<?php

namespace Fluxlabs\FluxIliasRestApi\Adapter\Api;

use Fluxlabs\FluxIliasRestApi\Adapter\Api\User\UserDiffDto;
use Fluxlabs\FluxIliasRestApi\Adapter\Api\User\UserDto;
use Fluxlabs\FluxIliasRestApi\Adapter\Api\User\UserIdDto;
use Fluxlabs\FluxIliasRestApi\Channel\User\Port\UserService;

class Api
{

    private ?UserService $user = null;


    public static function new() : /*static*/ self
    {
        $api = new static();

        return $api;
    }


    public function createUser(UserDiffDto $diff) : UserIdDto
    {
        return $this->getUser()
            ->createUser(
                $diff
            );
    }


    public function deleteUserById(int $id) : ?UserIdDto
    {
        return $this->getUser()
            ->deleteUserById(
                $id
            );
    }


    public function deleteUserByImportId(string $import_id) : ?UserIdDto
    {
        return $this->getUser()
            ->deleteUserByImportId(
                $import_id
            );
    }


    public function getAvatarPathById(int $id) : ?string
    {
        return $this->getUser()
            ->getAvatarPathById(
                $id
            );
    }


    public function getAvatarPathByImportId(string $import_id) : ?string
    {
        return $this->getUser()
            ->getAvatarPathByImportId(
                $import_id
            );
    }


    public function getUserById(int $id) : ?UserDto
    {
        return $this->getUser()
            ->getUserById(
                $id
            );
    }


    public function getUserByImportId(string $import_id) : ?UserDto
    {
        return $this->getUser()
            ->getUserByImportId(
                $import_id
            );
    }


    public function getUsers(bool $access_limited_object_ids = false, bool $multi_fields = false, bool $preferences = false, bool $user_defined_fields = false) : array
    {
        return $this->getUser()
            ->getUsers(
                $access_limited_object_ids,
                $multi_fields,
                $preferences,
                $user_defined_fields
            );
    }


    public function updateAvatarById(int $id, ?string $file) : ?UserIdDto
    {
        return $this->getUser()
            ->updateAvatarById(
                $id,
                $file
            );
    }


    public function updateAvatarByImportId(string $import_id, ?string $file) : ?UserIdDto
    {
        return $this->getUser()
            ->updateAvatarByImportId(
                $import_id,
                $file
            );
    }


    public function updateUserById(int $id, UserDiffDto $diff) : ?UserIdDto
    {
        return $this->getUser()
            ->updateUserById(
                $id,
                $diff
            );
    }


    public function updateUserByImportId(string $import_id, UserDiffDto $diff) : ?UserIdDto
    {
        return $this->getUser()
            ->updateUserByImportId(
                $import_id,
                $diff
            );
    }


    private function getUser() : UserService
    {
        global $DIC;

        $this->user ??= UserService::new(
            $DIC->database(),
            $DIC->rbac()
        );

        return $this->user;
    }
}
