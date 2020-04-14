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

use LaravelJsonApi\Schema\Fields\BelongsTo;
use PHPUnit\Framework\TestCase;

class BelongsToTest extends TestCase
{

    public function test(): BelongsTo
    {
        $field = new BelongsTo('author', 'users');

        $this->assertSame('author', $field->name(), 'name');
        $this->assertSame('users', $field->inverse(), 'inverse');
        $this->assertTrue($field->toOne(), 'to one');
        $this->assertFalse($field->toMany(), 'to many');
        $this->assertFalse($field->isFillable(), 'fillable');
        $this->assertTrue($field->isGuarded(), 'guarded');
        $this->assertTrue($field->isSparseField(), 'sparse field');
        $this->assertFalse($field->isSortable(), 'sortable');
        $this->assertFalse($field->isFilter(), 'filter');
        $this->assertTrue($field->isIncludePath(), 'include path');
        $this->assertFalse($field->isDefaultIncludePath(), 'default include path');
        $this->assertTrue($field->hasSelfLink(), 'self link');
        $this->assertTrue($field->hasRelatedLink(), 'related link');

        return $field;
    }

    /**
     * @param BelongsTo $field
     * @depends test
     */
    public function testIncludePath(BelongsTo $field): void
    {
        $this->assertSame($field, $field->notIncludePath());
        $this->assertFalse($field->isIncludePath());

        $this->assertSame($field, $field->includePath());
        $this->assertTrue($field->isIncludePath());
    }

    /**
     * @param BelongsTo $field
     * @depends test
     */
    public function testDefaultIncludePath(BelongsTo $field): void
    {
        $this->assertSame($field, $field->defaultIncludePath());
        $this->assertTrue($field->isDefaultIncludePath());

        $this->assertSame($field, $field->defaultIncludePath(false));
        $this->assertFalse($field->isDefaultIncludePath());
    }

    /**
     * @param BelongsTo $field
     * @depends test
     */
    public function testSelfLink(BelongsTo $field): void
    {
        $this->assertSame($field, $field->withoutSelf());
        $this->assertFalse($field->hasSelfLink());

        $this->assertSame($field, $field->withSelf());
        $this->assertTrue($field->hasSelfLink());
    }

    /**
     * @param BelongsTo $field
     * @depends test
     */
    public function testRelatedLink(BelongsTo $field): void
    {
        $this->assertSame($field, $field->withoutRelated());
        $this->assertFalse($field->hasRelatedLink());

        $this->assertSame($field, $field->withRelated());
        $this->assertTrue($field->hasRelatedLink());
    }
}
