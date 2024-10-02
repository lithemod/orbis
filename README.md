# Lithe Orbis

✨ **Lithe Orbis** is a powerful class for managing class instances easily and efficiently in PHP!

## Installation

You can install **Lithe Orbis** using Composer. Run the following command in your terminal:

```bash
composer require lithemod/orbis
```

## Usage

### Registering an Instance

To register an instance of a class, you can use the `register` method. Here's an example:

```php
use Lithe\Orbis\Orbis;

class MyClass {
    public function sayHello() {
        return "Hello, World!";
    }
}

// Register a new instance without a key
Orbis::register(MyClass::class);

// Get the registered instance
$instance = Orbis::instance(MyClass::class);
echo $instance->sayHello(); // Output: Hello, World!
```

#### Registering with a Key

You can also register an instance using a custom key:

```php
$myObject = new MyClass();
Orbis::register($myObject, 'myCustomKey');

// Get the instance using the custom key
$instance = Orbis::instance('myCustomKey');
echo $instance->sayHello(); // Output: Hello, World!
```

### Unregistering an Instance

If you need to remove a registered instance, you can use the `unregister` method:

```php
Orbis::unregister(MyClass::class);
```

### Getting an Instance with Unregistration

The `instance` method has a second optional parameter that, when set to `true`, will unregister the instance upon returning it. Here's how it works:

```php
// Register the instance
Orbis::register(MyClass::class);

// Get and unregister the instance
$instance = Orbis::instance(MyClass::class, true);
echo $instance->sayHello(); // Output: Hello, World!

// The instance is now unregistered
```

### Common Errors

- **Class not registered**: If you try to get an instance that hasn’t been registered, an error will be thrown.
- **Instance already registered**: Attempting to register an instance with an existing key will throw an error.

## Contribution

Contributions are welcome! Feel free to submit a pull request or open an issue.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.