<?php

namespace RBennett\ModelCache\ModelCaching;


/**
 * Class CachedModel
 * @package App\ModelCaching
 */
trait CachedModel
{
    /**
     * @var array
     */
    protected $onChangeClearCacheFor = [];

    /**
     * Get a new query builder instance for the connection.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function newBaseQueryBuilder()
    {
        $connection = $this->getConnection();

        return new CachedBuilder(
            $this->onChangeClearCacheFor, $connection, $connection->getQueryGrammar(), $connection->getPostProcessor()
        );
    }
}