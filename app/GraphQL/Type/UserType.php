<?php

namespace App\GraphQL\Type;

use App\User;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

/**
 * GraphQL type for the User model.
 *
 * @package App\GraphQL\Type
 */
class UserType extends GraphQLType
{
    /**
     * The attributes that define this type.
     *
     * @var array
     */
    protected $attributes = [
        'name' => 'user',
        'model' => User::class,
    ];

    /**
     * The fields that can be selected.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::int(),
            ],

            'name' => [
                'type' => Type::string(),
            ],

            'email' => [
                'type' => Type::string(),
            ],

//            'is_admin' => [
//                'type' => Type::boolean(),
//                'selectable' => false,
//                'resolve' => function ($root): bool {
//                    return $root->isAdmin();
//                },
//            ],
//
            'locations' => [
                'type' => Type::listOf(GraphQL::type('location')),
            ],
//
//            'roles' => [
//                'type' => Type::listOf(GraphQL::type('RoleType')),
//                'description' => 'The roles that this user has.',
//            ],
//
//            'permissions' => [
//                'type' => Type::listOf(Type::string()),
//                'description' => 'The permissions of this user.',
//                'selectable' => false,
//                'resolve' => function ($root): array {
//                    return  $root->getAllPermissions()->pluck('name')->toArray();
//                },
//            ],
//
//            'created_at' => [
//                'type' => Type::string(),
//                'resolve' => function ($root): String {
//                    return (string)$root->created_at;
//                },
//            ],
//
//            'updated_at' => [
//                'type' => Type::string(),
//                'resolve' => function ($root): string {
//                    return (string)$root->updated_at;
//                },
//            ],
        ];
    }
}
