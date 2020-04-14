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

namespace LaravelJsonApi\Schema\Utils;

use Generator;
use InvalidArgumentException;
use IteratorAggregate;
use LogicException;
use ReflectionClass;
use ReflectionMethod;
use Throwable;
use function get_class;
use function is_object;

abstract class MethodIterator implements IteratorAggregate
{

    /**
     * @var object
     */
    private $object;

    /**
     * @var int|null
     */
    private $filter;

    /**
     * @param ReflectionMethod $method
     * @return bool
     */
    abstract protected function accept(ReflectionMethod $method): bool;

    /**
     * FieldGenerator constructor.
     *
     * @param object $object
     * @param int|null $filter
     */
    public function __construct($object, int $filter = null)
    {
        if (!is_object($object)) {
            throw new InvalidArgumentException('Expecting an object.');
        }

        $this->object = $object;
        $this->filter = $filter;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return get_class($this->object);
    }

    /**
     * Iterator using a generator.
     *
     * @return Generator
     */
    public function cursor(): Generator
    {
        try {
            $class = new ReflectionClass($this->object);

            foreach ($class->getMethods($this->filter) as $method) {
                if ($this->accept($method)) {
                    yield $method->invoke($this->object);
                }
            }
        } catch (Throwable $ex) {
            throw new LogicException("Unable to build fields for {$this}.", 0, $ex);
        }
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        return $this->cursor();
    }

}
