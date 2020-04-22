<?php

namespace App\GraphQL\Query;

use Closure;
use App\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use App\GraphQL\Traits\PaginationTrait;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;


/**
 * Query a single user
 *
 * @package App\GraphQL\Query
 */
class UserQuery extends Query
{
    use PaginationTrait;

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
     * The requested user
     *
     * @var Illuminate\Database\Query\Builder
     */
    protected $requestedUser;

    /**
     * The attributes that define this query.
     *
     * @var array
     */
    protected $attributes = [
        'name' => 'UserQuery',
        'description' => 'List a single user'
    ];

    /**
     * Class constructor
     *
     * @return void
     */
    public function __construct()
    {
//        $this->authenticated = auth('api')->check();
//        $this->user = auth('api')->user();
        $this->requestedUser = User::query();
    }

    /**
     * This query returns a paginated list of users
     *
     * @return ObjectType
     */
    public function type(): Type
    {
        return Type::listOf(GraphQL::type('user'));
    }

    /**
     * Define the query arguments
     *
     * @return array
     */
    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::int(),
                'rules' => ['exists:users,id'],
            ],
        ];
    }

//    /**
//     * Set authorization rules.
//     *
//     * @param array $args
//     *
//     * @return boolean
//     */
//    public function authorize(array $args): bool
//    {
//        $args = collect($args);
//
//        if (!$this->authenticated) {
//            return false;
//        }
//
//        $this->requestedUser = User::find($args->get('id'));
//
//        return $this->user->can('read', $this->requestedUser);
//    }

    /**
     * Load the query response.
     *
     * @return LengthAwarePaginator
     */
    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
//        // Define selects and relations.
//        $selects = $fields->getSelect();
//        $relations = $fields->getRelations();
//
//        // Bind select and with
//        $this->requestedUser->select($selects);
//        $this->requestedUser->with($relations);
//
//        return $this->requestedUser;
        /** @var SelectFields $fields */
        $args = collect($args);

        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        $user = User::select($select)->with($with)->where('id', $args->get('id'));

        return $user->get();
    }
}
