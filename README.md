# Simple http request library

This library provides simple way to access for request data.

## Table of contents
- [Example](#example)
- [Available methods](#available-methods)
- [Methods of request object](#methods-of-request-object)
  - [set](#set)
  - [int](#int)
  - [string](#string)
  - [get](#get)
  - [count](#count)
  - [toJson](#tojson)
  - [toArray](#toarray)
  - [delete](#delete)
  - [has](#has)
  - [keys](#keys)
- [License](#license)

## Example

```php
// $_POST = ['id' => 1, 'name' => 'Valera']
use Sivka\Request;

echo Request::post('name'); // Valera

$post = Request::post();

echo $post->name; // Valera

echo $post->not_defined_var; // NULL

```

## Available methods

```php
Request::get(); // $_GET
Request::post(); // $_POST
Request::session(); // $_SESSION
Request::cookie(); // $_COOKIE
Request::server(); // $_SERVER
Request::headers(); // http headers
```

All methods has same signature.
Every method returns request object.
If method called with argument, it returns value of specified key or NULL if key does not exists.

## Methods of request object

### set

Sets value for specified key

```php
$post = Request::post();
$post->set('id', 2);
// or directly
$post->id = 2;

// array maybe used
$newData = ['surname' => 'Smith', 'age' => 33];
$post->set($newData);
```

### int
Returns value converted to integer or 0
```php
echo $post->int('id'); // 2
```

### string
Returns value converted to string or empty string
```php
echo $post->string('id'); // '2'
```

### get
Returns value if exists or null.
```php
echo $post->get('id'); // 2
// or simply
echo $post->id; // 2
```

Methods `int`, `string` and `get` has second optional argument specified default value if key does not exists in request object
```php
echo $post->get('notDefined', 'define_me'); // define_me
```

### count
Returns count of values
```php
$post->count();
```

### toJson
Returns json representation of request object
```php
$post->toJson();
```

### toArray
Returns request object as array
```php
$post->toArray();
```

### delete
Delete key from request object
```php
$post->delete('id');
```

### has
Check if key exists in request object
```php
echo $post->has('name'); // true
```

### keys
Returns array of keys from request object
```php
$post->keys();
```

What's profit of this? No need to use such construction:
```php
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
```


## License

This project is licensed under the [MIT License](LICENSE.md)