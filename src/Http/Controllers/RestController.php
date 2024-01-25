<?php

namespace Sajadsdi\LaravelRestResponse\Http\Controllers;

use Illuminate\Routing\Controller;
use Sajadsdi\LaravelRestResponse\Concerns\RestResponse;

/**
 * Class RestController
 *
 * This class provides a RESTFULL API response structure for Laravel applications.
 *
 * @package Sajadsdi\LaravelRestResponse\Http\Controllers
 */
class RestController extends Controller
{
    use RestResponse;
}
