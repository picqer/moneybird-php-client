<?php

namespace Picqer\Financials\Moneybird;

/**
 * Class Model.
 */
abstract class Model
{
    const NESTING_TYPE_ARRAY_OF_OBJECTS = 0;
    const NESTING_TYPE_NESTED_OBJECTS = 1;
    const JSON_OPTIONS = JSON_FORCE_OBJECT;

    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @var array The model's attributes
     */
    protected $attributes = [];

    /**
     * @var array The model's changed attributes
     */
    protected $attribute_changes = [];

    /**
     * @var bool Register the intilized state of this model for dirty attributes registration
     */
    protected $initializing = false;

    /**
     * @var array The model's fillable attributes
     */
    protected $fillable = [];

    /**
     * @var string The URL endpoint of this model
     */
    protected $endpoint = '';

    /**
     * @var string The Filter URL endpoint of this model
     */
    protected $filter_endpoint = '';

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
     * and json representation type.
     *
     * JSON representation of an array of objects (NESTING_TYPE_ARRAY_OF_OBJECTS) : [ {}, {} ]
     * JSON representation of nested objects (NESTING_TYPE_NESTED_OBJECTS): { "0": {}, "1": {} }
     *
     * @var array
     */
    protected $multipleNestedEntities = [];

    /**
     * Model constructor.
     *
     * @param  \Picqer\Financials\Moneybird\Connection  $connection
     * @param  array  $attributes
     */
    public function __construct(Connection $connection, array $attributes = [])
    {
        $this->connection = $connection;
        $this->fill($attributes, false);
    }

    /**
     * Get the connection instance.
     *
     * @return \Picqer\Financials\Moneybird\Connection
     */
    public function connection()
    {
        return $this->connection;
    }

    /**
     * Get the model's attributes.
     *
     * @return array
     */
    public function attributes()
    {
        return $this->attributes;
    }

    /**
     * Get the fillable items.
     *
     * @return array
     */
    public function getFillable()
    {
        return $this->fillable;
    }

    /**
     * Fill the entity from an array.
     *
     * @param  array  $attributes
     * @param  bool  $first_initialize
     */
    protected function fill(array $attributes, $first_initialize)
    {
        if ($first_initialize) {
            $this->enableFirstInitialize();
        }

        foreach ($this->fillableFromArray($attributes) as $key => $value) {
            if ($this->isFillable($key)) {
                $this->setAttribute($key, $value);
            }
        }

        if ($first_initialize) {
            $this->disableFirstInitialize();
        }
    }

    /**
     * Register the current model as initializing.
     */
    protected function enableFirstInitialize()
    {
        $this->initializing = true;
    }

    /**
     * Register the current model as initialized.
     */
    protected function disableFirstInitialize()
    {
        $this->initializing = false;
    }

    /**
     * Get the fillable attributes of an array.
     *
     * @param  array  $attributes
     * @return array
     */
    protected function fillableFromArray(array $attributes)
    {
        if (count($this->getFillable()) > 0) {
            return array_intersect_key($attributes, array_flip($this->getFillable()));
        }

        return $attributes;
    }

    /**
     * @param  string  $key
     * @return bool
     */
    protected function isFillable($key)
    {
        return in_array($key, $this->getFillable(), true);
    }

    /**
     * @param  string  $key
     * @param  mixed  $value
     */
    protected function setAttribute($key, $value)
    {
        if (! isset($this->attribute_changes[$key])) {
            $from = null;

            if (isset($this->attributes[$key])) {
                $from = $this->attributes[$key];
            }

            $this->attribute_changes[$key] = [
                'from' => $from,
                'to' => $value,
            ];
        } else {
            $this->attribute_changes[$key]['to'] = $value;
        }

        $this->attributes[$key] = $value;
    }

    /**
     * All keys that are changed in this model.
     *
     * @return array
     */
    public function getDirty()
    {
        return array_keys($this->attribute_changes);
    }

    /**
     * All changed keys with it values.
     *
     * @return array
     */
    public function getDirtyValues()
    {
        return $this->attribute_changes;
    }

