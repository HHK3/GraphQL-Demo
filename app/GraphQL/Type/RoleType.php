<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class RoleType extends GraphQLType
{
    protected $attributes = [
        'name' => 'RoleType'
    ];

    public function __construct()
    {
        $this->attributes['model'] = config('permission.models.role');
    }

    public function fields(): array
    {
        return [
            'name' => [
                'type' => Type::string(),
            ],
        ];
    }
}
