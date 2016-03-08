<?php

namespace OpenStack\Images\v2\Models;

use JsonSchema\Validator;

class Schema extends \OpenCloud\Common\JsonSchema\Schema
{
    public function __construct($data, Validator $validator = null)
    {
        if (!isset($data->type)) {
            $data->type = 'object';
        }

        foreach ($data->properties as $propertyName => &$property) {
            if (strpos($property->description, 'READ-ONLY') !== false) {
                $property->readOnly = true;
            }
        }

        parent::__construct($data, $validator);
    }
}
