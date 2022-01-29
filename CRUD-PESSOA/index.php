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
        if(isset($_POST['nome'])){ // clicou no botão para cadastrar ou editar
            
            //------------------------EDITAR ------------------------------
            if(isset($_GET['id_up']) && !empty($_GET['id_up'])){

                $id_update = addslashes($_GET['id_up']);
                $nome = addslashes($_POST['nome']);
                $telefone = addslashes($_POST['telefone']);
                $email = addslashes($_POST['email']);
                
                if(!empty($nome) && !empty($telefone) && !empty($email))
                {
                    $p->atualizarDados($id_update, $nome, $telefone, $email);
                    header("location:index.php");
                }
            //---------------------------CADASTRAR----------------------------
            }else{

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
        }
    ?>
    <?php
         if(isset($_GET['id_up'])){
            $id_update = addslashes($_GET['id_up']);
            $res = $p->buscardadosPessoa($id_update);
         }
    ?>
    <section id="esquerda">
        <form method="POST">
            <h2>Cadastrar Pessoa</h2>
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome" 
            value=" <?php if(isset($res)){ echo $res['nome'];}?>">
            <label for="telefone">Telefone</label>
            <input type="text" name="telefone" id="telefone" value="<?php if(isset($res)){echo $res['telefone'];} ?> ">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?php if(isset($res)){echo $res['email'];}?> ">
            <input type="submit" value=" <?php if(isset($res)){ echo "Atualizar";}else{ echo "Cadastrar";} ?> ">
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
                            <td>
                                <a href="index.php?id_up=<?php echo $dados[$i]['id'];?>">Editar</a>
                                <a href="index.php?id=<?php echo $dados[$i]['id'];?>">Excluir</a>
                            </td>
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

<?php
    if(isset($_GET['id'])){
        $id_pessoa = addslashes($_GET['id']);
        $p->excluirPessoa($id_pessoa);
        header("location: index.php");
    }
?>