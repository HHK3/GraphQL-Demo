<?php
namespace App\GraphQL\Query;

use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Auth;
use Rebing\GraphQL\Support\Query;

use \App\User;

/**
 * Query the logged in user.
 *
 * @package App\GraphQL\Query
 */
class MeQuery extends Query
{
    /**
     * The attributes that define this query.
     *
     * @var array
     */
    protected $attributes = [
        'name' => 'MeQuery',
    ];

    /**
     * This query returns a single user.
     *
     * @return Type
     */
    public function type(): Type
    {
        return Type::listOf(GraphQL::type('user'));
    }

    /**
     * Set authorization rules.
     *
     * @param array $args
     *
     * @return boolean
     */
//    public function authorize(array $args): bool
//    {
//        return Auth::check();
//    }

    /**
     * Load the query response.
     *
     * @return User,
     */
//    public function resolve(): User
//    {
////        return Auth::user();
//    }
}
