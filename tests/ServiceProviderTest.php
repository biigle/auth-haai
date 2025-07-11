<?php

namespace Biigle\Tests\Modules\AuthHaai;

use Biigle\Modules\AuthHaai\ServiceProvider;
use TestCase;

class ServiceProviderTest extends TestCase
{
    public function testServiceProvider()
    {
        $this->assertTrue(class_exists(ServiceProvider::class));
    }
}
