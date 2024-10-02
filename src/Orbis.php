<?php

namespace Lithe\Orbis;

class Orbis
{
    /**
     * @var array Array to hold class instances
     */
    private static array $instances = [];

    /**
     * Create or register an instance of the specified class.
     *
     * @param string|object $class The name of the class or an instance of the class.
     * @param string|null $key Optional key to register the instance.
     * @throws \Exception If the class does not exist.
     */
    public static function register($class, ?string $key = null): void
    {
        // Check if the argument is an instance of a class
        if (is_object($class)) {
            $className = get_class($class);
            if ($key === null) {
                $key = $className; // Use class name as key if no key is provided
            }

            // Prevent overwriting an existing instance
            if (isset(self::$instances[$key])) {
                throw new \Exception("An instance with the key '{$key}' is already registered.");
            }

            self::$instances[$key] = $class; // Register the existing instance
            return;
        }

        // Check if class exists
        if (!class_exists($class)) {
            throw new \Exception("Class {$class} does not exist.");
        }

        // Use class name as key if no key is provided
        if ($key === null) {
            $key = $class;
        }

        // Prevent overwriting an existing instance
        if (isset(self::$instances[$key])) {
            throw new \Exception("An instance with the key '{$key}' is already registered.");
        }

        // Create a new instance if it doesn't exist
        self::$instances[$key] = new $class();
    }

    /**
     * Get the instance of a specified class.
     *
     * @param string $key The key of the class instance.
     * @param bool $unregister If true, unregister the instance and return it.
     * @return object|null Returns the instance of the class or null if not found.
     */
    public static function instance(string $key, bool $unregister = false)
    {
        // Obtém a instância
        $instance = self::$instances[$key] ?? null;

        // Se o unregister for true e a instância existir, chama o método unregister
        if ($unregister && $instance !== null) {
            self::unregister($key);
            return $instance; // Retorna a instância após desmontar
        }

        return $instance; // Retorna a instância ou null se não encontrado
    }

    /**
     * Unregister a class instance.
     *
     * @param string $key The key of the class instance.
     * @throws \Exception If the class does not exist.
     */
    public static function unregister(string $key): void
    {
        if (!isset(self::$instances[$key])) {
            throw new \Exception("Instance with key {$key} does not exist.");
        }

        unset(self::$instances[$key]); // Remove the instance of the class
    }
}