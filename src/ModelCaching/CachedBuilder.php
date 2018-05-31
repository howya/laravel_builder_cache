<?php

namespace RBennett\ModelCache\ModelCaching;


use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\Grammars\Grammar;
use Illuminate\Database\Query\Processors\Processor;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * Class CachedBuilder
 * @package RBennett\ModelCache
 */
class CachedBuilder extends Builder
{
    /**
     * @var array
     */
    private $onChangeClearCacheFor;

    /**
     * CachedBuilder constructor.
     * @param array $onChangeClearCacheFor
     * @param ConnectionInterface $connection
     * @param Grammar $grammar
     * @param Processor $processor
     */
    public function __construct(
        array $onChangeClearCacheFor,
        ConnectionInterface $connection,
        Grammar $grammar = null,
        Processor $processor = null
    ) {
        parent::__construct($connection, $grammar, $processor);
        $this->onChangeClearCacheFor = $onChangeClearCacheFor;
    }

    /**
     * @return array
     */
    protected function runSelect()
    {
        $sql = $this->toSql();
        $binding = $this->getBindings();
        $sqlHash = hash('sha1', $this->toSql() . json_encode($binding));
        $tables = $this->getQueryTables();


        if ($cashed = Cache::tags($tables)->get($sqlHash)) {
            //Log::info('Cache Hit for key: ' . $sqlHash .', with tags: ' . print_r($tables, true));
            return json_decode($cashed);
        } else {
            //Log::info('Cache Miss for key: ' . $sqlHash .', with tags: ' . print_r($tables, true));
            //Log::info('Cache Miss for SQL: ' . $sql . ' : ' . json_encode($binding));
            Cache::tags($tables)
                ->put(
                    $sqlHash,
                    json_encode(
                        $result = $this->connection->select(
                            $sql, $this->getBindings(), !$this->useWritePdo
                        )
                    ),
                    10);
            return $result;
        }
    }

    protected function getQueryTables()
    {
        if (is_array($this->joins)) {
            $joins = array_map(
                function ($item) {
                    return $item->table;
                },
                $this->joins
            );
        }

        $joins[] = $this->from;

        return $joins;
    }

    /**
     * @param mixed|null $id
     * @return int
     */
    public function delete($id = null)
    {
        $this->onChangeClearCacheFor[] = $this->from;

//        Log::info(__FUNCTION__ . ' - Clearing tags ' . print_r($this->onChangeClearCacheFor, true));

        Cache::tags($this->onChangeClearCacheFor)->flush();

        return parent::delete($id);
    }

    /**
     * @param array $values
     * @return bool
     */
    public function insert(array $values)
    {
        $this->onChangeClearCacheFor[] = $this->from;

//        Log::info(__FUNCTION__ . ' - Clearing tags ' . print_r($this->onChangeClearCacheFor, true));

        Cache::tags($this->onChangeClearCacheFor)->flush();

        return parent::insert($values);
    }

    /**
     * @param array $values
     * @param null|string $sequence
     * @return int
     */
    public function insertGetId(array $values, $sequence = null)
    {
        $this->onChangeClearCacheFor[] = $this->from;

//        Log::info(__FUNCTION__ . ' - Clearing tags ' . print_r($this->onChangeClearCacheFor, true));

        Cache::tags($this->onChangeClearCacheFor)->flush();

        return parent::insertGetId($values, $sequence);
    }

    /**
     * @param array $values
     * @return int
     */
    public function update(array $values)
    {
        $this->onChangeClearCacheFor[] = $this->from;

//        Log::info(__FUNCTION__ . ' - Clearing tags ' . print_r($this->onChangeClearCacheFor, true));

        Cache::tags($this->onChangeClearCacheFor)->flush();

        return parent::update($values);
    }

    /**
     * @param array $attributes
     * @param array $values
     * @return bool
     */
    public function updateOrInsert(array $attributes, array $values = [])
    {
        $this->onChangeClearCacheFor[] = $this->from;

//        Log::info(__FUNCTION__ . ' - Clearing tags ' . print_r($this->onChangeClearCacheFor, true));

        Cache::tags($this->onChangeClearCacheFor)->flush();

        return parent::updateOrInsert($attributes, $values);
    }

}