<?php

namespace App\GraphQL\Query;

use Closure;
use App\User;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use App\GraphQL\Traits\PaginationTrait;
use Rebing\GraphQL\Support\PaginationType;

/**
 * Query users
 *
 * @package App\GraphQL\Query
 */
class UsersQuery extends Query
{
//    use PaginationTrait;

    /**
     * Indicates whether the user is authenticated
     *
     * @var boolean
     */
//    protected $authenticated = false;

    /**
     * The logged in user
     *
     * @var App\User
     */
    protected $user;

    /**
     * The base builder instance for this query
     *
     * @var Illuminate\Database\Query\Builder
     */
    protected $users;

    /**
     * The attributes that define this query.
     *
     * @var array
     */
    protected $attributes = [
        'name' => 'user',
        'description' => 'Lists users with pagination'
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
        $this->users = User::query();
    }

    /**
     * This query returns a paginated list of users
     *
     * @return PaginationType
     */
    public function type(): Type
    {
        return Type::listOf(GraphQL::type('user'));
//        return GraphQL::paginate(GraphQL::type('user'));
    }

    /**
     * Define the query arguments
     *
     * @return array
     */
    public function args(): array
    {
//        $args = [
//            'locationId' => [
//                'type' => Type::listOf(Type::int()),
//                'rules' => ['required', 'exists:locations,id'],
//            ],
//        ];
//
//        return array_merge($args, $this->paginationArguments());
        return [
            'id' => ['name' => 'id', 'type' => Type::string()],
            'email' => ['name' => 'email', 'type' => Type::string()]
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
//        return $this->user->can('list', [User::class, collect($args->get('locationId'))]);
//    }

//    /**
//     * Load the query response.
//     *
//     * @return LengthAwarePaginator
//     */
    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
//        $args = collect($args);
//
//        // Define selects and relations.
//        $selects = $fields->getSelect();
//        $relations = $fields->getRelations();
//
//        // Bind select and with
//        $this->users->select($selects);
//        $this->users->with($relations);
//
//        $this->users->whereHas('locations', function ($query) use ($args) {
//            $query->whereIn('id', $args->get('locationId'));
//        });
//
//        return $this->users
//            ->paginate($args['limit'], ['*'], 'page', $args['page']);

//        return $this->handlePagination($this->users, $args->get('page', 1), $args->get('limit', 15));

        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        $user = User::select($select)->with($with);

        return $user->get();
    }
}
