<?php

namespace App\Http\Controllers;

use App\Models\stores;
use App\Models\Client;
use App\Models\stores_client;
use Illuminate\Http\Request;


class StoreController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function find($store_id)
    {
        $store = stores::query()->find($store_id);
        if ($store != null) {
            return $store;
        } 
        else {
            return response()
                ->json([
                    'data' => [
                        'message' => 'Estabelecimento não encontrado'
                    ]
                ], 404);
        }
    }

    public function ListClients($store_id)
    {

        $clients_store = stores_client::query()->findMany($store_id);
        $id = [];
        foreach ($clients_store as $client) {
            array_push($id, $client->client_id);
        }
        $clients = Client::query()->findMany($id);
        if ($clients->count() > 0) {
            return $clients;
        } 
        else {
            return response()
                ->json([
                    'data' => [
                        'message' => 'Clientes não encontrado'
                    ]
                ], 404);
        }
    }
    public function FindClient($store_id, $client_id)
    {

        $clients = stores_client::query()->findMany($store_id);
        foreach ($clients as $client) {
            if ($client->client_id == $client_id) {
                return Client::query()->find($client_id);
            }
        }
        return response()
            ->json([
                'data' => [
                    'message' => 'Cliente não encontrado'
                ]
            ], 404);
    }

    public function PostClients($store_id, Request $requestBody)
    {
        $email = $requestBody->get('email');
        $nome = $requestBody->get('name');
        $client = Client::query()->where('email', $email)
            ->where('name', $nome)
            ->first();
        if (!$client) {
            $newClient = Client::query()->updateOrCreate(['email' => $email, 'name' => $nome]);
            stores_client::query()->create(['store_id' => $store_id, 'client_id' => $newClient->id]);
            return $newClient;
        }
        else if ($client) {
            if(stores_client::query()->where('store_id', $store_id)->where('client_id', $client->id)->first()){
                return response()
                ->json([
                    'data' => [
                        'message' => 'Usuário já relacionado com o estabelecimento informado'
                    ]
                ]);
            }
            stores_client::query()->create(['store_id' => $store_id, 'client_id' => $client->id]);
            return $client;
        }
        return response()
            ->json([
                'data' => [
                    'message' => 'Usuário não Pode ser cadastrado'
                ]
                ], 500);
    }
    public function UpdClient($store_id, $client_id, Request $requestBody)
    {
        $email = $requestBody->get('email');
        $nome = $requestBody->get('name');
        $client = $this->FindClient($store_id, $client_id);
        $client = $client->update(['email' => $email, 'name' => $nome]);
            
        if ($client) {
            return response()
            ->json([
                'data' => [
                    'message' => 'Usuário Atualizado'
                ]
            ]);
        }
        return response()
            ->json([
                'data' => [
                    'message' => 'Usuário não Pode ser Atualizado'
                ]
                ], 500);
    }
}
