<?php

namespace App\GraphQL\Mutation;

use Closure;
use App\User;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Validation\Rule;
use App\Events\User\UserUpdated;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Hash;
use Rebing\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\ResolveInfo;

/**
 * Updates a user
 */
class UpdateUserMutation extends Mutation
{
    /**
     * Indicates whether the user is authenticated
     *
     * @var boolean
     */
    protected $authenticated = false;

    /**
     * The logged in user
     *
     * @var App\User
     */
    protected $user;

    protected $attributes = [
        'name' => 'UpdateUserMutation',
        'description' => 'Updates a user'
    ];

//    public function __construct()
//    {
//        $this->authenticated = auth('api')->check();
//        $this->user = auth('api')->user();
//    }

    /**
    * This query returns a a single user
    *
    * @return Type
    */
    public function type(): Type
    {
        return GraphQL::type('user');
    }

    public function args(): array
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
            'password' => [
                'type' => Type::string(),
            ],
            'locationId' => [
                'type'  => Type::listOf(Type::int()),
            ],
//            'roles' => [
//                'type' => Type::listOf(Type::string()),
//            ]
        ];
    }

    /**
     * Validation rules
     *
     * @return array
     */
    protected function rules(array $args = []): array
    {
        return [
            'id' => ['required', 'exists:users,id'],
            'name' => ['filled'],
            'email' => ['filled', 'email', Rule::unique('users')->ignore($args['id'], 'id')],
            'password' => ['filled'],
            'locationId' => ['exists:locations,id'],
//            'roles' => ['exists:roles,name']
        ];
    }

//    public function authorize(array $args): bool
//    {
//        $args = collect($args);
//
//        if (!$this->authenticated) {
//            return false;
//        }
//
//        return $this->user->can('update', [User::find($args->get('id'))]);
//    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $args = collect($args);

        $user = User::find($args->get('id'));

        $user->update([
            'name' => $args->get('name'),
            'email' => $args->get('email'),
            'password' => Hash::make($args->get('password')),
        ]);

//        $user->locations()->sync($args->get('locationId'));
        $user->locations()->syncWithoutDetaching($args->get('locationId'));


//        // If the user is admin, we allow the locationIds to be updated
//        if (!$this->user->isAdmin()) {
//            $user->locations()->sync($args->get('locationId'));
//        }

//        $roles = collect($args->get('roles'));

        // Sync the given roles except Admin
//        $user->syncRoles($roles->reject(function ($value) {
//            return $value === 'Admin';
//        }));
//
//        event(new UserUpdated($user));

        return $user;
    }
}
