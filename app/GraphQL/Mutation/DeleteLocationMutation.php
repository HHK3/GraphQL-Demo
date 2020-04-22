<?php

namespace App\GraphQL\Mutation;

use App\Location;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Illuminate\Support\Facades\Auth;

/**
 * Deletes a location
 */
class DeleteLocationMutation extends Mutation
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
     * Mutation attributes
     *
     * @var array
     */
    protected $attributes = [
        'name' => 'DeleteLocationMutation',
        'description' => 'Deletes a location'
    ];

//    public function __construct()
//    {
//        $this->authenticated = auth('api')->check();
//        $this->user = auth('api')->user();
//    }

    public function type(): Type
    {
        return GraphQL::type('location');
    }

//    public function authorize(array $args)
//    {
//        $args = collect($args);
//
//        if (!$this->authenticated) {
//            return false;
//        }
//
//        return $this->user->can('delete', Location::find($args->get('id')));
//    }

    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::int(),
                'rules' => ['required', 'exists:locations,id']
            ],
        ];
    }

    public function resolve($root, $args)
    {
        if ($location = Location::find($args['id'])->delete()) {
            return $args['id'] . ' has been deleted';
        }

        return null;
    }
}
