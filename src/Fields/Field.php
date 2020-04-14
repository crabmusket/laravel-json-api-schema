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
    private $readOnly;

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
        $this->readOnly = false;
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
     * Mark the field as read-only.
     *
     * @param bool $readOnly
     * @return $this
     */
    public function readOnly(bool $readOnly = true): self
    {
        $this->readOnly = $readOnly;

        return $this;
    }

    /**
     * Mark the field as not read-only.
     *
     * @param bool $writeable
     * @return Field
     */
    public function notReadOnly(bool $writeable = true): self
    {
        return $this->readOnly(false === $writeable);
    }

    /**
     * Mark the field as an allowed sparse fieldset.
     *
     * @param bool $sparse
     * @return $this
     */
    public function sparseField(bool $sparse = true): self
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
    public function notSparseField(bool $notSparse = true): self
    {
        return $this->sparseField(false === $notSparse);
    }

    /**
     * Mark the field as sortable.
     *
     * @param bool $sortable
     * @return $this
     */
    public function sortable(bool $sortable = true): self
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
    public function notSortable(bool $notSortable = true): self
    {
        return $this->sortable(false === $notSortable);
    }

    /**
     * Mark the field as an allowed filter field.
     *
     * @param bool $filter
     * @return $this
     */
    public function filter(bool $filter = true): self
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
    public function notFilter(bool $notFilter = true): self
    {
        return $this->filter(false === $notFilter);
    }

    /**
     * @inheritDoc
     */
    public function isReadOnly(): bool
    {
        return $this->readOnly;
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
