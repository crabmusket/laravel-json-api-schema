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

namespace LaravelJsonApi\Schema\Tests\Integration\Schema;

use LaravelJsonApi\Schema\Fields\Attribute;
use LaravelJsonApi\Schema\Fields\BelongsTo;
use LaravelJsonApi\Schema\Fields\HasMany;
use LaravelJsonApi\Schema\Tests\PostSchema;
use PHPUnit\Framework\TestCase;

class SchemaBuilderTest extends TestCase
{

    public function test(): void
    {
        $schema = (new PostSchema())->create('/api/v1');

        $this->assertSame('posts', $schema->type(), 'type');
        $this->assertSame('/api/v1/posts', $schema->baseUri(), 'base uri');

        $this->assertEquals([
            'description' => new Attribute('description'),
            'slug' => new Attribute('slug'),
            'title' => new Attribute('title'),
        ], iterator_to_array($schema->fields()->attributes()));

        $this->assertEquals([
            'author' => new BelongsTo('author', 'users'),
            'comments' => new HasMany('comments', 'comments'),
        ], iterator_to_array($schema->fields()->relations()));
    }
}
