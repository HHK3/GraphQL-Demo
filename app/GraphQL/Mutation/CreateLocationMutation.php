<?php

namespace App\GraphQL\Mutation;

use App\Location;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

/**
 * Creates a new location
 */
class CreateLocationMutation extends Mutation
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
        'name' => 'CreateLocationMutation',
        'description' => 'Creates a new location'
    ];

//    /**
//     * Class constructor
//     *
//     * @return void
//     */
//    public function __construct()
//    {
//        $this->authenticated = auth('api')->check();
//        $this->user = auth('api')->user();
//    }


    public function type(): Type
    {
        return GraphQL::type('location');
    }

    public function args(): array
    {
        return [
            'name' => [
                'type' => Type::string(),
                'rules' => ['required'],
            ],
//            'modules' => [
//                'type' => Type::listOf(Type::int()),
//                'rules' => ['exists:modules,id']
//            ],
            'address' => [
                'type' => Type::string(),
            ],
            'city' => [
                'type' => Type::string(),
            ],
            'zip' => [
                'type' => Type::string(),
            ],
            'phone' => [
                'type' => Type::string(),
            ],
        ];
    }

//    public function authorize(array $args): bool
//    {
//        if (!$this->authenticated) {
//            return false;
//        }
//
//        return $this->user->can('create', Location::class);
//    }


    public function resolve($root, $args)
    {
        $args = collect($args);

        $location = Location::create([
            'name' => $args->get('name'),
            'address' => $args->get('address'),
            'city' => $args->get('city'),
            'zip' => $args->get('zip'),
            'phone' => $args->get('phone'),
//            'created_by' => $this->user->id,
        ]);

//        $location->modules()->sync($args->get('modules'));

        return $location;
    }
}
