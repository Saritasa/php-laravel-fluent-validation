# Fluent Validation Rules builders for Laravel

Use fluent-style syntax to build [Laravel validation rules](https://laravel.com/docs/5.4/validation#available-validation-rules)

**Example**:
```php
$rules = [
    'id' => Rule::int()->required(),
    'name' => Rule::string()->required()->minLength(3)->toString(),
    'email' => Rule::string()->required()->email()->toArray()
]
```
## Advantages
* Strong typing
* Intellisence for available rules and parameters (if you use smart IDE, like PHPStorm)
* Hints about mistypings (if you use smart IDE, like PHPStorm)

### Examples
**Inline documentation:**

![Inline documentation](docs/inline_docs.png)

**Inellisence:**

![Intelisence](docs/intellisence.png)

## Installation

Install the ```saritasa/laravel-fluent-validation``` package:

```bash
$ composer require saritasa/laravel-fluent-validation
```
Add the FluentValidationServiceProvider in ``config/app.php``:

```php
'providers' => array(
    // ...
    Saritasa\Laravel\Validation\FluentValidationServiceProvider::class,
)
```
*Note:* You can omit service provider registration, but then you must call
*->toString()* or *->toArray()* on each builder.
If service provider is registered, manual casting of rule to string or array
is not necessary.


## Available classes

### \Saritasa\Laravel\Validation\Rule
Root of your rule builder.

## Contributing

1. Create fork
2. Checkout fork
3. Develop locally as usual. **Code must follow [PSR-1](http://www.php-fig.org/psr/psr-1/), [PSR-2](http://www.php-fig.org/psr/psr-2/)**
4. Update [README.md](README.md) to describe new or changed functionality. Add changes description to [CHANGES.md](CHANGES.md) file.
5. When ready, create pull request

## Resources

* [Bug Tracker](http://github.com/saritasa/php-laravel-fluent-validation/issues)
* [Code](http://github.com/saritasa/php-laravel-fluent-validation)
* [Changes History](CHANGES.md)
* [Authors](http://github.com/saritasa/php-laravel-fluent-validation/contributors)
