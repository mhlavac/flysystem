<?php

namespace League\Flysystem\Adapter;

use League\Flysystem\Stub\NotSupportingVisibilityStub;
use PHPUnit\Framework\TestCase;

class NotSupportingVisivilityTests extends TestCase
{
    use \Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

    public function testGetVisibility()
    {
        $this->setExpectedException('LogicException');
        $stub = new NotSupportingVisibilityStub();
        $stub->getVisibility('path.txt');
    }

    public function testSetVisibility()
    {
        $this->setExpectedException('LogicException');
        $stub = new NotSupportingVisibilityStub();
        $stub->setVisibility('path.txt', 'public');
    }
}
