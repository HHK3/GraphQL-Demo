<?php

namespace App\GraphQL\Mutation;

use App\User;
use Rebing\GraphQL\Support\Facades\GraphQL;
use App\Events\User\UserDeleted;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Auth;
use Rebing\GraphQL\Support\Mutation;

/**
 * Deletes a user
 */
class DeleteUserMutation extends Mutation
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

    /**
     * The user to be deleted
     *
     * @var App\User
     */
    protected $deletedUser;

    /**
     * Mutation attributes
     *
     * @var array
     */
    protected $attributes = [
        'name' => 'DeleteUserMutation',
        'description' => 'Deletes a user'
    ];

//    /**
//    * Class constructor
//    *
//    * @return void
//    */
//    public function __construct()
//    {
//        $this->authenticated = auth('api')->check();
//        $this->user = auth('api')->user();
//    }

    public function type(): Type
    {
        return GraphQL::type('user');
    }

//    public function authorize(array $args)
//    {
//        $args = collect($args);
//
//        if (!$this->authenticated) {
//            return false;
//        }
//
//        $this->deletedUser = User::find($args->get('id'));
//
//        return $this->user->can('delete', [$this->deletedUser, $args->get('locationId')]);
//    }

    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::int(),
                'rules' => ['required', 'exists:users,id']
            ],
            'locationId' => [
                'type' => Type::int(),
                'rules' => ['required', 'exists:locations,id']
            ],
        ];
    }

    public function resolve($root, $args)
    {
//        $args = collect($args);
//        $user = $this->deletedUser; // Copy variable for event firing
//
//        // Delete the relationship of a user with a location
//        $this->deletedUser->locations()->detach($args->get('locationId'));
//
//        // dd($this->deletedUser->id);
//
//        // If the user hasn't got any locations left, also delete the user
//        if ($this->deletedUser->locations->count() === 0) {
//            $this->deletedUser->delete();
//        }
//
//        event(new UserDeleted($this->deletedUser));
//        return $args->get('id');

        if ($user = User::find($args['id'])) {

            $user->locations()->detach($args['locationId']);
            $user->delete();

            return $args['id'] . ' has been deleted';
        }

        return null;

    }
}
