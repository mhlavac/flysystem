<?php

use Flysystem\Adapter\Local;
use Flysystem\Adapter\Zip;

class ZipTests extends PHPUnit_Framework_TestCase
{
    public function zipProvider()
    {
        return array(
            array(new Flysystem\Adapter\Zip(__DIR__.'/files/tester.zip', new ZipArchive))
        );
    }

    public function testInstance()
    {
        $adapter = new Flysystem\Adapter\Zip(__DIR__.'/files/tester.zip', new ZipArchive);
        $this->assertInstanceOf('Flysystem\AdapterInterface', $adapter);
    }

    /**
     * @dataProvider zipProvider
     */
    public function testGetArchive($zip)
    {
        $this->assertInstanceOf('ZipArchive', $zip->getArchive());
    }

    /**
     * @dataProvider zipProvider
     */
    public function testZip($zip)
    {
        $this->assertCount(0, $zip->listContents());
        $this->assertInternalType('array', $zip->write('file.txt', 'contents'));
        $this->assertCount(1, $zip->listContents());
        $this->assertInternalType('array', $zip->write('nested/file.txt', 'contents'));
        $this->assertCount(3, $zip->listContents());
        $result = $zip->read('nested/file.txt');
        $this->assertEquals('contents', $result['contents']);
        $zip->update('nested/file.txt', 'new contents');
        $result = $zip->read('nested/file.txt');
        $this->assertEquals('new contents', $result['contents']);
        $result = $zip->getSize('nested/file.txt');
        $this->assertEquals(12, $result['size']);
        $result = $zip->getTimestamp('nested/file.txt');
        $this->assertInternalType('integer', $result['timestamp']);
        $result = $zip->getMimetype('nested/file.txt');
        $this->assertEquals('text/plain', $result['mimetype']);
        $zip->deleteDir('nested');
        $this->assertCount(1, $zip->listContents());
        $zip->rename('file.txt', 'renamed.txt');
        $this->assertFalse($zip->has('file.txt'));
    }

    /**
     * @expectedException LogicException
     * @dataProvider zipProvider
     */
    public function testGetVisibility($zip)
    {
        $zip->getVisibility('path');
    }

    /**
     * @expectedException LogicException
     * @dataProvider zipProvider
     */
    public function testSetVisibility($zip)
    {
        $zip->setVisibility('path', 'public');
    }

    /**
     * @expectedException  LogicException
     */
    public function testZipOpenFails()
    {
        $mock = Mockery::mock('ZipArchive');
        $mock->shouldReceive('open')->andReturn(false);
        $zip = new Zip('location', $mock);
    }

    public function testZipReadWriteFails()
    {
        $mock = Mockery::mock('ZipArchive');
        $mock->shouldReceive('open')->andReturn(true);
        $mock->shouldReceive('close')->andReturn(true);
        $mock->shouldReceive('addFromString')->andReturn(false);
        $mock->shouldReceive('getFromName')->andReturn(false);
        $zip = new Zip('location', $mock);

        $this->assertFalse($zip->write('file', 'contents'));
        $this->assertFalse($zip->read('file'));
        $this->assertFalse($zip->getMimetype('file'));
    }
}