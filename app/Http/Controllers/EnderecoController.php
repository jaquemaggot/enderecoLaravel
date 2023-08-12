<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Endereco;
use Exception;

class EnderecoController extends Controller
{
    public function Buscar()
    {
        $endereco = Endereco::all();
        return $endereco;
    }

    public function BuscarPorCepOuLogradouro(Request $request)
    {

        $filtro = $request->query('filtro');
        $endereco = Endereco::where('cep', $filtro)
            ->orWhere('logradouro','like','%'.$filtro.'%')->get();
        return $endereco;
    }

    public function Inserir(Request $request)
    {
        try{
        $this->ValidarCep($request->cep);
        $endereco = new Endereco;
        $endereco->cep = $request->cep;
        $endereco->logradouro = $request->logradouro;
        $endereco->bairro = $request->bairro;
        $endereco->cidade = $request->cidade;
        $endereco->uf = $request->uf;

        $endereco->save();

        return $endereco;
        }catch(Exception $ex){
            return response()->json(['message'=>$ex->getMessage()],400);
        }
    }

    public function Atualizar($id, Request $request)
    {
        try {
            $endereco = $this->ValidarId($id);

            $endereco->cep = $request->cep;
            $endereco->logradouro = $request->logradouro;
            $endereco->bairro = $request->bairro;
            $endereco->cidade = $request->cidade;
            $endereco->uf = $request->uf;

            $endereco->save();

            return $endereco;
        } catch (Exception $ex) {
            return response()->json(['message'=>$ex->getMessage()],400);
        }
    }

    public function Deletar($id)
    {
        try {
            $endereco = $this->ValidarId($id);
            $endereco->delete();
        } catch (Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], 400);
        }
    }

    public function buscarPorId($id){
        $endereco = Endereco::find($id);
        return $endereco;
    }

    private function ValidarId($id)
    {
        $endereco = Endereco::find($id);
        if ($endereco == null) {
            throw new Exception('Esse número de registro Id não existe na base de dados.');
        } else {
            return $endereco;
        }
    }

    private function ValidarCep($cep){
        $endereco = Endereco::where('cep', $cep)->first();
        if ($endereco != null) {
            throw new Exception('Esse cep já está cadastrado');
        }
    }
}
