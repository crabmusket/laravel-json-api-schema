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

namespace LaravelJsonApi\Schema\Tests\Unit\Fields;

use LaravelJsonApi\Schema\Fields\Attribute;
use PHPUnit\Framework\TestCase;

class AttributeTest extends TestCase
{

    /**
     * @return Attribute
     */
    public function test(): Attribute
    {
        $field = new Attribute('foo');

        $this->assertSame('foo', $field->name(), 'name');
        $this->assertFalse($field->isReadOnly(), 'read-only');
        $this->assertTrue($field->isSparseField(), 'sparse field');
        $this->assertFalse($field->isSortable(), 'sortable');
        $this->assertFalse($field->isFilter(), 'filter');

        return $field;
    }

    /**
     * @param Attribute $field
     * @depends test
     */
    public function testReadOnly(Attribute $field): void
    {
        $this->assertSame($field, $field->readOnly());
        $this->assertTrue($field->isReadOnly(), 'read-only');

        $this->assertSame($field, $field->notReadOnly());
        $this->assertFalse($field->isReadOnly(), 'not read-only');
    }

    /**
     * @param Attribute $field
     * @depends test
     */
    public function testSparseFieldset(Attribute $field): void
    {
        $this->assertSame($field, $field->notSparseField());
        $this->assertFalse($field->isSparseField(), 'not sparse field');

        $this->assertSame($field, $field->sparseField());
        $this->assertTrue($field->isSparseField(), 'is sparse field');
    }

    /**
     * @param Attribute $field
     * @depends test
     */
    public function testSortable(Attribute $field): void
    {
        $this->assertSame($field, $field->sortable());
        $this->assertTrue($field->isSortable(), 'sortable');

        $this->assertSame($field, $field->notSortable());
        $this->assertFalse($field->isSortable(), 'not sortable');
    }

    /**
     * @param Attribute $field
     * @depends test
     */
    public function testFilter(Attribute $field): void
    {
        $this->assertSame($field, $field->filter());
        $this->assertTrue($field->isFilter(), 'filter');

        $this->assertSame($field, $field->notFilter());
        $this->assertFalse($field->isFilter(), 'not filter');
    }
}
