<?php
    $acao = (isset($_REQUEST['acao']) ? $_REQUEST['acao']:'');

    if($acao === 'cadastrar_aparelho') {
        $nome = (isset($_POST['nome']) ? $_POST['nome'] : '');
        $modelo = (isset($_POST['modelo']) ? $_POST['modelo'] : '');
        $marca = (isset($_POST['marca']) ? $_POST['marca'] : '');
        $imei = (isset($_POST['imei']) ? $_POST['imei'] : '');

        $insert = $conexao->prepare("INSERT INTO smartphones(nome, modelo, imei, id_marca) VALUES (:nome, :modelo, :imei, :id_marca)");
        $insert->bindValue(':nome', $nome);
        $insert->bindValue(':modelo', $modelo);
        $insert->bindValue(':id_marca', $marca);
        $insert->bindValue(':imei', $imei);

        if ($insert->execute()) {
            echo '
                <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Sucesso!</h4>
                Smartphone cadastrado com sucesso.
              </div>
            ';
        } else {
            echo '
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Erro!</h4>
                Não foi possível cadastrar o smartphone.
              </div>
            ';
        }
    }

    $marcas = $conexao->query("SELECT * FROM marcas");
    $marcas->execute();

    $dados = $marcas->fetchAll();
?>
<section class="content-header">
    <h1>
        Smartphones
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
                    <h3 class="box-title">Cadastrar Smartphones</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="" method="post">
                    <input type="hidden" name="acao" value="cadastrar_aparelho"/>
                    <div class="box-body">
                        <div class="form-group">
                            <label for="nome">Nome do Aparelho</label>
                            <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite o nome do aparelho:" required>
                        </div>
                        <div class="form-group">
                            <label for="modelo">Modelo</label>
                            <input type="text" class="form-control" id="modelo" name="modelo" placeholder="Digite o modelo:" required>
                        </div>
                        <div class="form-group">
                            <label for="marca">Marca</label>
                            <select class="form-control" id="marca" name="marca">
                                <?php
                                foreach ($dados as $key => $value){
                                    echo "<option value='".$value["id"]."'>".$value["nome"]."</option>";
                                }

                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="imei">IMEI</label>
                            <input type="text" class="form-control" id="imei" name="imei" placeholder="Digite o IMEI:" required>

                        </div>

                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer text-right">
                        <button type="submit" class="btn btn-primary">Cadastrar Smartphone <i class="fa fa-plus"></i></button>
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>






