<?php

use Pecee\SimpleRouter\SimpleRouter as Router;
use App\Controllers\AuthController;
use App\Controllers\FoodItemController;
use App\Controllers\ResidentController;
use App\Controllers\ResidentMealPlanController;
use App\Middlewares\Auth;

/**
 * Define API routes with prefix 'api'.
 */
Router::group(['prefix' => 'api'], function() {
    Router::post('login', [AuthController::class, 'login']);
    Router::group(['middleware' => Auth::class], function() {
        Router::group(['prefix' => 'food-items'], function() {
            Router::get('', [FoodItemController::class, 'list']);
            Router::post('add', [FoodItemController::class, 'store']);
            Router::post('residents-consumable', [FoodItemController::class, 'getByResidentConsumable']);
            Router::post('upload', [FoodItemController::class, 'createWithUpload']);
        });
        Router::group(['prefix' => 'residents'], function() {
            Router::get('', [ResidentController::class, 'list']);
            Router::post('add', [ResidentController::class, 'store']);
            Router::post('upload', [ResidentController::class, 'createWithUpload']);
        });
        Router::group(['prefix' => 'resident-meal-plans'], function() {
            Router::get('', [ResidentMealPlanController::class, 'list']);
            Router::post('add', [ResidentMealPlanController::class, 'store']);
        });
    });
});