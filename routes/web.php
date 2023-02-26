<?php

use App\Lib\Integrations\HeadHunterIntegrator\CalculateSalary;
use App\Lib\Integrations\HeadHunterIntegrator\HeadHunter;
use App\Lib\Integrations\HeadHunterIntegrator\HeadHunterApiClient;
use App\Lib\Integrations\HeadHunterIntegrator\HeadHunterIntegrationManager;
use App\Lib\Integrations\HeadHunterIntegrator\HeadHunterRepository;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/admin');
});
