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

declare(strict_types=1);

namespace LaravelJsonApi\Schema\Fields;

use IteratorAggregate;
use LaravelJsonApi\Core\Contracts\Schema\Field as FieldContract;
use LaravelJsonApi\Core\Contracts\Schema\FieldList as FieldListContract;
use LaravelJsonApi\Core\Contracts\Schema\Relation as RelationContract;
use LogicException;
use function ksort;

class FieldList implements FieldListContract, IteratorAggregate
{

    /**
     * @var array
     */
    private $attributes;

    /**
     * @var array
     */
    private $relations;

    /**
     * FieldList constructor.
     *
     * @param FieldContract ...$fields
     */
    public function __construct(FieldContract ...$fields)
    {
        $this->attributes = [];
        $this->relations = [];

        foreach ($fields as $field) {
            if ($field instanceof RelationContract) {
                $this->relations[$field->name()] = $field;
                continue;
            }

            $this->attributes[$field->name()] = $field;
        }

        ksort($this->attributes);
        ksort($this->relations);
    }

    /**
     * @inheritDoc
     */
    public function exists(string $name): bool
    {
        if (isset($this->attributes[$name])) {
            return true;
        }

        return isset($this->relations[$name]);
    }

    /**
     * @inheritDoc
     */
    public function field(string $name): FieldContract
    {
        if (isset($this->attributes[$name])) {
            return $this->attributes[$name];
        }

        if (isset($this->relations[$name])) {
            return $this->relations[$name];
        }

        throw new LogicException("Field {$name} does not exist.");
    }

    /**
     * @inheritDoc
     */
    public function attributes(): iterable
    {
        yield from $this->attributes;
    }

    /**
     * @inheritDoc
     */
    public function relations(): iterable
    {
        yield from $this->relations;
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        yield from $this->attributes();
        yield from $this->relations();
    }

    /**
     * @inheritDoc
     */
    public function count()
    {
        return count($this->attributes) + count($this->relations);
    }

}
