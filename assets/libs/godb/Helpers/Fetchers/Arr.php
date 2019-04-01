<?php
/**
 * @package go\Db
 */

namespace go\DB\Helpers\Fetchers;

use go\DB\Result;

/**
 * Fetcher for an assoc array
 *
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */
class Arr extends Base
{
    /**
     * Constructor
     *
     * @param \go\DB\Result|array|int $data
     * @param int $id [optional]
     * @param int $ar [optional]
     * @throws \InvalidArgumentException
     */
    public function __construct($data, $id = null, $ar = null)
    {
        if (is_array($data)) {
            $this->data = $data;
        } elseif ($data instanceof Result) {
            $this->data = $data->assoc();
        } elseif ($data === null) {
            $this->data = array();
        } else {
            throw new \InvalidArgumentException();
        }
        if ($id !== null) {
            $this->id = $id;
        }
        $this->ar = (int)$ar;
    }

    /**
     * {@inheritdoc}
     */
    public function free()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function assoc($param = null)
    {
        if (!$param) {
            return $this->data;
        }
        $result = array();
        foreach ($this->data as $item) {
            $result[$item[$param]] = $item;
        }
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function numerics($param = null)
    {
        $data = array_map('array_values', $this->data);
        if (!$param) {
            return $data;
        }
        $result = array();
        foreach ($data as $item) {
            $result[$item[$param]] = $item;
        }
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function objects($param = null)
    {
        $data = array();
        foreach ($this->data as $item) {
            $data[] = (object)$item;
        }
        if (!$param) {
            return $data;
        }
        $result = array();
        foreach ($data as $item) {
            $result[$item->$param] = $item;
        }
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function col($param = null)
    {
        $result = array();
        foreach ($this->data as $item) {
            $item = array_values($item);
            $result[] = $item[0];
        }
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function vars($param = null)
    {
        $result = array();
        foreach ($this->data as $item) {
            $item = array_values($item);
            $result[$item[0]] = $item[1];
        }
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function iassoc($param = null)
    {
        return new \ArrayIterator($this->assoc($param));
    }

    /**
     * {@inheritdoc}
     */
    public function inumerics($param = null)
    {
        return new \ArrayIterator($this->numerics($param));
    }

    /**
     * {@inheritdoc}
     */
    public function iobjects($param = null)
    {
        return new \ArrayIterator($this->objects($param));
    }

    /**
     * {@inheritdoc}
     */
    public function ivars($param = null)
    {
        return new \ArrayIterator($this->vars($param));
    }

    /**
     * {@inheritdoc}
     */
    public function icol($param = null)
    {
        return new \ArrayIterator($this->col($param));
    }

    /**
     * {@inheritdoc}
     */
    public function row($param = null)
    {
        return isset($this->data[0]) ? $this->data[0] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function numeric($param = null)
    {
        return isset($this->data[0]) ? array_values($this->data[0]) : null;
    }

    /**
     * {@inheritdoc}
     */
    public function object($param = null)
    {
        return isset($this->data[0]) ? (object)$this->data[0] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function el($param = null)
    {
        if (!isset($this->data[0])) {
            return null;
        }
        $row = array_values($this->data[0]);
        return $row[0];
    }

    /**
     * {@inheritdoc}
     */
    public function bool($param = null)
    {
        if (!isset($this->data[0])) {
            return null;
        }
        $row = array_values($this->data[0]);
        return (bool)$row[0];
    }

    /**
     * {@inheritdoc}
     */
    public function num($param = null)
    {
        return count($this->data);
    }

    /**
     * {@inheritdoc}
     */
    public function id($param = null)
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function ar($param = null)
    {
        return $this->ar;
    }

    /**
     * {@inheritdoc}
     */
    public function cursor($param = null)
    {
        return $this->data;
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->data);
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->data);
    }

    /**
     * @var array
     */
    private $data;

    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $ar = 0;
}
