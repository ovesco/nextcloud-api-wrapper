<?php

namespace NextcloudApiWrapper;

abstract class AbstractClient
{
    /**
     * @var Connection
     */
    protected $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }
}