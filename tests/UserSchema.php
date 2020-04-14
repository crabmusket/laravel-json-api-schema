<?php

namespace LaravelJsonApi\Schema\Tests;

use LaravelJsonApi\Core\Contracts\Schema\AttributeInterface;
use LaravelJsonApi\Core\Contracts\Schema\RelationInterface;
use LaravelJsonApi\Schema\SchemaBuilder;

class UserSchema extends SchemaBuilder
{

    /**
     * @return RelationInterface
     */
    public function comments(): RelationInterface
    {
        return $this->hasMany();
    }

    /**
     * @return AttributeInterface
     */
    public function firstName(): AttributeInterface
    {
        return $this->attribute();
    }

    /**
     * @return AttributeInterface
     */
    public function lastName(): AttributeInterface
    {
        return $this->attribute();
    }

    /**
     * @return RelationInterface
     */
    public function posts(): RelationInterface
    {
        return $this->hasMany();
    }
}
