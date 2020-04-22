<?php

namespace App\GraphQL\Traits;

use GraphQL\Type\Definition\Type;
use Illuminate\Database\Eloquent\Builder;

/**
 * Adds pagination attributes and filters.
 *
 * @package App\GraphQL\Traits
 */
trait PaginationTrait
{
    /**
     * Handle pagination for the model.
     *
     * @param Builder $model
     * @param int $page
     * @param int $limit
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function handlePagination($model, int $page, int $limit)
    {
        return $model->paginate($limit, ['*'], 'page', $page);
    }

    /**
     * Add arguments used for pagination to the scheme.
     *
     * @return array
     */
    public function paginationArguments(): array
    {
        return [
            'page' => [
                'name' => 'page',
                'type' => Type::int(),
            ],

            'limit' => [
                'name' => 'limit',
                'type' => Type::int(),
            ],
        ];
    }
}
