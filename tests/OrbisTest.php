<?php

namespace Lithe\Orbis\Tests;

use Exception;
use PHPUnit\Framework\TestCase;
use Lithe\Orbis\Orbis;
use ReflectionClass;
use stdClass;

class OrbisTest extends TestCase
{
    // This method is called after each test to clear registered instances
    protected function tearDown(): void
    {
        $this->clearInstances();
    }

    // Private method to clear registered instances
    private function clearInstances()
    {
        // Use Reflection to access the private 'instances' property of Orb
        $reflection = new ReflectionClass(Orbis::class);
        $property = $reflection->getProperty('instances');
        $property->setAccessible(true);
        $property->setValue([]); // Reset the instances array
    }

    // Test for registering a new class
    public function testRegisterClass()
    {
        $className = stdClass::class; // Use stdClass as the test class
        Orbis::register($className); // Register the class

        // Assert that the instance was registered correctly
        $this->assertInstanceOf(stdClass::class, Orbis::instance($className));
    }

    // Test for registering an existing instance
    public function testRegisterInstance()
    {
        $instance = new stdClass(); // Create a new instance of stdClass
        Orbis::register($instance); // Register the existing instance

        // Assert that the registered instance is the same as the original
        $this->assertSame($instance, Orbis::instance(get_class($instance)));
    }

    // Test for attempting to register an existing instance and expecting an exception
    public function testRegisterExistingInstanceThrowsException()
    {
        // Expect an exception when trying to register an existing instance
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("An instance with the key 'stdClass' is already registered.");

        $instance1 = new stdClass(); // Create the first instance
        Orbis::register($instance1); // Register the first instance

        // Attempt to register a second instance with the same key
        $instance2 = new stdClass();
        Orbis::register($instance2);
    }

    // Test for registering a non-existent class and expecting an exception
    public function testRegisterNonExistentClassThrowsException()
    {
        // Expect an exception when trying to register a non-existent class
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Class NonExistentClass does not exist.");

        Orbis::register('NonExistentClass'); // Attempt to register a class that doesn't exist
    }

    // Test for unregistering an instance
    public function testUnregister()
    {
        $className = stdClass::class; // Use stdClass as the test class
        Orbis::register($className); // Register the class

        // Assert that the instance is registered
        $this->assertInstanceOf(stdClass::class, Orbis::instance($className));

        Orbis::unregister($className); // Unregister the instance

        // Assert that the instance is null after unregistering
        $this->assertNull(Orbis::instance($className), "Expected the instance to be null after unregistering.");
    }

    // Test for attempting to unregister a non-existent instance and expecting an exception
    public function testUnregisterNonExistentThrowsException()
    {
        // Expect an exception when trying to unregister a non-existent instance
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Instance with key stdClass does not exist.");

        Orbis::unregister(stdClass::class); // Attempt to unregister an instance that doesn't exist
    }

    // Test for ensuring that the same instance is returned when registered multiple times
    public function testInstanceReturnsExistingInstance()
    {
        $className = stdClass::class; // Use stdClass as the test class
        Orbis::register($className); // Register the class
        $instance1 = Orbis::instance($className); // Get the first instance

        // Get the instance again to ensure the same object is returned
        $instance2 = Orbis::instance($className);

        // Assert that both instances are the same
        $this->assertSame($instance1, $instance2);
    }
}
