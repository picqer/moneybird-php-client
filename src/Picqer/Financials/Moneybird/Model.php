<?php namespace Picqer\Financials\Moneybird;

/**
 * Class Model
 * @package Picqer\Financials\Moneybird
 */
abstract class Model
{

    const NESTING_TYPE_ARRAY_OF_OBJECTS = 0;
    const NESTING_TYPE_NESTED_OBJECTS = 1;

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
    protected $endpoint = '';

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
     * Array containing the name of the attribute that contains nested objects as key and an array with the entity name
     * and json representation type
     *
     * JSON representation of an array of objects (NESTING_TYPE_ARRAY_OF_OBJECTS) : [ {}, {} ]
     * JSON representation of nested objects (NESTING_TYPE_NESTED_OBJECTS): { "0": {}, "1": {} }
     *
     * @var array
     */
    protected $multipleNestedEntities = [];

    /**
     * Model constructor.
     * @param \Picqer\Financials\Moneybird\Connection $connection
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
     * @return \Picqer\Financials\Moneybird\Connection
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
     * @param string $key
     * @return bool
     */
    protected function isFillable($key)
    {
        return in_array($key, $this->fillable);
    }


    /**
     * @param string $key
     * @param mixed $value
     */
    protected function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;
    }


    /**
     * @param string $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        if (isset( $this->attributes[$key] )) {
            return $this->attributes[$key];
        }

        return null;
    }


    /**
     * @param string $key
     * @param mixed $value
     */
    public function __set($key, $value)
    {
        if ($this->isFillable($key)) {
            $this->setAttribute($key, $value);
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

        return json_encode($array, JSON_FORCE_OBJECT);
    }

    /**
     * @return string
     */
    public function jsonWithNamespace()
    {
        if ($this->namespace !== '') {
            return json_encode([$this->namespace => $this->getArrayWithNestedObjects()], JSON_FORCE_OBJECT);
        } else {
            return $this->json();
        }
    }

    /**
     * @param bool $useAttributesAppend
     *
     * @return array
     */
    private function getArrayWithNestedObjects($useAttributesAppend = true)
    {
        $result = [];
        $multipleNestedEntities = $this->getMultipleNestedEntities();

        foreach ($this->attributes as $attributeName => $attributeValue) {
            if (! is_object($attributeValue)) {
                $result[$attributeName] = $attributeValue;
            }

            if (array_key_exists($attributeName, $this->getSingleNestedEntities())) {
                $result[$attributeName] = $attributeValue->attributes;
            }

            if (array_key_exists($attributeName, $multipleNestedEntities)) {
                if ($useAttributesAppend) {
                    $attributeNameToUse = $attributeName . '_attributes';
                } else {
                    $attributeNameToUse = $attributeName;
                }

                $result[$attributeNameToUse] = [];
                foreach ($attributeValue as $attributeEntity) {
                    $result[$attributeNameToUse][] = $attributeEntity->attributes;

                    if ($multipleNestedEntities[$attributeName]['type'] === self::NESTING_TYPE_NESTED_OBJECTS) {
                        $result[$attributeNameToUse] = (object)$result[$attributeNameToUse];
                    }
                }

                if (
                    $multipleNestedEntities[$attributeName]['type'] === self::NESTING_TYPE_NESTED_OBJECTS
                    && empty($result[$attributeNameToUse])
                ) {
                    $result[$attributeNameToUse] = new \StdClass();
                }
            }
        }

        return $result;
    }


    /**
     * Create a new object with the response from the API
     *
     * @param $response
     *
     * @return static
     */
    public function makeFromResponse($response)
    {
        $entity = new static($this->connection);
        $entity->selfFromResponse($response);

        return $entity;
    }

    /**
     * Recreate this object with the response from the API
     *
     * @param $response
     *
     * @return $this
     */
    public function selfFromResponse($response)
    {
        $this->fill($response);

        foreach ($this->getSingleNestedEntities() as $key => $value)
        {
            if (isset($response[$key])) {
                $entityName = 'Picqer\Financials\Moneybird\Entities\\' . $value;
                $this->$key = new $entityName($this->connection, $response[$key]);
            }
        }

        foreach ($this->getMultipleNestedEntities() as $key => $value)
        {
            if (isset($response[$key])) {
                $entityName = 'Picqer\Financials\Moneybird\Entities\\' . $value['entity'];
                /** @var \Picqer\Financials\Moneybird\Model $instaniatedEntity */
                $instaniatedEntity = new $entityName($this->connection);
                $this->$key = $instaniatedEntity->collectionFromResult($response[$key]);
            }
        }

        return $this;
    }

    /**
     * @param $result
     *
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
            $collection[] = $this->makeFromResponse($r);
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

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * Determine if an attribute exists on the model
     *
     * @param string $name
     *
     * @return bool
     */
    public function __isset($name)
    {
        return (isset($this->attributes[$name]) && null !== $this->attributes[$name]);
    }

}
