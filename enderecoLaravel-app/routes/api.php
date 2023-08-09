<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EnderecoController;

Route::get('/enderecos',[EnderecoController::class,'Buscar']);
Route::post('/endereco',[EnderecoController::class,'Inserir']);
Route::put('/endereco/{id}',[EnderecoController::class,'Atualizar']);
Route::get('/endereco/{filtro}',[EnderecoController::class,'BuscarPorCepOuLogradouro']);
Route::delete('/endereco/{id}',[EnderecoController::class,'Deletar']);
