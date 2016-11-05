<?php
namespace Controllers;

/*
|--------------------------------------------------------------------------
| Base Controller
|--------------------------------------------------------------------------
|
| The BaseController is the parent of all controllers and controllers MUST be
| extends the BaseController, however, it will receive some bonus feature from
| BaseController
|
*/
class BaseController {

    public function message()
    {
        return 'Parent Controller';
    }
}
