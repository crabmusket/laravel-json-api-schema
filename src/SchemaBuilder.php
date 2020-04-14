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

namespace LaravelJsonApi\Schema;

use LaravelJsonApi\Core\Contracts\Schema\AttributeInterface;
use LaravelJsonApi\Core\Contracts\Schema\RelationInterface;
use LaravelJsonApi\Core\Support\Str;
use LaravelJsonApi\Schema\Fields\Attribute;
use LaravelJsonApi\Schema\Fields\BelongsTo;
use LaravelJsonApi\Schema\Fields\FieldBuilder;
use LaravelJsonApi\Schema\Fields\FieldList;
use LaravelJsonApi\Schema\Fields\HasMany;
use function class_basename;

abstract class SchemaBuilder
{

    /**
     * @var string|null
     */
    protected $resourceType;

    /**
     * @param string $baseUri
     * @return Schema
     */
    public function create(string $baseUri): Schema
    {
        return new Schema(
            $this->resourceType(),
            $baseUri,
            $this->fields()
        );
    }

    /**
     * @return string
     */
    protected function resourceType(): string
    {
        if ($this->resourceType) {
            return $this->resourceType;
        }

        return $this->resourceType = $this->guessResourceType();
    }

    /**
     * Create an attribute field.
     *
     * @param string|null $name
     * @return AttributeInterface
     */
    protected function attribute(string $name = null): AttributeInterface
    {
        return new Attribute($name ?: $this->guessFieldName());
    }

    /**
     * Create a belongs-to relation.
     *
     * @param string|null $name
     * @param string|null $inverse
     * @return RelationInterface
     */
    protected function belongsTo(string $name = null, string $inverse = null): RelationInterface
    {
        return new BelongsTo(
            $name = $name ?: $this->guessFieldName(),
            $inverse ?: $this->guessInverseForBelongsTo($name)
        );
    }

    /**
     * Create a has-many relation.
     *
     * @param string|null $name
     * @param string|null $inverse
     * @return RelationInterface
     */
    protected function hasMany(string $name = null, string $inverse = null): RelationInterface
    {
        return new HasMany(
            $name = $name ?: $this->guessFieldName(),
            $inverse ?: $this->guessInverseForHasMany($name)
        );
    }

    /**
     * @return FieldList
     */
    protected function fields(): FieldList
    {
        return (new FieldBuilder($this))->fields();
    }

    /**
     * @return string
     */
    private function guessResourceType(): string
    {
        $name = Str::beforeLast(class_basename($this), 'Schema');

        return Str::dasherize(Str::plural($name));
    }

    /**
     * Guess the field name.
     *
     * @return string
     */
    private function guessFieldName(): string
    {
        [$one, $two, $caller] = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3);

        return $caller['function'];
    }

    /**
     * Guess the inverse resource type for a belongs-to relation.
     *
     * @param string $fieldName
     * @return string
     */
    private function guessInverseForBelongsTo(string $fieldName): string
    {
        return Str::dasherize(Str::plural($fieldName));
    }

    /**
     * Guess the inverse resource type for a has-many relation.
     *
     * @param string $fieldName
     * @return string
     */
    private function guessInverseForHasMany(string $fieldName): string
    {
        return Str::dasherize($fieldName);
    }

}
