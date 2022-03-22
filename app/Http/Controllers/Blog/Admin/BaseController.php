<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Controllers\Blog\BaseController as GuestBaseController;
use Illuminate\Http\Request;

/**
 * Базовый контроллер для всех контоллеров управления
 * блогом в панели администрирования
 *
 * Class BaseController
 * @package App\Http\Controllers\Blog\Admin
 */
abstract class BaseController extends GuestBaseController
{
    /**
     * BaseController constructor.
     */
    public function __construct(){

    }
}
