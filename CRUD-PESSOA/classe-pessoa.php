<?php
    class Pessoa{

        private $pdo;
        // 6 funções
        // ponto de partida do codigo
        public function __construct($dbname, $host, $user, $senha)
        {
            try{
                $this->pdo = new PDO("mysql:dbname=".$dbname.";host=".$host,$user,$senha);
            }
            catch(PDOException $e){
                echo "Erro com banco de dados:".$e->getMessage();
                exit();
            }
            catch(Exception $e){
                echo "Erro generico:".$e->getMessage();
            }
        }
        // função para buscar o dados e colocar no canto direiro da tela.
        public function buscarDados(){
            $cmd = $this->pdo->query("SELECT * FROM pessoa ORDER BY nome");
            //recebendo o arreio em cmd e convertendo e mandando para variavel res.
            $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }
        //Função de cadastrar pessoa no banco de dados
        public function cadastrarPessoa($nome, $telefone, $email){
            //Antes de cadastrar temos que verificar se já existe o cadastro do email
            $cmd = $this->pdo->prepare("SELECT id FROM pessoa WHERE email = :e");
            $cmd->bindValue(":e", $email);
            $cmd->execute();
            if($cmd->rowCount() > 0) //email já existente.
            {
                return false;
            }else{ // email não cadastrado
                $cmd = $this->pdo->prepare("INSERT INTO pessoa (nome, telefone, email) VALUES (:n, :t, :e)");
                $cmd->bindValue(":n", $nome);
                $cmd->bindValue(":t", $telefone);
                $cmd->bindValue(":e", $email);
                $cmd->execute();
                return true;
            }
        }
        public function excluirPessoa($id){
            $cmd = $this->pdo->prepare("DELETE FROM pessoa WHERE id=:id");
            $cmd->bindValue(":id", $id);
            $cmd->execute();
        }
    
    
    }
?>