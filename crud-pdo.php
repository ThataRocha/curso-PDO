<?php
    //---------------------------------------------------conexão-----------------------------------------------------
    //pdo é orientado objeto, sendo assim tem que criar uma variavel e instancia o objeto pdo
    //qual é o banco
    //dbname
    //host
    //usuario e senha
    try {
        $pdo = new PDO("mysql:dbname=CRUDPDO;host=localhost","root","");    
    }catch(PDOException $e){
        echo "Erro com banco de dados:".$e->getMessage();
    }
    catch(Exception $e){
        echo "Erro generico".$e->getMessage();
    }
    // ----------------------------------------------INSERT ---------------------------------------------------------
    //1 opção
    //Usamos o prepare quando precisamos passar algum parametro e depois substituir.
    
    $res = $pdo->prepare("INSERT INTO pessoa(nome, telefone, email) VALUES (:n, :t, :e)");
    $res->bindValue(":n","Thais");
    $res->bindValue(":t","00000000");
    $res->bindValue(":e","teste@gmail.com");
    $res->execute();

     //2 opção
    $pdo->query("INSERT INTO pessoa(nome, telefone, email) VALUES ('Mirian', '0000000', 'teste@hotmail.com')");

    //--------------------------------------------------Delete -----------------------------------------------------
    //1 opção
    $cmd = $pdo->prepare("DELETE FROM pessoa WHERE id = :id");
    $id = 4;
    $cmd->bindValue(":id","$id");
    $cmd->execute();

     //2 opção
    $cmd = $pdo->query("DELETE FROM pessoa WHERE id='3'");
    
    //--------------------------------------------------update ------------------------------------------------------
     //1 opção
    $cmd = $pdo->prepare("UPDATE pessoa SET email = :e WHERE id = :id");
    $cmd->bindValue(":e","Miriam@gmail.com");
    $cmd->bindValue(":id",1);
    $cmd->execute();

     //2 opção
    $cmd = $pdo->query("UPDATE pessoa SET email='teste@gmail.com' WHERE id='1'");
    //--------------------------------------------------Select ------------------------------------------------------

    $cmd = $pdo->prepare("SELECT * FROM pessoa WHERE id= :id");
    $cmd->bindValue(":id","1");
    $cmd->execute();
    $resultado = $cmd->fetch(PDO::FETCH_ASSOC);
    //transforma a informação que veio do banco em um array
    // A fetch é quando vem uma unica linha do banco de dados

    foreach($resultado as $key => $value){
    echo $key.": ".$value."<br>";
}
    //foi utilizada na aula 4 de PHP PDO
    echo "<pre>";
    $resultado = $cmd->fetch(PDO::FETCH_ASSOC);
    print_r($resultado);
    echo "</pre>";
 
    //O fatchAll é quando for  mais que um registro/linha do banco de dados
    $cmd->fetchAll();
?>