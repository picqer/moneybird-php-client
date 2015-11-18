<?php namespace Picqer\Financials\Moneybird;

/**
 * Class Model
 * @package Picqer\Financials\Moneybird
 */
abstract class Model
{

    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @var array The model's attributes
     */
    protected $attributes = [ ];

    /**
     * @var array The model's fillable attributes
     */
    protected $fillable = [ ];

    /**
     * @var string The URL endpoint of this model
     */
    protected $url = '';

    /**
     * @var string Name of the primary key for this model
     */
    protected $primaryKey = 'id';


    /**
     * @var string Namespace of the model (for POST and PATCH requests)
     */
    protected $namespace = '';

    /**
     * @var array
     */
    protected $singleNestedEntities = [];

    /**
     * @var array
     */
    protected $multipleNestedEntities = [];


    /**
     * Model constructor.
     * @param Connection $connection
     * @param array $attributes
     */
    public function __construct(Connection $connection, array $attributes = [ ])
    {
        $this->connection = $connection;
        $this->fill($attributes);
    }


    /**
     * Get the connection instance
     *
     * @return Connection
     */
    public function connection()
    {
        return $this->connection;
    }


    /**
     * Get the model's attributes
     *
     * @return array
     */
    public function attributes()
    {
        return $this->attributes;
    }


    /**
     * Fill the entity from an array
     *
     * @param array $attributes
     */
    protected function fill(array $attributes)
    {
        foreach ($this->fillableFromArray($attributes) as $key => $value) {
            if ($this->isFillable($key)) {
                $this->setAttribute($key, $value);
            }
        }
    }


    /**
     * Get the fillable attributes of an array
     *
     * @param array $attributes
     *
     * @return array
     */
    protected function fillableFromArray(array $attributes)
    {
        if (count($this->fillable) > 0) {
            return array_intersect_key($attributes, array_flip($this->fillable));
        }

        return $attributes;
    }


    /**
     * @param $key
     * @return bool
     */
    protected function isFillable($key)
    {
        return in_array($key, $this->fillable);
    }


    /**
     * @param $key
     * @param $value
     */
    protected function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;
    }


    /**
     * @param $key
     * @return mixed
     */
    public function __get($key)
    {
        if (isset( $this->attributes[$key] )) {
            return $this->attributes[$key];
        }
    }


    /**
     * @param $key
     * @param $value
     */
    public function __set($key, $value)
    {
        if ($this->isFillable($key)) {
            return $this->setAttribute($key, $value);
        }
    }


    /**
     * @return bool
     */
    public function exists()
    {
        if ( ! array_key_exists($this->primaryKey, $this->attributes)) {
            return false;
        }

        return ! empty( $this->attributes[$this->primaryKey] );
    }


    /**
     * @return string
     */
    public function json()
    {
        $array = $this->getArrayWithNestedObjects();

        return json_encode($array);
    }

    /**
     * @return string
     */
    public function jsonWithNamespace()
    {
        return json_encode([$this->namespace => $this->getArrayWithNestedObjects()]);
    }

    private function getArrayWithNestedObjects()
    {
        $result = [];

        foreach ($this->attributes as $attributeName => $attributeValue) {
            if (! is_object($attributeValue)) {
                $result[$attributeName] = $attributeValue;
            }

            if (array_key_exists($attributeName, $this->getSingleNestedEntities())) {
                $result[$attributeName] = $attributeValue->attributes;
            }

            if (array_key_exists($attributeName, $this->getMultipleNestedEntities())) {
                foreach ($attributeValue as $attributeObject) {
                    $result[$attributeName][] = $attributeObject->attributes;
                }
            }
        }

        return $result;
    }


    /**
     * @param $response
     * @return static
     */
    public function makeFromResponse($response)
    {
        $entity = new static($this->connection);
        $entity->fill($response);

        foreach ($entity->getSingleNestedEntities() as $key => $value)
        {
            $entityName = 'Picqer\Financials\Moneybird\Entities\\' . $value;
            $entity->$key = new $entityName($this->connection, $response[$key]);
        }

        foreach ($entity->getMultipleNestedEntities() as $key => $value)
        {
            $entityName = 'Picqer\Financials\Moneybird\Entities\\' . $value;
            $instaniatedEntity = new $entityName($this->connection);
            $entity->$key = $instaniatedEntity->collectionFromResult($response[$key]);
        }

        return $entity;
    }

    /**
     * @param $result
     * @return array
     */
    public function collectionFromResult($result)
    {
        // If we have one result which is not an assoc array, make it the first element of an array for the
        // collectionFromResult function so we always return a collection from filter
        if ((bool) count(array_filter(array_keys($result), 'is_string'))) {
            $result = [ $result ];
        }

        $collection = [ ];
        foreach ($result as $r) {
            $collection[] = static::makeFromResponse($r);
        }

        return $collection;
    }

    /**
     * @return mixed
     */
    public function getSingleNestedEntities()
    {
        return $this->singleNestedEntities;
    }

    /**
     * @return array
     */
    public function getMultipleNestedEntities()
    {
        return $this->multipleNestedEntities;
    }

    /**
     * Make var_dump and print_r look pretty
     *
     * @return array
     */
    public function __debugInfo()
    {
        $result = [];
        foreach ($this->fillable as $attribute)
        {
            $result[$attribute] = $this->$attribute;
        }
        return $result;
    }

}