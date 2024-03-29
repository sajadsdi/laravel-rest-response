![Laravel REST Response](https://sajadsdi.github.io/images/Laravel-RESTful-Response.jpg)


# Laravel REST Response
a PHP package that simplifies the generation of clean and consistent responses for RESTful APIs in Laravel applications.

## Features
- **Versioning Support:** The package allows you to include API version information in your responses.
- **HTTP Status Codes:** Easily set and customize HTTP status codes for different response scenarios.
- **Common Response Methods:** Predefined methods for common responses such as create, update, delete, not found, forbidden, unauthorized, and bad request.
- **Easy Integration:** Seamlessly integrate the package with your Laravel controllers for quick and standardized API responses.
- **Base Request:** Use `BaseRequest` for all request classes to integrate validation or authorization response errors with the package’s response.
- **CRUD Operations** Use `CrudApi` trait to provide a standard way of handling CRUD operations.

## Installation

You can install this library using Composer. If you haven't already set up Composer for your project, you can do so by following the [official Composer installation guide](https://getcomposer.org/doc/00-intro.md).

Once Composer is installed, run the following command to install Laravel REST Response:

```bash
composer require sajadsdi/laravel-rest-response
```

## Usage

It is recommended to extend the `RestController` class in your base controller, to allowing all controllers that inherit from it to have access to the RESTful methods. This approach provides a convenient way to handle API responses consistently across your application.

### Extending in Base Controller

In the Laravel application, there is a base controller by default, which you can find at the address below.

```bash
App\Http\Controllers\Controller
```
open Controller.php or your custom base controller.

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
```
you need change the BaseController to RestController like below.

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use SajadSdi\LaravelRestResponse\Http\Controllers\RestController;

class Controller extends RestController
{
    use AuthorizesRequests, ValidatesRequests;
}
```
### Using Rest methods in Controllers
now you can use Rest methods in your controllers like below.
```php
<?php

namespace App\Http\Controllers\Banner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Your logic here
        $data = ['key' => 'value',...];
        return $this->response($data);//you can set custom message
    }

    /**
     * Store a new resource.
     */
    public function store(Request $request)
    {
        // Your logic here
        $data = ['key' => 'value',...];
        return $this->createResponse($data,'The banner was created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function single($id)
    {
        // Your logic here
        $data = ['key' => 'value',...];
        return $this->response($data);//you can set custom message
    }

    /**
     * Update the specified resource.
     */
    public function update($id,Request $request)
    {
        // Your logic here
        $data = ['key' => 'value',...];
        //response if banner $id found and updated 
        return $this->updateResponse($data);//you can set custom message
        
        //response if banner $id not found
        return $this->notFoundResponse('banner id not found');
    }

    /**
     * Remove the specified resource.
     */
    public function destroy($id)
    {
        // Your logic here
        //response if banner $id found and deleted
        return $this->deleteResponse();
        //response if user unauthorized access
        return $this->unauthorizedResponse();//you can set custom message and errors
        //response if user forbidden access
        return $this->forbiddenResponse();//you can set custom message and errors
    }
}
```
### Customizing api version
you can customize api version in your controller or base controller like below.
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use SajadSdi\LaravelRestResponse\Http\Controllers\RestController;

class Controller extends RestController
{
    use AuthorizesRequests, ValidatesRequests;
    
    /**
     * Get the version of the api.
     *
     * @return string
     */
    protected function getVersion(): string
    {
        return '1.0.1';
    }
}
```
you can also customize api version in any controller by defining getVersion method.

### Implement BaseRequest
extends `BaseRequest` for all request classes to integrate all response with package response.
```php
<?php

namespace App\Http\Requests\Auth;

use Sajadsdi\LaravelRestResponse\Http\Requests\BaseRequest;

class LoginRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        //you can set message for authorize error before return false.
        if(!is_admin){
            $this->setAuthorizeError('you cant see!');
            return false;
        }
        
        return true;
    }
    //your methods...
}
```

### Use CRUD methods and repository
ensure that your repository class implements the CrudRepositoryInterface. This interface must define the methods for create, read, update, delete, and index.
Here’s an example of how your repository should look:

```php
namespace App\Repositories;

use Sajadsdi\LaravelRestResponse\Contracts\CrudRepositoryInterface;

class YourModelRepository implements CrudRepositoryInterface {
    // Implement the methods
}
```
#### Integrate into a Controller
After setting up your repository, you can use the CrudApi trait in any controller to manage your resources.

Example:
```php
namespace App\Http\Controllers;

use Sajadsdi\LaravelRestResponse\Concerns\CrudApi;

class YourController extends Controller {
    use CrudApi;

    public function __construct(YourModelRepository $repository) {
        $this->repository = $repository;
    }
    
    // Now, you have access to createOperation, readOperation, and other methods
    // for example we implement store function with createOperation function
    public function store(YourCreateRequest $request)
    {
        return $this->createOperation($request->->validated());
    }
}
```
The `CrudApi` trait provides you with the following methods:

- createOperation($validated_data): Create a new resource.
- readOperation($validated_id): Retrieve a specific resource by its ID.
- updateOperation($validated_id, $validated_data): Update a specific resource by its ID.
- deleteOperation($validated_id): Delete a specific resource by its ID.
- indexOperation($search, $filter, $sort, $perPage): Retrieve a list of resources, with optional search criteria, filtering, sorting, and pagination.

Each operation will automatically handle successful responses and failures (e.g., bad requests or not found errors).


## Json Response
all responses are in json format, and they have the same data structure like below.
```json
{
    "data": [...],
    "message": "your message",
    "errors": [...],// if you set errors, otherwise an empty array.
    "status": 200,// status code
    "version": "1.0.0"//or your custom version
}
```


### Contributing

We welcome contributions from the community to improve and extend this library. If you'd like to contribute, please follow these steps:

1. Fork the repository on GitHub.
2. Clone your fork locally.
3. Create a new branch for your feature or bug fix.
4. Make your changes and commit them with clear, concise commit messages.
5. Push your changes to your fork on GitHub.
6. Submit a pull request to the main repository.

### Reporting Bugs and Security Issues

If you discover any security vulnerabilities or bugs in this project, please let us know through the following channels:

- **GitHub Issues**: You can [open an issue](https://github.com/sajadsdi/laravel-rest-response/issues) on our GitHub repository to report bugs or security concerns. Please provide as much detail as possible, including steps to reproduce the issue.

- **Contact**: For sensitive security-related issues, you can contact us directly through the following contact channels

### Contact

If you have any questions, suggestions, financial, or if you'd like to contribute to this project, please feel free to contact the maintainer:

- Email: thunder11like@gmail.com

We appreciate your feedback, support, and any financial contributions that help us maintain and improve this project.

## License

This library is open-source software licensed under the MIT License.

