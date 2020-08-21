<?php
$acao = (isset($_REQUEST['acao']) ? $_REQUEST['acao']:'');

if ($acao == 'excluir' && $_GET['id']){
    $id = (isset($_GET['id']) ? $_GET['id'] : '');

    $excluir = $conexao->prepare('DELETE FROM marcas WHERE id = :id');
    $excluir->bindValue(":id", $id);

    if ($excluir->execute()){
        echo " <div class=\"alert alert-success alert-dismissible\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
                <h4><i class=\"icon fa fa-check\"></i> Sucesso!</h4>
                Marca excluída com sucesso.
              </div>";
    }
    else{
        echo " <div class=\"alert alert-danger alert-dismissible\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
                <h4><i class=\"icon fa fa-check\"></i> Erro!</h4>
                Não foi possível excluir a marca.
              </div>";
    }
}else if ($acao == 'editar_marca'){
    $id = (isset($_GET['id']) ? $_GET['id'] : '');
    $nome = (isset($_POST['nome']) ? $_POST['nome'] : '');


    $update = $conexao->prepare("UPDATE marcas SET nome = :nome WHERE id = :id");
    $update->bindValue(':nome', $nome);
    $update->bindValue(':id', $id);

    if ($update->execute()){
        echo '
                <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Sucesso!</h4>
                Marca editada com sucesso.
              </div>
            ';
    }
    else{
        echo '
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Erro!</h4>
                Não foi possível editar a marca.
              </div>
            ';
    }
}

if ($acao != 'editar') {

    ?>

    <section class="content-header">
        <h1>
           Marcas
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
                        <h3 class="box-title">Lista de Marcas</h3>


                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="col-lg-9">Nome</th>
                                <th class="text-center">Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $select = $conexao->query("SELECT * FROM marcas");
                            $select->execute();

                            while ($dados = $select->fetch(PDO::FETCH_OBJ)) {
                                ?>

                                <tr>
                                    <td class="text-center"><?php echo $dados->id ?></td>
                                    <td><?php echo $dados->nome ?></td>
                                    <td class="text-center">
                                        <a href="?mod=marcas&pg=listar&acao=editar&id=<?php echo $dados->id ?>"
                                           class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i></a>
                                        <a onclick="if (!confirm('Você realmente desja excluir esse dado?')){return false}"
                                           href="?mod=marcas&pg=listar&acao=excluir&id=<?php echo $dados->id ?>"
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
    $dados = $conexao->prepare('SELECT * FROM marcas WHERE id = :id');
    $dados->bindValue(':id', $id);

    $dados->execute();

    $smartphone = $dados->fetch(PDO:: FETCH_OBJ);

    $marcas = $conexao->query("SELECT * FROM marcas");
    $marcas->execute();
    $marcas = $marcas->fetchAll();

    ?>
    <section class="content-header">
        <h1>
            Marcas
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
                        <h3 class="box-title">Editar Marca</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="" method="post">
                        <input type="hidden" name="acao" value="editar_marca"/>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="nome">Nome do Aparelho</label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite o nome do aparelho:" required VALUE="<?php echo $smartphone->nome?>">
                            </div>

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer text-right">
                            <a href="?mod=marcas&pg=listar" class="btn btn-primary"> <i class="fa fa-arrow-left"></i> Voltar </a>
                            <button type="submit" class="btn btn-warning"><i class="fa fa-pencil"></i> Editar Marca </button>
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
