<?php

namespace PG\LeanMapper;

use Joseki\LeanMapper\Query;

abstract class Repository extends \Joseki\LeanMapper\Repository
{
    public function findFormattedPairsBy($key, $values, $format = null, Query $query = null)
    {
        if (!is_array($values)) {
            $values = [$values];
        }

        $class = $this->mapper->getEntityClass($this->getTable());
        $key = $this->mapper->getColumn($class, $key);
        $columns = [];
        foreach ($values as $value) {
            $columns[] = $this->mapper->getColumn($class, $value);
        }

        $fields = implode(", ", array_unique($columns + array($key)));

        if (!$query) {
            $query = $this->createQuery();
        }
        $result = $this->apply($query);

        $result->select(false)->select($fields)->fetchAll();

        $pairs = [];

        foreach ($result as $b) {
            $values = [];

            foreach ($columns as $col) {
                $values[] = $b->$col;
            }

            if ($format) {
                $value = vsprintf($format, $values);
            } else {
                $value = implode(" ", $values);
            }

            $pairs[$b->$key] = $value;
        }

        return $pairs;
    }
}