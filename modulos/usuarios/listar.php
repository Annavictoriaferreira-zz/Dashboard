<?php
$acao = (isset($_REQUEST['acao']) ? $_REQUEST['acao']:'');

if ($acao == 'excluir' && $_GET['id']){
    $id = (isset($_GET['id']) ? $_GET['id'] : '');

    $excluir = $conexao->prepare('DELETE FROM usuarios WHERE id = :id');
    $excluir->bindValue(":id", $id);

    if ($excluir->execute()){
        echo "O dado foi excluido";
    }
    else{
        echo "O dado não foi excluido";
    }
}else if ($acao == 'editar_usuario'){
    $id = (isset($_GET['id']) ? $_GET['id'] : '');
    $nome = (isset($_POST['nome']) ? $_POST['nome'] : '');
    $usuario = (isset($_POST['usuario']) ? $_POST['usuario'] : '');
    $senha = (isset($_POST['senha']) ? $_POST['senha'] : '');

    if ($senha) {
        if ($usuario){
            $update = $conexao->prepare("UPDATE usuarios SET nome = :nome, usuario = :usuario WHERE id = :id");
            $update->bindValue(':nome', $nome);
            $update->bindValue(':usuario', $usuario);
            $update->bindValue(':id', $id);

            if ($update->execute()) {
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
        }

        else{
            $query = $conexao->prepare('SELECT * FROM usuarios WHERE usuario = :usuario');
            $query->bindValue('usuario', $usuario);
            $query->execute();

            if ($query->rowCount() > 0) {
                echo '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Erro!</h4>
                Usuário já cadastrado!
              </div>';
            } else {
                $update = $conexao->prepare("UPDATE usuarios SET nome = :nome, usuario = :usuario WHERE id = :id");
                $update->bindValue(':nome', $nome);
                $update->bindValue(':usuario', $usuario);
                $update->bindValue(':id', $id);

                if ($update->execute()) {
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
            }
        }
    }

}

if ($acao != 'editar') {

    ?>

    <section class="content-header">
        <h1>
            Usuarios
            <small>Listar</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Lista de Usuarios</h3>


                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Nome</th>
                                <th class="text-center">Usuario</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $select = $conexao->query("SELECT * FROM usuarios");
                            $select->execute();

                            while ($dados = $select->fetch(PDO::FETCH_OBJ)) {
                                ?>

                                <tr>
                                    <td class="text-center"><?php echo $dados->id ?></td>
                                    <td><?php echo $dados->nome ?></td>
                                    <td class="text-center"><?php echo $dados->usuario ?></td>
                                    <td class="text-center">
                                        <?php echo $dados->status ? "<span class='label label-success'>Ativo</span>" : "<span class='label label-danger'>Inativo</span>"?>
                                    </td>
                                    <td class="text-center">
                                        <a href="?mod=usuarios&pg=listar&acao=editar&id=<?php echo $dados->id ?>"
                                           class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i></a>
                                        <a onclick="if (!confirm('Você realmente desja excluir esse dado?')){return false}"
                                           href="?mod=usuarios&pg=listar&acao=excluir&id=<?php echo $dados->id ?>"
                                           class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>

                                <?php
                            }
                            ?>

                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>

            </div>
        </div>
    </section>
    <?php
}else {
    $id = (isset($_GET['id']) ? $_GET['id'] : '');
    $dados = $conexao->prepare('SELECT * FROM usuarios WHERE id = :id');
    $dados->bindValue(':id', $id);

    $dados->execute();

    $smartphone = $dados->fetch(PDO:: FETCH_OBJ);


    ?>
    <section class="content-header">
        <h1>
            Usuarios
            <small>Editar</small>
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
                        <h3 class="box-title">Editar Usuarios</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="" method="post">
                        <input type="hidden" name="acao" value="editar_usuario"/>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="nome">Nome do Usuario</label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite o nome do usuario:" required VALUE="<?php echo $smartphone->nome?>">
                            </div>
                            <div class="form-group">
                                <label>Usuario</label>
                                <input type="text" class="form-control"  name="usuario" placeholder="Digite o usuario:" required value="<?php echo $smartphone->usuario?>">
                            </div>

                            <div class="form-group">
                                <label for="modelo">Digite sua senha para continuar</label>
                                <input type="password" class="form-control"  name="senha" placeholder="Digite sua senha:" required >
                            </div>


                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer text-right">
                            <a href="?mod=usuarios&pg=listar" class="btn btn-primary"> <i class="fa fa-arrow-left"></i> Voltar </a>
                            <button type="submit" class="btn btn-warning"><i class="fa fa-pencil"></i> Editar Usuario </button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    <?php
}
?>
