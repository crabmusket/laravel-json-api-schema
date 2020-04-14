<?php

namespace LaravelJsonApi\Schema\Tests;

use LaravelJsonApi\Core\Contracts\Schema\AttributeInterface;
use LaravelJsonApi\Core\Contracts\Schema\RelationInterface;
use LaravelJsonApi\Schema\SchemaBuilder;

class CommentSchema extends SchemaBuilder
{

    /**
     * @return AttributeInterface
     */
    public function content(): AttributeInterface
    {
        return $this->attribute();
    }

    /**
     * @return AttributeInterface
     */
    public function createdAt(): AttributeInterface
    {
        return $this->attribute();
    }

    /**
     * @return AttributeInterface
     */
    public function updatedAt(): AttributeInterface
    {
        return $this->attribute();
    }

    /**
     * @return RelationInterface
     */
    public function user(): RelationInterface
    {
        return $this->belongsTo();
    }
}
