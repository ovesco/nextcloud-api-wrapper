<?php

namespace NextcloudApiWrapper;

use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\OptionsResolver\OptionsResolver;

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

    /**
     * @param array $params
     * @param \Closure $function
     * @return array
     */
    public function resolve(array $params, $function) {

        $resolver   = new OptionsResolver();
        $function($resolver);
        return $resolver->resolve($params);
    }

    /**
     * Checks if given key is in array, throws an exception otherwise
     * @param $key
     * @param array $options
     */
    public function inArray($key, array $options) {

        if(!in_array($key, $options))
            throw new InvalidOptionsException("The key $key was not one of the following: " . implode(', ', $options));
    }
}