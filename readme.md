# Token

Manages random tokens for password resets and other one-time actions

### Installation

  * Add the service provider to `config/app.php`:
    * `NZTim\Token\TokenServiceProvider::class,`
  * Run `php artisan token-pkg:migration` then `php artisan migrate` to add the Token database table

### Usage

  * Tokens are handled via `NZTim\Token\TokenRepo`, which can be instantiated by the container
  * Token parameters:
    * **Reference**: integer ID of the object referred to by the token, e.g. User ID
    * **Type**: string determining the type of the token
    * **Expires**: integer determining how many minutes the token will remain valid for, null (forever) is default
  * `TokenRepo::new(int $ref, string $type, int $expires = null)` returns a random 40-character code
  * `TokenRepo::find(string $code, string $type)` returns the reference ID or null if not found
  * `TokenRepo::remove(string $code, string $type)` deletes the token associated with the code (if found)
  