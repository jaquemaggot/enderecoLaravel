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

    public function BuscarPorCepOuLogradouro($filtro)
    {
        $endereco = Endereco::where('cep', $filtro)
            ->orWhere('logradouro',$filtro)
            ->first();
        if ($endereco == null) {
            throw new Exception('Endereço não encontrado verifique os dados informados.');
        }
        return $endereco;
    }

    public function Inserir(Request $request)
    {
        $endereco = new Endereco;

        $endereco->cep = $request->cep;
        $endereco->logradouro = $request->logradouro;
        $endereco->numero = $request->numero;
        $endereco->bairro = $request->bairro;
        $endereco->complemento = $request->complemento;
        $endereco->cidade = $request->cidade;
        $endereco->estado = $request->estado;

        $endereco->save();

        return $endereco;
    }

    public function Atualizar($id, Request $request)
    {
        try {
            $endereco = $this->ValidarId($id);

            $endereco->cep = $request->cep;
            $endereco->logradouro = $request->logradouro;
            $endereco->numero = $request->numero;
            $endereco->bairro = $request->bairro;
            $endereco->complemento = $request->complemento;
            $endereco->cidade = $request->cidade;
            $endereco->estado = $request->estado;

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

    private function ValidarId($id)
    {
        $endereco = Endereco::find($id);
        if ($endereco == null) {
            throw new Exception('Esse número de registro Id não existe na base de dados.');
        } else {
            return $endereco;
        }
    }
}
