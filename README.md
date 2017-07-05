# Fluid Validation Rules builders for Laravel

Use fluid-style syntax to build Laravel validation rules

## Usage

Install the ```saritasa/laravel-fluid-validation``` package:

```bash
$ composer require saritasa/laravel-fluid-validation
```

**Example**:
```php
$rules = [
    'id' => Rule::int()->required()->toString(),
    'name' => Rule::string()->required()->minLength(3)->toString(),
    'email' => Rule::string()->required()->email()->toArray()
]
```

## Advantages
* Strong typing
* Intellisence for available rules and parameters (if you use smart IDE, like PHPStorm)
* Hints about mistypings (if you use smart IDE, like PHPStorm)

## Available classes

### Rules
Root of your rule builder.

## Contributing

1. Create fork
2. Checkout fork
3. Develop locally as usual. **Code must follow [PSR-1](http://www.php-fig.org/psr/psr-1/), [PSR-2](http://www.php-fig.org/psr/psr-2/)**
4. Update [README.md](README.md) to describe new or changed functionality. Add changes description to [CHANGES.md](CHANGES.md) file.
5. When ready, create pull request

## Resources

* [Bug Tracker](http://github.com/saritasa/php-roles-simple/issues)
* [Code](http://github.com/saritasa/php-roles-simple)
* [Changes History](CHANGES.md)
* [Authors](http://github.com/saritasa/php-roles-simple/contributors)
