<?php

namespace App\GraphQL\Mutation;

use Closure;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;
use App\Location;

/**
 * Updates a location
 */
class UpdateLocationMutation extends Mutation
{
//    /**
//     * Indicates whether the user is authenticated
//     *
//     * @var boolean
//     */
//    protected $authenticated = false;

    /**
     * The logged in user
     */
//    protected $user;

    protected $attributes = [
        'name' => 'UpdateLocationMutation',
        'description' => 'Updates a location'
    ];

    public function __construct()
    {
        $this->authenticated = auth('api')->check();
        $this->user = auth('api')->user();
    }

    public function type(): Type
    {
        return GraphQL::type('location');
    }

    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::int(),
                'rules' => ['required', 'exists:locations,id'],
            ],
            'name' => [
                'type' => Type::string(),
                'rules' => ['filled'],
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
//
//    public function authorize(array $args)
//    {
//        $args = collect($args);
//
//        if (!$this->authenticated) {
//            return false;
//        }
//
//        return $this->user->can('update', Location::find($args->get('id')));
//    }

    public function resolve($root, $args, Closure $getSelectFields, ResolveInfo $info)
    {
        $args = collect($args);

        $location = Location::find($args->get('id'));
        $location->update($args->only('name', 'address', 'city', 'zip', 'phone')->toArray());

//        if ($args->has('modules')) {
//            $location->modules()->sync($args->get('modules'));
//        }

        return $location;
    }
}
