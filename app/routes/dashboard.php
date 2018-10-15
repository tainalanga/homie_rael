<?php
    $dashboardMW = function ($request, $response, $next) use ($tpl, $templates){
        if(isset($_SESSION['user'])){
            $usuarioController = new Usuario($_SESSION['user']);
            $tpl->addFile("CONTENT", $templates['dashboard/dashboardVazio']);
            $tpl->USUARIO_NOME = $usuarioController->usuario['nome'];
            $tpl->USUARIO_ID   = $usuarioController->usuario['id'];
        }else{
            return $response->withRedirect($this->router->pathFor('landingPage'));
        }

        $response = $next($request, $response);
        return $response;
    };

    $app->get('/dashboard', function ($request, $response) use ($tpl, $templates) {
        $tpl->addFile("CONTEUDO_DASHBOARD", $templates['dashboard/imovel/todosImoveis']);
        $imoveis = new Imoveis();
        foreach($imoveis->imoveis as $imovel){
            $tpl->addFile("IMOVEIS", $templates['dashboard/imovel/card']);
            $tpl->ID = $imovel['id'];
            $tpl->ENDERECO = $imovel['endereco'];
            $tpl->LIMITE_PESSOAS = $imovel['limite_pessoas'];
            $tpl->DESCRICAO = $imovel['descricao'];
            $tpl->block("BLOCK_IMOVEIS");
        }

        $tpl->show();
        return $response;
    })->setName('dashboard')->add($dashboardMW);

    $app->get('/dashboard/casas', function ($request, $response) use ($tpl, $templates) {
        $tpl->addFile("CONTEUDO_DASHBOARD", $templates['dashboard/imovel/casas']);
        $imoveis = new Imoveis();
        foreach($imoveis->imoveis as $imovel){
            if($imovel['tipo'] == 'Casa'){
                $tpl->addFile("IMOVEIS", $templates['dashboard/imovel/card']);
                $tpl->ID = $imovel['id'];
                $tpl->ENDERECO = $imovel['endereco'];
                $tpl->LIMITE_PESSOAS = $imovel['limite_pessoas'];
                $tpl->DESCRICAO = $imovel['descricao'];
                $tpl->block("BLOCK_IMOVEIS");   
            }
        }

        $tpl->show();
        return $response;
    })->setName('dashboard')->add($dashboardMW);

    $app->get('/dashboard/apart', function ($request, $response) use ($tpl, $templates) {
        $tpl->addFile("CONTEUDO_DASHBOARD", $templates['dashboard/imovel/apart']);
        $imoveis = new Imoveis();
        foreach($imoveis->imoveis as $imovel){
            if($imovel['tipo'] == 'Apartamento'){
                $tpl->addFile("IMOVEIS", $templates['dashboard/imovel/card']);
                $tpl->ID = $imovel['id'];
                $tpl->ENDERECO = $imovel['endereco'];
                $tpl->LIMITE_PESSOAS = $imovel['limite_pessoas'];
                $tpl->DESCRICAO = $imovel['descricao'];
                $tpl->block("BLOCK_IMOVEIS");   
            }
        }

        $tpl->show();
        return $response;
    })->setName('dashboard')->add($dashboardMW);

    $app->get('/dashboard/kitnet', function ($request, $response) use ($tpl, $templates) {
        $tpl->addFile("CONTEUDO_DASHBOARD", $templates['dashboard/imovel/kitnet']);
        $imoveis = new Imoveis();
        foreach($imoveis->imoveis as $imovel){
            if($imovel['tipo'] == 'Kitnet'){
                $tpl->addFile("IMOVEIS", $templates['dashboard/imovel/card']);
                $tpl->ID = $imovel['id'];
                $tpl->ENDERECO = $imovel['endereco'];
                $tpl->LIMITE_PESSOAS = $imovel['limite_pessoas'];
                $tpl->DESCRICAO = $imovel['descricao'];
                $tpl->block("BLOCK_IMOVEIS");   
            }
        }

        $tpl->show();
        return $response;
    })->setName('dashboard')->add($dashboardMW);

    $app->get('/dashboard/quartos', function ($request, $response) use ($tpl, $templates) {
        $tpl->addFile("CONTEUDO_DASHBOARD", $templates['dashboard/imovel/quartos']);
        $imoveis = new Imoveis();
        foreach($imoveis->imoveis as $imovel){
            if($imovel['tipo'] == 'Quarto'){
                $tpl->addFile("IMOVEIS", $templates['dashboard/imovel/card']);
                $tpl->ID = $imovel['id'];
                $tpl->ENDERECO = $imovel['endereco'];
                $tpl->LIMITE_PESSOAS = $imovel['limite_pessoas'];
                $tpl->DESCRICAO = $imovel['descricao'];
                $tpl->block("BLOCK_IMOVEIS");   
            }
        }

        $tpl->show();
        return $response;
    })->setName('dashboard')->add($dashboardMW);
    
    $app->get('/dashboard/imovel/ver[/{id:.*}]', function ($request, $response, $args) use ($tpl, $templates) {
        $tpl->addFile("CONTEUDO_DASHBOARD", $templates['dashboard/imovel/verImovel']);
        
        if(!empty($args['id'])){
            $imovel = new Imoveis($args['id']);
            $id = $imovel->imovel['usuario_id'];
            $dono = new Usuario($id);
            $tpl->UNIVERSIDADE = $imovel->universidade['nome'];
            $tpl->DONO = $dono->usuario['nome'];
            $tpl->EMAIL = $dono->usuario['email'];
            $tpl->TELEFONE = $dono->usuario['telefone'];
            $tpl->USRID = $_SESSION['user'];
            $tpl->ID = $args['id'];
            $tpl->ENDERECO = $imovel->imovel['endereco'];
            $tpl->NUMERO = $imovel->imovel['numero'];
            $tpl->LIMITE_PESSOAS = $imovel->imovel['limite_pessoas'];
            $tpl->DESCRICAO = $imovel->imovel['descricao'];
            $tpl->TIPO = $imovel->imovel['tipo'];
            $tpl->VAGAS = $imovel->imovel['vagas'];
        }
        $tpl->show();
    })->add($dashboardMW);

    $app->post('/dashboard/imovel/ver[/{id:.*}]', function ($request, $response, $args) use ($tpl, $templates) {
        $tpl->addFile("CONTEUDO_DASHBOARD", $templates['dashboard/imovel/verImovel']);
        $error = 0;
        if($error == 0){
            $usuarioController = new Usuario();
            if(!empty($args['id'])){
                if($usuarioController->like($_POST)){
                    return $response->withRedirect($this->router->pathFor('dashboard')); 
                }
            }
        }

        $tpl->show();
    })->add($dashboardMW);



    $app->get('/dashboard/imovel/editar[/{id:.*}]', function ($request, $response, $args) use ($tpl, $templates) {
        $tpl->addFile("CONTEUDO_DASHBOARD", $templates['dashboard/imovel/novoImovel']);
        
        if(!empty($args['id'])){
            $imovel = new Imoveis($args['id']);
            $tpl->UNIVERSIDADE = $imovel->imovel['universidades_id'];
            $tpl->ENDERECO = $imovel->imovel['endereco'];
            $tpl->NUMERO = $imovel->imovel['numero'];
            $tpl->LIMITE_PESSOAS = $imovel->imovel['limite_pessoas'];
            $tpl->DESCRICAO = $imovel->imovel['descricao'];
            $tpl->TIPO = $imovel->imovel['tipo'];
            $tpl->ALUGAR = '<a href="../alugar/'.$imovel->imovel['id'].'"><p class="ui button">Ocupar 1 Vaga</button></p>';
        }

        $tpl->show();
    })->add($dashboardMW);

    $app->get('/dashboard/imovel/alugar[/{id:.*}]', function ($request, $response, $args) use ($tpl, $templates) {
        $tpl->addFile("CONTEUDO_DASHBOARD", $templates['dashboard/imovel/novoImovel']);
        $error = 0;
        if($error == 0){
            $imovel = new Imoveis($args['id']);
            if(!empty($args['id'])){
                if($imovel->imovel['vagas']>0){
                    $vagas = $imovel->imovel['vagas'] - 1 ;
                    $imovel->alugar($vagas, $args['id']);
                    return $response->withRedirect($this->router->pathFor('dashboard')); 
                }
                else{

                    $tpl->AVISO = '<script>window.alert("SEM VAGAS");</script>';
                }
            }
        }

        $tpl->show();
    })->add($dashboardMW);


    $app->post('/dashboard/imovel/editar[/{id:.*}]', function ($request, $response, $args) use ($tpl, $templates) {
        $tpl->addFile("CONTEUDO_DASHBOARD", $templates['dashboard/imovel/novoImovel']);
        $error = 0;
        
        foreach($_POST as $input=>$value){
            if(empty($value)){
                $tpl->addFile("MESSAGE", $templates['messages/error']);
                $tpl->MESSAGE_ERROR_TEXT = "Formulário $input Vazio!";
                $tpl->block("BLOCK_MESSAGE");
    
                $error = 1;
            }
        }

        if(empty($_FILES["Foto_Imovel"]["tmp_name"]) && empty($args['id'])){
            $tpl->addFile("MESSAGE", $templates['messages/error']);
            $tpl->MESSAGE_ERROR_TEXT = "Foto vazia!";
            $tpl->block("BLOCK_MESSAGE");

            $error = 1;
        }

        if($_POST['Limite_de_pessoas'] < 2){
            $tpl->addFile("MESSAGE", $templates['messages/error']);
            $tpl->MESSAGE_ERROR_TEXT = "2 é o número máximo de pessoas!";
            $tpl->block("BLOCK_MESSAGE");

            $error = 1;
        }

        if($error == 0){
            $imoveisController = new Imoveis();
            if(empty($args['id'])){
                if($imoveisController->inserir($_POST)){
                    return $response->withRedirect($this->router->pathFor('dashboard')); 
                }
            }else{
                if($imoveisController->editar($_POST, $args['id'])){
                    return $response->withRedirect($this->router->pathFor('dashboard')); 
                }
            }
        }

        $tpl->show();
    })->add($dashboardMW);

    $app->get('/dashboard/meusimoveis/', function ($request, $response) use ($tpl, $templates) {
        $tpl->addFile("CONTEUDO_DASHBOARD", $templates['dashboard/imovel/meusImoveis']);

        $imoveis = new Imoveis();
        $imoveis_encontrados = 0;
        foreach($imoveis->imoveis as $imovel){

            if($imovel['usuario_id'] == $_SESSION['user']){
                $tpl->addFile("IMOVEIS", $templates['dashboard/imovel/meuCard']);
                $tpl->ID = $imovel['id'];
                $tpl->ENDERECO = $imovel['endereco'];
                $tpl->LIMITE_PESSOAS = $imovel['limite_pessoas'];
                $tpl->DESCRICAO = $imovel['descricao'];
                $tpl->EDITAR = '<a href="../imovel/editar/'.$imovel['id'].'"><i class="edit icon" style="float:right;"></i></a>';
                $tpl->block("BLOCK_IMOVEIS");
                $imoveis_encontrados = 1;
            }
        }

        if($imoveis_encontrados == 0){
            $tpl->addFile("MESSAGE", $templates['messages/error']);
            $tpl->MESSAGE_ERROR_TEXT = "Nenhum imóvel encontrado";
            $tpl->block("BLOCK_MESSAGE");
        }

        $tpl->show();
        return $response;
    })->setName('dashboard')->add($dashboardMW);



    $app->get('/dashboard/usuario/editar[/{id:.*}]', function ($request, $response, $args) use ($tpl, $templates) {
        $tpl->addFile("CONTEUDO_DASHBOARD", $templates['dashboard/usuario/editar_perfil']);
        
        if(!empty($args['id'])){
            $usuario = new Usuario($args['id']);
            $tpl->NOME = $usuario->usuario['nome'];
            $tpl->EMAIL = $usuario->usuario['email'];
            $tpl->SENHA = $usuario->usuario['senha'];
            $tpl->GENERO = $usuario->usuario['genero'];
            $tpl->TELEFONE = $usuario->usuario['telefone'];
            $tpl->NASCIMENTO = $usuario->usuario['data_nascimento'];
            $tpl->PREFERENCIAS = $usuario->usuario['preferencias'];

        }

        $tpl->show();
    })->add($dashboardMW);

    $app->post('/dashboard/usuario/editar[/{id:.*}]', function ($request, $response, $args) use ($tpl, $templates) {
        $tpl->addFile("CONTEUDO_DASHBOARD", $templates['dashboard/usuario/editar_perfil']);
        $error = 0;
        
        foreach($_POST as $input=>$value){
            if(empty($value)){
                $tpl->addFile("MESSAGE", $templates['messages/error']);
                $tpl->MESSAGE_ERROR_TEXT = "Formulário $input Vazio!";
                $tpl->block("BLOCK_MESSAGE");
    
                $error = 1;
            }
        }
        
        if($error == 0){
            $usuarioController = new Usuario();    
            if($usuarioController->editar($_POST, $args['id'])){
                return $response->withRedirect($this->router->pathFor('dashboard')); 
            }
            }
        $tpl->show();
    })->add($dashboardMW);