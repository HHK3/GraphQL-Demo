<?php

namespace App\GraphQL\Type;

use App\Location;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class LocationType extends GraphQLType
{
    /**
     * The attributes that define this type.
     *
     * @var array
     */
    protected $attributes = [
        'name' => 'LocationType',
        'model' => Location::class,
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
//
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

//            'modules' => [
//                'type' => Type::listOf(GraphQL::type('ModuleType'))
//            ],

//            // Todo: perhaps only show this value for admins?
//            'created_by' => [
//                'type' => GraphQL::type('UserType'),
//                'selectable' => false,
//                'description' => 'The user that created this location.',
//                'resolve' => function ($root) {
//                    return $root->createdBy;
//                },
//            ],
//
//            'created_at' => [
//                'type' => Type::string(),
//                'resolve' => function ($root) {
//                    return (string) $root->created_at;
//                },
//            ],

//            'updated_at' => [
//                'type' => Type::string(),
//                'resolve' => function ($root) {
//                    return (string)$root->updated_at;
//                },
//            ],
        ];
    }
}
