<?php 
    class Imoveis extends DB
    {
        public $imovel;
        public $imoveis;

        function __construct($id = null){
            parent::__construct();
            
            if(isset($id)){
                $this->imovel = $this->medoo->select("imovel", '*',[
                    "id" => $id
                ])[0];
                $this->universidade = $this->medoo->select("universidades", '*',[
                    "id" => $this->imovel['universidades_id']
                ])[0];
            }else{
                $this->imoveis = $this->medoo->select("imovel", '*');
            }
        }
    
        public function inserir($imovel)
        {
            $this->medoo->insert("imovel", [
                "numero"            => $imovel['Número'], 
                "endereco"          => $imovel['Endereço'], 
                "descricao"         => $imovel['Descrição'], 
                "tipo"              => $imovel['Tipo'],
                "limite_pessoas"    => $imovel['Limite_de_pessoas'],
                "usuario_id"        => $_SESSION['user'], 
                "universidades_id"  => $imovel['Universidade'],
                "vagas"             => $imovel['Limite_de_pessoas'] 
            ]);

            move_uploaded_file($_FILES['Foto_Imovel']['tmp_name'], "uploads/" . $this->medoo->id() . '.jpg');

            return true;
        }

        public function editar($imovel, $id)
        {
            $this->medoo->update("imovel", [
                "numero"            => $imovel['Número'], 
                "endereco"          => $imovel['Endereço'], 
                "descricao"         => $imovel['Descrição'], 
                "limite_pessoas"    => $imovel['Limite_de_pessoas'],
                "usuario_id"        => $_SESSION['user'], 
                "universidades_id"  => $imovel['Universidade'],  
                "tipo"              => $imovel['Tipo']
            ], [
                'id' => $id
            ]);

            return true;
        }


        public function alugar($vagas, $id)
        {
            $this->medoo->update("imovel", [
                "vagas"            => $vagas, 
            ], [
                'id' => $id
            ]);

            return true;
        }
    //     public function buscarUniversidade($imovel, $id)
    //     {
    //         $this->imovel = $this->medoo->select("imovel", '*',[
    //                 "id" => $id
    //             ])[0];
    }