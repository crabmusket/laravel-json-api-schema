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
use LaravelJsonApi\Core\Contracts\Schema\RelationInterface;

abstract class Relation extends Field implements RelationInterface
{

    /**
     * @var string
     */
    private $inverse;

    /**
     * @var bool
     */
    private $include;

    /**
     * @var bool
     */
    private $defaultInclude;

    /**
     * @var bool
     */
    private $self;

    /**
     * @var bool
     */
    private $related;

    /**
     * Relation constructor.
     *
     * @param string $name
     * @param string $inverse
     */
    public function __construct(string $name, string $inverse)
    {
        if (empty($inverse)) {
            throw new InvalidArgumentException('Expecting a non-empty inverse resource type.');
        }

        parent::__construct($name);
        $this->inverse = $inverse;
        $this->include = false;
        $this->defaultInclude = false;
        $this->self = false;
        $this->related = false;
    }

    /**
     * Get the inverse resource type.
     *
     * @return string
     */
    public function inverse(): string
    {
        return $this->inverse;
    }

    /**
     * Mark the field as an allowed include path.
     *
     * @param bool $include
     * @return $this
     */
    public function includePath(bool $include = true): Relation
    {
        $this->include = $include;

        return $this;
    }

    /**
     * Mark the field as a disallowed include path.
     *
     * @param bool $doNotInclude
     * @return Relation
     */
    public function notIncludePath(bool $doNotInclude = true): Relation
    {
        return $this->includePath(!$doNotInclude);
    }

    /**
     * Mark the field as a default include path.
     *
     * @param bool $default
     * @return $this
     */
    public function defaultIncludePath(bool $default = true): Relation
    {
        if (true === $default) {
            $this->include = true;
        }

        $this->defaultInclude = $default;

        return $this;
    }

    /**
     * Mark the relation as having a self link.
     *
     * @param bool $self
     * @return $this
     */
    public function withSelf(bool $self = true): Relation
    {
        $this->self = $self;

        return $this;
    }

    /**
     * Mark the relation as not having a self link.
     *
     * @param bool $withoutSelf
     * @return $this
     */
    public function withoutSelf(bool $withoutSelf = true): Relation
    {
        return $this->withSelf(false === $withoutSelf);
    }

    /**
     * Mark the relation as having a related link.
     *
     * @param bool $related
     * @return $this
     */
    public function withRelated(bool $related = true): Relation
    {
        $this->related = $related;

        return $this;
    }

    /**
     * Mark the relation as not having a related link.
     *
     * @param bool $withoutRelated
     * @return $this
     */
    public function withoutRelated(bool $withoutRelated = true): Relation
    {
        return $this->withRelated(false === $withoutRelated);
    }

    /**
     * @return bool
     */
    public function isIncludePath(): bool
    {
        return $this->include;
    }

    /**
     * @return bool
     */
    public function isDefaultIncludePath(): bool
    {
        return $this->defaultInclude;
    }

    /**
     * @return bool
     */
    public function hasSelfLink(): bool
    {
        return $this->self;
    }

    /**
     * @return bool
     */
    public function hasRelatedLink(): bool
    {
        return $this->related;
    }

}
