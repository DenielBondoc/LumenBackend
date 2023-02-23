<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

Header('Access-Control-Allow-Origin: *'); //for allow any domain, insecure
Header('Access-Control-Allow-Headers: *'); //for allow any headers, insecure
Header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE'); //method allowed

class Controller extends BaseController
{
    //
}
