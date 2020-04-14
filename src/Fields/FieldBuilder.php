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

use LaravelJsonApi\Core\Contracts\Schema\Attribute as AttributeContract;
use LaravelJsonApi\Core\Contracts\Schema\Relation as RelationContract;
use LaravelJsonApi\Schema\Utils\MethodIterator;
use ReflectionMethod;
use function is_subclass_of;

class FieldBuilder extends MethodIterator
{

    /**
     * FieldBuilder constructor.
     *
     * @param $object
     * @param int|null $filter
     */
    public function __construct($object, ?int $filter = ReflectionMethod::IS_PUBLIC)
    {
        parent::__construct($object, $filter);
    }

    /**
     * @return FieldList
     */
    public function fields(): FieldList
    {
        return new FieldList(...$this);
    }

    /**
     * @param ReflectionMethod $method
     * @return bool
     */
    protected function accept(ReflectionMethod $method): bool
    {
        $type = $method->getReturnType()->getName();

        return $this->attr($type) || $this->relation($type);
    }

    /**
     * Is the return type an attribute?
     *
     * @param string $type
     * @return bool
     */
    private function attr(string $type): bool
    {
        if ($type === AttributeContract::class) {
            return true;
        }

        return is_subclass_of($type, AttributeContract::class);
    }

    /**
     * Is the return type a relation?
     *
     * @param string $type
     * @return bool
     */
    private function relation(string $type): bool
    {
        if ($type === RelationContract::class) {
            return true;
        }

        return is_subclass_of($type, RelationContract::class);
    }
}
