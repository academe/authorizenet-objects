<?php

namespace Academe\AuthorizeNet;

/**
 * 
 */

use Academe\AuthorizeNet\AbstractModel;
use ReflectionClass;

abstract class AbstractCollection extends AbstractModel implements \JsonSerializable, \Countable, \IteratorAggregate
{
     protected $items;

    /**
     * @param mixed $item
     * @return bool
     */
    abstract protected function hasExpectedStrictType($item);

    /**
     * @param array $item
     */
    public function __construct(array $item = [])
    {
        parent::__construct();

        foreach ($item as $value) {
            $this->push($value);
        }
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * @param mixed $item
     * @return void
     */
    public function push($item)
    {
        $this->assertStrictType($item);

        $this->items[] = $item;
    }

    public function jsonSerialize()
    {
        $data = [];

        // Maybe filter for where hasAny() is true?
        foreach($this as $item) {
            $data[] = $item;
        }

        return $data;
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return $this->count() == 0;
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->items);
    }

    /**
     * @param mixed $item
     * @throws \InvalidArgumentException
     * @return void
     */
    protected function assertStrictType($item)
    {
        if (!$this->hasExpectedStrictType($item)) {
            throw new \InvalidArgumentException('Item is not currect type or is empty.');
        }
    }
}