    /**
     * Check if the attribute is changed since the last save/update/create action.
     *
     * @param $attributeName
     * @return bool
     */
    public function isAttributeDirty($attributeName)
    {
        if (array_key_exists($attributeName, $this->attribute_changes)) {
            return true;
        }

        return false;
    }

    /**
     * Clear the changed/dirty attribute in this model.
     */
    public function clearDirty()
    {
        $this->attribute_changes = [];
    }

    /**
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        if (isset($this->attributes[$key])) {
            return $this->attributes[$key];
        }

        return null;
    }

    /**
     * @param  string  $key
     * @param  mixed  $value
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
        if (! array_key_exists($this->primaryKey, $this->attributes)) {
            return false;
        }

        return ! empty($this->attributes[$this->primaryKey]);
    }

    /**
     * @return string
     */
    public function json()
    {
        $array = $this->getArrayWithNestedObjects();

        return json_encode($array, static::JSON_OPTIONS);
    }

    /**
     * @return string
     */
    public function jsonWithNamespace()
    {
        if ($this->namespace !== '') {
            return json_encode([$this->namespace => $this->getArrayWithNestedObjects()], static::JSON_OPTIONS);
        } else {
            return $this->json();
        }
    }

    /**
     * @param  bool  $useAttributesAppend
     * @return array
     */
    private function getArrayWithNestedObjects($useAttributesAppend = true)
    {
        $result = [];
        $multipleNestedEntities = $this->getMultipleNestedEntities();

        foreach ($this->attributes as $attributeName => $attributeValue) {
            if (! is_object($attributeValue)) {
                //check if result is changed
                if ($this->isAttributeDirty($attributeName)) {
                    $result[$attributeName] = $attributeValue;
                }
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
                }

                if ($multipleNestedEntities[$attributeName]['type'] === self::NESTING_TYPE_NESTED_OBJECTS) {
                    $result[$attributeNameToUse] = (object) $result[$attributeNameToUse];
                }

                if (
                    $multipleNestedEntities[$attributeName]['type'] === self::NESTING_TYPE_NESTED_OBJECTS
                    && empty($result[$attributeNameToUse])
                ) {
                    $result[$attributeNameToUse] = new \stdClass();
                }
            }
        }

        return $result;
    }

    /**
     * Create a new object with the response from the API.
     *
     * @param  array  $response
     * @return static
     */
    public function makeFromResponse(array $response)
    {
        $entity = new static($this->connection);
        $entity->selfFromResponse($response);

        return $entity;
    }

    /**
     * Recreate this object with the response from the API.
     *
     * @param  array  $response
     * @return $this
     */
    public function selfFromResponse(array $response)
    {
        $this->fill($response, true);

        foreach ($this->getSingleNestedEntities() as $key => $value) {
            if (isset($response[$key])) {
                $entityName = $value;
                $this->$key = new $entityName($this->connection, $response[$key]);
            }
        }

        foreach ($this->getMultipleNestedEntities() as $key => $value) {
            if (isset($response[$key])) {
                $entityName = $value['entity'];
                /** @var self $instantiatedEntity */
                $instantiatedEntity = new $entityName($this->connection);
                $this->$key = $instantiatedEntity->collectionFromResult($response[$key]);
            }
        }

        return $this;
    }

    /**
     * @param  array  $result
     * @return array
     */
    public function collectionFromResult(array $result)
    {
        // If we have one result which is not an assoc array, make it the first element of an array for the
        // collectionFromResult function so we always return a collection from filter
        if ((bool) count(array_filter(array_keys($result), 'is_string'))) {
            $result = [$result];
        }

        $collection = [];
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
     * Make var_dump and print_r look pretty.
     *
     * @return array
     */
    public function __debugInfo()
    {
        $result = [];

        foreach ($this->getFillable() as $attribute) {
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
     * @return string
     */
    public function getFilterEndpoint()
    {
        return $this->filter_endpoint ?: $this->endpoint;
    }

    /**
     * Determine if an attribute exists on the model.
     *
     * @param  string  $name
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->attributes[$name]) && null !== $this->attributes[$name];
    }
}
