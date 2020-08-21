<?php
    $acao = (isset($_POST['acao']) ? $_POST['acao'] : "");

    if ($acao == "efetuar_login"){

        $usuario = (isset($_POST['usuario']) ? $_POST['usuario'] : "");
        $senha = (isset($_POST['senha']) ? $_POST['senha'] : "");

        if ($usuario && $senha && !empty($usuario) && !empty($senha)){
            include 'classes/conexao.php';

            $query = $conexao->prepare("SELECT * FROM usuarios WHERE usuario = :usuario");
            $query->bindValue(':usuario', $usuario);

            if ($query->execute()){
                if ($query->rowCount() > 0){
                    $dados = $query->fetch(PDO:: FETCH_OBJ);

                    if (password_verify($senha, $dados->senha)){
                        session_start();

                        $_SESSION['id'] = $dados->id;
                        $_SESSION['nome'] = $dados->nome;
                        $_SESSION['usuario'] = $dados->usuario;
                        $_SESSION['senha'] = $dados->senha;
                        $_SESSION['status'] = $dados->status;

                        header('Location: index.php');
                    }else{
                       header('Location: formlogin.php?err=1');
                    }
                }else{
                    header('Location: formlogin.php?err=2');
                }
            }else{
                header('Location: formlogin.php?err=3');
            }
        }
    }else{
        header('Location: formlogin.php');
    }
?>
