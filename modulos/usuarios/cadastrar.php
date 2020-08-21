<?php
    $acao = (isset($_REQUEST['acao']) ? $_REQUEST['acao'] : '');

    if($acao == 'cadastrar_usuario'){
        $nome = (isset($_POST['nome']) ? $_POST['nome'] : '');
        $usuario = (isset($_POST['usuario']) ? $_POST['usuario'] : '');
        $senha = (isset($_POST['senha']) ? $_POST['senha'] : '');
        $confirme_senha = (isset($_POST['confirme_senha']) ? $_POST['confirme_senha'] : '');

        $query = $conexao->prepare('SELECT * FROM usuarios WHERE usuario = :usuario');
        $query->bindValue('usuario', $usuario);
        $query->execute();

        if ($query->rowCount() > 0){
            echo'<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Erro!</h4>
                Usuário já cadastrado!
              </div>';
        }else {


            if ($senha == $confirme_senha) {
                $senha = password_hash($senha, 3);

                $insert = $conexao->prepare('INSERT INTO usuarios(nome, usuario, senha, status)VALUES(:nome, :usuario, :senha, 1)');
                $insert->bindValue(':nome', $nome);
                $insert->bindValue(':usuario', $usuario);
                $insert->bindValue(':senha', $senha);

                if ($insert->execute()) {
                    echo '
                <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Sucesso!</h4>
                Usuário editado com sucesso.
              </div>
            ';
                } else {
                    echo '
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Erro!</h4>
                Não foi possível editar o usuário.
              </div>
            ';
                }
            } else {
                echo '
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Erro!</h4>
                As senhas não coincidem
              </div>
            ';
            }
        }
    }

?>
<section class="content-header">
    <h1>
        Usuarios
        <small>Cadastrar</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Cadastrar Usuarios</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="" method="post">
                    <input type="hidden" name="acao" value="cadastrar_usuario"/>
                    <div class="box-body">
                        <div class="form-group">
                            <label for="nome">Nome do Usuario</label>
                            <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite o nome do usuario:" required>
                        </div>
                        <div class="form-group">
                            <label for="usuario">Usuario</label>
                            <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario:" required>
                        </div>

                        <div class="form-group">
                            <label for="senha">Senha</label>
                            <input type="password" class="form-control" id="senha" name="senha" placeholder="Digite a senha do usuario:" required>

                        </div>

                        <div class="form-group">
                            <label for="confirm_senha">Confirme a senha</label>
                            <input type="password" class="form-control" id="senha" name="confirme_senha" placeholder="Digite a senha novamente:" required>

                        </div>

                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer text-right">
                        <button type="submit" class="btn btn-primary">Cadastrar Usuario <i class="fa fa-plus"></i></button>
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
