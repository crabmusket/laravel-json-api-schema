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

use LaravelJsonApi\Schema\Fields\HasMany;
use PHPUnit\Framework\TestCase;

class HasManyTest extends TestCase
{

    public function test(): HasMany
    {
        $field = new HasMany('author', 'users');

        $this->assertSame('author', $field->name(), 'name');
        $this->assertSame('users', $field->inverse(), 'inverse');
        $this->assertFalse($field->toOne(), 'to one');
        $this->assertTrue($field->toMany(), 'to many');
        $this->assertFalse($field->isFillable(), 'fillable');
        $this->assertTrue($field->isGuarded(), 'guarded');
        $this->assertTrue($field->isSparseField(), 'sparse field');
        $this->assertFalse($field->isSortable(), 'sortable');
        $this->assertFalse($field->isFilter(), 'filter');
        $this->assertFalse($field->isIncludePath(), 'include path');
        $this->assertFalse($field->isDefaultIncludePath(), 'default include path');
        $this->assertTrue($field->hasSelfLink(), 'self link');
        $this->assertTrue($field->hasRelatedLink(), 'related link');

        return $field;
    }

    /**
     * @param HasMany $field
     * @depends test
     */
    public function testIncludePath(HasMany $field): void
    {
        $this->assertSame($field, $field->includePath());
        $this->assertTrue($field->isIncludePath());

        $this->assertSame($field, $field->notIncludePath());
        $this->assertFalse($field->isIncludePath());
    }

    /**
     * @param HasMany $field
     * @depends test
     */
    public function testDefaultIncludePath(HasMany $field): void
    {
        $this->assertSame($field, $field->defaultIncludePath());
        $this->assertTrue($field->isDefaultIncludePath());

        $this->assertSame($field, $field->defaultIncludePath(false));
        $this->assertFalse($field->isDefaultIncludePath());
    }

    /**
     * @param HasMany $field
     * @depends test
     */
    public function testSelfLink(HasMany $field): void
    {
        $this->assertSame($field, $field->withoutSelf());
        $this->assertFalse($field->hasSelfLink());

        $this->assertSame($field, $field->withSelf());
        $this->assertTrue($field->hasSelfLink());
    }

    /**
     * @param HasMany $field
     * @depends test
     */
    public function testRelatedLink(HasMany $field): void
    {
        $this->assertSame($field, $field->withoutRelated());
        $this->assertFalse($field->hasRelatedLink());

        $this->assertSame($field, $field->withRelated());
        $this->assertTrue($field->hasRelatedLink());
    }
}
