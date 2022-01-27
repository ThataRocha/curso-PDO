<?php
    require_once 'classe-pessoa.php';
    $p = new Pessoa("crudpdo","localhost","root","");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css">
    <title>CRUD</title>
</head>
<body>
    <?php
        if(isset($_POST['nome'])){
            $nome = addslashes($_POST['nome']);
            $telefone = addslashes($_POST['telefone']);
            $email = addslashes($_POST['email']);
            
            if(!empty($nome) && !empty($telefone) && !empty($email))
            {
                if(!$p->cadastrarPessoa($nome, $telefone, $email)){
                   echo "Email já cadastrado!";               
                }
            }else{
                echo "Preencha todos os campos!";
            }
        }
    ?>
    <section id="esquerda">
        <form method="POST">
            <h2>Cadastrar Pessoa</h2>
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome">
            <label for="telefone">Telefone</label>
            <input type="text" name="telefone" id="telefone">
            <label for="email">Email</label>
            <input type="email" name="email" id="email">
            <input type="submit" value="Cadastrar">
        </form>
    </section>
    <section id="direita">
        <table>
            <tr id="titulo">
                <td>Nome</td>
                <td>Telefone</td>
                <!-- Fazer o campo email ocupar duas colunas!-->
                <td colspan="2">Email</td>
            </tr>
            <?php
                $dados = $p->buscarDados();
                if(count($dados) > 0 ){ // se tem pessoas cadastradas no banco
                    for($i=0; $i< count ($dados); $i++){
                        echo "<tr>";
                        foreach ($dados[$i] as $k => $v){
                            if($k != "id"){
                                echo"<td>".$v."</td>";
                            }
                        }//fim do foreach
                        ?>
                            <!-- Botões de editar e excluir por linha -->
                            <td><a href="#">Editar</a> <a href="#">Excluir</a></td>
                        <?php
                        echo "</tr>";
                    }//fim do for
                }else
                {
                    echo "Nenhuma pessoa cadastrada!";
                }
            ?> 
        </table>
    </section>
</body>
</html>