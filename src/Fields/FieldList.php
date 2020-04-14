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

use Countable;
use Generator;
use IteratorAggregate;
use LaravelJsonApi\Core\Contracts\Schema\FieldInterface;
use LaravelJsonApi\Core\Contracts\Schema\RelationInterface;
use OutOfBoundsException;
use function ksort;

class FieldList implements IteratorAggregate, Countable
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
     * @param FieldInterface ...$fields
     */
    public function __construct(FieldInterface ...$fields)
    {
        $this->attributes = [];
        $this->relations = [];

        foreach ($fields as $field) {
            if ($field instanceof RelationInterface) {
                $this->relations[$field->name()] = $field;
                continue;
            }

            $this->attributes[$field->name()] = $field;
        }

        ksort($this->attributes);
        ksort($this->relations);
    }

    /**
     * Get a field by name.
     *
     * @param string $name
     * @return FieldInterface
     */
    public function field(string $name): FieldInterface
    {
        if (isset($this->attributes[$name])) {
            return $this->attributes[$name];
        }

        if (isset($this->relations[$name])) {
            return $this->relations[$name];
        }

        throw new OutOfBoundsException("Field {$name} does not exist.");
    }

    /**
     * Return a generator to iterate over attributes.
     *
     * @return Generator
     */
    public function attributes(): Generator
    {
        yield from $this->attributes;
    }

    /**
     * Return a generator to iterate over relationships.
     *
     * @return Generator
     */
    public function relations(): Generator
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
