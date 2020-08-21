<?php
$acao = (isset($_REQUEST['acao']) ? $_REQUEST['acao']:'');

if($acao === 'cadastrar_marca') {
    $marca = (isset($_POST['marca']) ? $_POST['marca'] : '');

    $insert = $conexao->prepare("INSERT INTO marcas(nome) VALUES (:marca)");

    $insert->bindValue(':marca', $marca);

    if ($insert->execute()) {
        echo '
                <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Sucesso!</h4>
                  Marca cadastrado com sucesso.
              </div>
            ';
    } else {
        echo '
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Erro!</h4>
                Não foi possível cadastrar a marca.
              </div>
            ';
    }
}

?>
<section class="content-header">
    <h1>
        Marcas
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
                    <h3 class="box-title">Cadastrar Marcas</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="" method="post">
                    <input type="hidden" name="acao" value="cadastrar_marca"/>
                    <div class="box-body">
                        <div class="form-group">
                            <label for="nome">Nome da Marca</label>
                            <input type="text" class="form-control" id="nome" name="marca" placeholder="Digite o nome da marca:" required>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer text-right">
                        <button type="submit" class="btn btn-primary">Cadastrar Marca <i class="fa fa-plus"></i></button>
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>







