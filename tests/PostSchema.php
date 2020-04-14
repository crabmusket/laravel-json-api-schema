<?php
/**
 * Copyright 2020 Cloud Creativity Limited
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace LaravelJsonApi\Schema\Tests;

use LaravelJsonApi\Core\Contracts\Schema\AttributeInterface;
use LaravelJsonApi\Core\Contracts\Schema\RelationInterface;
use LaravelJsonApi\Schema\SchemaBuilder;

class PostSchema extends SchemaBuilder
{

    /**
     * @return RelationInterface
     */
    public function author(): RelationInterface
    {
        return $this->belongsTo(null, 'users');
    }

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
    public function content(): AttributeInterface
    {
        return $this->attribute('description');
    }

    /**
     * @return AttributeInterface
     */
    public function slug(): AttributeInterface
    {
        return $this->attribute();
    }

    /**
     * @return AttributeInterface
     */
    public function title(): AttributeInterface
    {
        return $this->attribute();
    }
}
