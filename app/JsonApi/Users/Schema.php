<?php

namespace App\JsonApi\Users;

use Neomerx\JsonApi\Schema\SchemaProvider;

class Schema extends SchemaProvider
{

    /**
     * @var string
     */
    protected $resourceType = 'users';

    /**
     * @param \App\Models\User $resource
     *      the domain record being serialized.
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getRouteKey();
    }

    /**
     * @param \App\Models\User $user
     *      the domain record being serialized.
     * @return array
     */
    public function getAttributes($user)
    {
        return [
            'name' => $user->name,
            'role' => $user->role,
            'email' => $user->email,
            'password' => $user->password,
            'desabled_at' => $user->desabled_at,
            'email_verified_at' => $user->email_verified_at,
            'remember_token' => $user->remember_token,
            'createdAt' => $user->created_at,
            'updatedAt' => $user->updated_at,
        ];
    }
}
