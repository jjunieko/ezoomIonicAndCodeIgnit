<?php


namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use Exception;
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");

class Produtos extends ResourceController
{
    // private $produtoModel;
    public $produtoModel = '\App\Models\ProdutosModel';
    protected $format    = 'json';
   
    
    // private $produtoModel = new \App\Models\ProdutosModel(); // para codeigniter anteriores a essa versão
    private $token = '123456789ezoom';


    public function __construct()
    {
        $this->produtoModel = model(ProdutosModel::class);
        
        Header('Access-Control-Allow-Origin: *'); //for allow any domain, insecure
        Header('Access-Control-Allow-Headers: *'); //for allow any headers, insecure
        Header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE'); //method allowed
    }

    private function _validaToken() 
    {
        return $this->request->getHeaderLine('token') == $this->token;
    }

    //retorna todos os produtos
    public function list()
    {
      $data = $this->produtoModel->findAll();

      return $this->response->setJSON($data);
    }


    //POST 
    public function create()
    {
        $response = [];

        //valida token
        if($this->_validaToken() == true){
            //pega dados que vieram no body da request para salvar
            $newProduto['nome'] = $this->request->getPost('nome');
            $newProduto['valor'] = $this->request->getPost('valor');

            try {
                //code...
                if($this->produtoModel->insert($newProduto)){
                    $response = [
                        'response' => 'success',
                        'msg' => 'Produto adicionado com sucesso',
                    ];
                }else{
                    $response = [
                        'response' => 'error',
                        'msg' => 'Error ao salvar produto',
                        'errors' => $this->produtoModel->errors()
                    ];
                }
            } catch (Exception $th) {
                $response = [
                    'response' => 'error',
                    'msg' => 'Error ao salvar produto',
                    'errors' => [
                        'exception' => $th->getMessage()
                    ]
                ];
            }
        }else{
          $response = [
            'response' => 'error',
            'msg' => 'Token invalido'
          ];
        }

        return $this->response->setJson($response);
    }

    // update product
   public function update($id = null)
   {
       $model = model(ProdutosModel::class);
       $input = $this->request->getRawInput();
       $data = [
           'nome' => $this->request->getVar('nome'),
           'valor' => $this->request->getVar('valor'),
       ];
       $model->update($id, $data);
       $response = [
           'status'   => 200,
           'error'    => null,
           'messages' => [
               'success' => 'Data Updated'
           ]
       ];
       return $this->response->setJson($response);
    //    return $this->respond($response);
   }

    //Remove
    public function delete($id = NULL)
    {
        $this->produtoModel->delete($id);
        return $this->respond(['status' => 'success']);
    }

}