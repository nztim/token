# Token

Manages random tokens for password resets and other one-time actions

### Installation

  * Add the service provider to `config/app.php`:
    * `NZTim\Token\TokenServiceProvider::class,`
  * Run `php artisan token:migration` then `php artisan migrate` to add the Token database table

### Usage

  * Tokens are handled via `NZTim\Token\TokenRepo`, which can be instantiated by the container
  * `new(int $ref, string $type = null)` returns a new Token object with the following methods:
    * `public function code() : string` returns the 40-character code
    * `public function ref() : int` returns the integer reference, typically the ID of the associated model
    * `public function type(): string` returns the type of code, e.g. `password-reset`. 
    * Token is an interface with these methods defined, the instance returned is an Eloquent object TokenDb
  * `find(string $code, string $type = null)` returns the Token object or null
  * `remove(Token $token)` deletes the token


