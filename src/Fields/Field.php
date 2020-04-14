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

use InvalidArgumentException;
use LaravelJsonApi\Core\Contracts\Schema\Field as FieldContract;

abstract class Field implements FieldContract
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var bool
     */
    private $fillable;

    /**
     * @var bool
     */
    private $filter;

    /**
     * @var bool
     */
    private $sparseField;

    /**
     * @var bool
     */
    private $sortable;

    /**
     * Field constructor.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        if (empty($name)) {
            throw new InvalidArgumentException('Expecting a non-empty field name.');
        }

        $this->name = $name;
        $this->fillable = false;
        $this->filter = false;
        $this->sparseField = false;
        $this->sortable = false;
    }

    /**
     * @inheritDoc
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * Mark the field as mass-assignable.
     *
     * @param bool $fillable
     * @return $this
     */
    public function fillable(bool $fillable = true): Field
    {
        $this->fillable = $fillable;

        return $this;
    }

    /**
     * Mark the field as not mass-assignable.
     *
     * @param bool $guarded
     * @return Field
     */
    public function guarded(bool $guarded = true): Field
    {
        return $this->fillable(false === $guarded);
    }

    /**
     * Mark the field as an allowed sparse fieldset.
     *
     * @param bool $sparse
     * @return $this
     */
    public function sparseFieldset(bool $sparse = true): Field
    {
        $this->sparseField = $sparse;

        return $this;
    }

    /**
     * Mark the field as not allowed in sparse fieldsets.
     *
     * @param bool $notSparse
     * @return $this
     */
    public function notSparseFieldset(bool $notSparse = true): Field
    {
        return $this->sparseFieldset(false === $notSparse);
    }

    /**
     * Mark the field as sortable.
     *
     * @param bool $sortable
     * @return $this
     */
    public function sortable(bool $sortable = true): Field
    {
        $this->sortable = $sortable;

        return $this;
    }

    /**
     * Mark the field as not sortable.
     *
     * @param bool $notSortable
     * @return $this
     */
    public function notSortable(bool $notSortable = true): Field
    {
        return $this->sortable(false === $notSortable);
    }

    /**
     * Mark the field as an allowed filter field.
     *
     * @param bool $filter
     * @return $this
     */
    public function filter(bool $filter = true): Field
    {
        $this->filter = $filter;

        return $this;
    }

    /**
     * Mark the field as not allowed in filters.
     *
     * @param bool $notFilter
     * @return $this
     */
    public function notFilter(bool $notFilter = true): Field
    {
        return $this->filter(false === $notFilter);
    }

    /**
     * @inheritDoc
     */
    public function isFillable(): bool
    {
        return $this->fillable;
    }

    /**
     * @inheritDoc
     */
    public function isGuarded(): bool
    {
        return !$this->isFillable();
    }

    /**
     * @inheritDoc
     */
    public function isSparseField(): bool
    {
        return $this->sparseField;
    }

    /**
     * @inheritDoc
     */
    public function isSortable(): bool
    {
        return $this->sortable;
    }

    /**
     * @inheritDoc
     */
    public function isFilter(): bool
    {
        return $this->filter;
    }

}
