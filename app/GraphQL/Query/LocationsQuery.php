<?php

namespace App\GraphQL\Query;

use Closure;
use App\Location;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Query;
use App\GraphQL\Traits\PaginationTrait;
use Rebing\GraphQL\Support\PaginationType;

/**
 * Query locations
 *
 * @package App\GraphQL\Query
 */
class LocationsQuery extends Query
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
     * The base builder instance for this query
     *
     * @var Illuminate\Database\Query\Builder
     */
    protected $locations;

    /**
     * The attributes that define this query.
     *
     * @var array
     */
    protected $attributes = [
        'name' => 'LocationsQuery',
        'description' => 'Lists locations with pagination'
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
        $this->locations = Location::query();
    }

    /**
     * This query returns a paginated list of tasklist
     *
     * @return Type
     */
    public function type(): Type
    {
        return Type::listOf(GraphQL::type('location'));
    }

    /**
     * Define the query arguments
     *
     * @return array
     */
    public function args(): array
    {
//        $args = [
//            'id' => [
//                'type' => Type::listOf(Type::int()),
////                'rules' => ['exists:locations,id'],
//            ],
////            'search' => [
////                'name' => 'search',
////                'type' => Type::string(),
////            ],
//        ];

        return [
            'id' => ['name' => 'id', 'type' => Type::string()],
        ];

//        return array_merge($args, $this->paginationArguments());
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
//        // If specific ids are requested, check whether the user has permission to view those individually
//        if ($args->has('id')) {
//            // If ids are requested, find those locations
//            $this->locations->whereIn('id', $args->get('id'));
//
//            if ($this->locations->count()) {
//                return $this->locations->get()->reduce(function ($prev, $location) {
//                    // If the previous value in the loop or the permission is NOT true, return false
//                    if ($prev === false || $this->user->can('read', $location) === false) {
//                        return false;
//                    }
//
//                    // In any other case, return true
//                    return true;
//                });
//            }
//        }
//
//        // Check if the user has the default permission for this query
//        return $this->user->can('list', Location::class);
//    }

    /**
     * Load the query response.
     *
     * @return LengthAwarePaginator
     */
    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
//        $args = collect($args);
//
//        // $location = Location::find(2);
//
//        // Define selects and relations.
//        $selects = $fields->getSelect();
//        $relations = $fields->getRelations();
//
//        // Bind select and with
//        $this->locations->select($selects);
//        $this->locations->with($relations);
//
//        // Bind createdBy
//        $this->locations->addSelect('created_by');
//
//        // If the user is NOT admin, we only allow to list the user's locations
//        if (!$this->user->isAdmin()) {
//            $this->locations->whereIn('id', $this->user->locations->pluck('id'));
//        }
//
//        if ($args->has('search')) {
//            $this->locations->where('name', 'LIKE', '%' . $args->get('search') . '%');
//        }
//
//        return $this->handlePagination($this->locations, $args->get('page', 1), $args->get('limit', 15));

        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        $location = Location::select($select)->with($with);

        return $location->get();
    }
}
