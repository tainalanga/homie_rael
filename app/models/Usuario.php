<?php 
    class Usuario extends DB
    {
        public $usuario;

        function __construct($id = null){
            parent::__construct();

            if(isset($id) && $id != null){
                $this->usuario = $this->medoo->select("usuarios", '*',[
                    "id" => $id
                ])[0];
            }
        }

        public function logar($id = null, $email = null, $senha = null)
        {
            if($id == null && $email != null && $senha != null){
                
                $id = $this->medoo->select("usuarios", 'id',[
                    "email" => $email,
                    "senha" => $senha,
                ])[0];
            }

            $this->__construct($_SESSION['user'] = $id);
            return true;
        }

        public function logout()
        {
            if(isset($_SESSION['user']))
                unset($_SESSION['user']);
            return true;
        }

        public function checarLogin()
        {
            if(isset($_SESSION['user'])){
                return $this->medoo->has("usuarios", [
                    "AND" => [
                        "id" => $_SESSION['user'],
                    ]
                ]);
            }else{
                return false;
            }
        }

        public function inserir($usuario)
        {
            $this->medoo->insert("usuarios", [
                "nome"              => $_POST['Nome'], 
                "email"             => $_POST['Email'], 
                "senha"             => $_POST['Senha'], 
                "genero"            => $_POST['Genero'],
                "telefone"          => $_POST['Telefone'], 
                "preferencias"      => $_POST['Preferencias'], 
                "data_nascimento"   => $_POST['Data_de_nascimento']        
            ]);

            move_uploaded_file($_FILES['Foto_de_Perfil']['tmp_name'], "uploads/" . $this->medoo->id() . '.jpg');

            return $this->logar($this->medoo->id());
        }

        public function like($usuario)
        {
            $this->medoo->insert("imovel_usuario_assoc", [
                "usuario_id"              => $_POST['Usuario_id'], 
                "imovel_id"             => $_POST['Imovel_id'], 
                    
            ]);

            return true;
        }


        public function editar($usuario, $id)
        {
            $this->medoo->update("usuarios", [
                "nome"              => $usuario['Nome'], 
                "email"             => $usuario['Email'], 
                "senha"             => $usuario['Senha'], 
                "genero"            => $usuario['Genero'],
                "telefone"          => $usuario['Telefone'], 
                "preferencias"      => $usuario['Preferencias'], 
                "data_nascimento"   => $usuario['Data_de_nascimento']
            ], [
                'id' => $id
            ]);

            return true;
        }
    }