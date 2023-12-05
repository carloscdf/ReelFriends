<?php 
    class MySQL{
        const MYSQL_HOST = "localhost";
        const MYSQL_USER = "root";
        const MYSQL_PASSWORD = "";
        const MYSQL_DB_NAME = "banco_reelfriends";
        private $PDO;

        function __construct()
        {
            try {
                $this->PDO = new PDO('mysql:host=' . MySQL::MYSQL_HOST . ';dbname=' . MySQL::MYSQL_DB_NAME, MySQL::MYSQL_USER, MySQL::MYSQL_PASSWORD);
                $this->PDO->exec("set names utf8");
            } catch (PDOException $e) {
                echo 'Erro ao conectar com o MySQL:' . $e->getMessage();
            }
        }

        function pesquisaEmailUsuario($email){
            $search = $email;
            $sql = "SELECT * FROM usuario WHERE email_usuario LIKE :s";
            $stmt = $this->PDO->prepare($sql);    //prepara
            $stmt->bindParam(':s', $search);    //vincula
            $result = $stmt->execute();    //executa
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if($rows == null){
                return null;
            } else {
                return $rows[0];
            }
        }

        function pesquisaNomeUsuario($username){
            $search = $username;   
            $sql = "SELECT * FROM usuario WHERE nome_usuario LIKE :s";
            $stmt = $this->PDO->prepare($sql);    //prepara
            $stmt->bindParam(':s', $search);    //vincula
            $result = $stmt->execute();    //executa
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rows;
        }

        function pesquisaIdUsuario($id){
            $search = $id;   
            $sql = "SELECT * FROM usuario WHERE idusuario LIKE :s";
            $stmt = $this->PDO->prepare($sql);    //prepara
            $stmt->bindParam(':s', $search);    //vincula
            $result = $stmt->execute();    //executa
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rows[0];
        }

        function cadastraUsuario($username, $email, $senha){
            $sql = "INSERT into usuario(nome_usuario, email_usuario, senha_usuario) VALUES(:nome, :email, :senha)";

            $stmt = $this->PDO->prepare($sql);    //prepara
            $stmt->bindParam(':nome', $username);   //vincula
            $stmt->bindParam(':email', $email);     //vincula
            $stmt->bindParam(':senha', $senha);     //vincula

            $result = $stmt->execute();     //executa

            if(!$result){
                var_dump($stmt->errorInfo());
                    exit;
                }
            else{
                echo $stmt->rowCount()." linhas inseridas";
                session_start();
                $_SESSION["usuario"] = $email; //salva na session o email do usuário criado
                header("Location: feed.php");
            }
        }

        function pesquisaProducoes(){
            $sql = "SELECT * FROM producao";
            $stmt = $this->PDO->prepare($sql);    //prepara
            $result = $stmt->execute();    //executa
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rows;
        }

        function pesquisaIdProducao($id){
            $search = $id;
            $sql = "SELECT idproducao, titulo_producao, sinopse_producao, DATE_FORMAT(dt_lancamento_producao, '%d/%m/%Y') AS data_formatada, genero_idgenero, categoria_idcategoria, diretor_iddiretor FROM producao WHERE idproducao LIKE :s";
            $stmt = $this->PDO->prepare($sql);    //prepara
            $stmt->bindParam(':s', $search);    //vincula
            $result = $stmt->execute();    //executa
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rows[0];
        }

        function pesquisaTituloProducao($titulo, $diretor){
            $iddiretor = $this->pesquisaNomeDiretor($diretor)["iddiretor"];

            $sql = "SELECT * FROM producao p WHERE p.titulo_producao = :t AND p.diretor_iddiretor = :d";
            $stmt = $this->PDO->prepare($sql);    //prepara
            $stmt->bindParam(':t', $titulo);    //vincula
            $stmt->bindParam(':d', $iddiretor);    //vincula
            $result = $stmt->execute();    //executa
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rows[0];
        }

        function verificaProducao($titulo, $diretor){
            $sql = "SELECT * FROM producao p WHERE p.diretor_iddiretor = $diretor ";
            $stmt = $this->PDO->prepare($sql);    //prepara
            $result = $stmt->execute();    //executa
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if($rows != null){

                $cont = 0;

                foreach($rows as $producao){
                    if($producao["titulo_producao"] == $titulo){
                        $cont++;
                    }
                }

                if($cont == 0){
                    return true;
                } else {
                    return false;
                }

            } else {
                return true;
            }
        }

        function cadastraProducao($titulo, $sinopse, $dtlancamento, $genero, $categoria, $diretor){
            $sql = "INSERT into producao(titulo_producao, sinopse_producao, dt_lancamento_producao, genero_idgenero, categoria_idcategoria, diretor_iddiretor) VALUES(:titulo, :sinopse, :dtlancamento, :genero, :categoria, :diretor)";

            $stmt = $this->PDO->prepare($sql);    //prepara
            $stmt->bindParam(':titulo', $titulo);   //vincula
            $stmt->bindParam(':sinopse', $sinopse);     //vincula
            $stmt->bindParam(':dtlancamento', $dtlancamento);     //vincula
            $stmt->bindParam(':genero', $genero);     //vincula
            $stmt->bindParam(':categoria', $categoria);     //vincula
            $stmt->bindParam(':diretor', $diretor);     //vincula

            $result = $stmt->execute();     //executa

            if(!$result){
                var_dump($stmt->errorInfo());
                    exit;
                }
            else{
                echo $stmt->rowCount()." linhas inseridas";
                session_start();
                header("Location: feed.php");
            }
        }

        function pesquisaDiretores(){
            $sql = "SELECT * FROM diretor";
            $stmt = $this->PDO->prepare($sql);    //prepara
            $result = $stmt->execute();    //executa
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rows;
        }

        function pesquisaIdDiretor($id){
            $search = $id;   
            $sql = "SELECT * FROM diretor WHERE iddiretor LIKE :s";
            $stmt = $this->PDO->prepare($sql);    //prepara
            $stmt->bindParam(':s', $search);    //vincula
            $result = $stmt->execute();    //executa
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rows[0]["nome_diretor"];
        }

        function pesquisaNomeDiretor($nome){
            $search = $nome;   
            $sql = "SELECT * FROM diretor WHERE nome_diretor LIKE :s";
            $stmt = $this->PDO->prepare($sql);    //prepara
            $stmt->bindParam(':s', $search);    //vincula
            $result = $stmt->execute();    //executa
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rows[0];
        }
        function pesquisaCategorias(){
            $sql = "SELECT * FROM categoria";
            $stmt = $this->PDO->prepare($sql);    //prepara
            $result = $stmt->execute();    //executa
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rows;
        }

        function pesquisaIdCategoria($id){
            $search = $id;
            $sql = "SELECT * FROM categoria WHERE idcategoria LIKE :s";
            $stmt = $this->PDO->prepare($sql);    //prepara
            $stmt->bindParam(':s', $search);    //vincula
            $result = $stmt->execute();    //executa
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rows[0]["descricao_categoria"];
        }

        function pesquisaGeneros(){
            $sql = "SELECT * FROM genero";
            $stmt = $this->PDO->prepare($sql);    //prepara
            $result = $stmt->execute();    //executa
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rows;
        }

        function pesquisaIdGenero($id){
            $search = $id;
            $sql = "SELECT * FROM genero WHERE idgenero LIKE :s";
            $stmt = $this->PDO->prepare($sql);    //prepara
            $stmt->bindParam(':s', $search);    //vincula
            $result = $stmt->execute();    //executa
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rows[0]["descricao_genero"];
        }

        function cadastraAvaliacao($userEmail, $idProducao, $nota){
            $idusuario = $this->pesquisaEmailUsuario($userEmail)["idusuario"];

            $sql = "INSERT into usuario_avalia_producao(usuario_idusuario, producao_idproducao, nota) VALUES(:usuario, :producao, :nota)";

            $stmt = $this->PDO->prepare($sql);    //prepara
            $stmt->bindParam(':usuario', $idusuario);   //vincula
            $stmt->bindParam(':producao', $idProducao);     //vincula
            $stmt->bindParam(':nota', $nota);     //vincula

            $result = $stmt->execute();     //executa

            if(!$result){
                var_dump($stmt->errorInfo());
                    exit;
                }
            else{
                echo "Avaliação registrada com sucesso";
            }
        }

        function pesquisaAvaliacoes($idProducao){
            $search = $idProducao;
            $sql = "SELECT * FROM usuario_avalia_producao WHERE producao_idproducao LIKE :s";
            $stmt = $this->PDO->prepare($sql);    //prepara
            $stmt->bindParam(':s', $search);    //vincula
            $result = $stmt->execute();    //executa
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rows;
        }

        function pesquisaNumeroAvaliacoes($idProducao){
            $search = $idProducao;
            $sql = "SELECT COUNT(*) FROM usuario_avalia_producao WHERE producao_idproducao LIKE :s";
            $stmt = $this->PDO->prepare($sql);    //prepara
            $stmt->bindParam(':s', $search);    //vincula
            $result = $stmt->execute();    //executa
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rows[0]['COUNT(*)'];
        }

        function pesquisaAvaliacaoUsuario($userEmail, $idProducao){
            $idusuario = $this->pesquisaEmailUsuario($userEmail)["idusuario"];

            $sql = "SELECT * FROM usuario_avalia_producao WHERE usuario_idusuario = :u AND producao_idproducao LIKE :p";
            $stmt = $this->PDO->prepare($sql);    //prepara
            $stmt->bindParam(':u', $idusuario);    //vincula
            $stmt->bindParam(':p', $idProducao);    //vincula
            $result = $stmt->execute();    //executa
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rows[0]["nota"];
        }

        function atualizaAvaliacao($userEmail, $idProducao, $novaNota){
            $idusuario = $this->pesquisaEmailUsuario($userEmail)["idusuario"];

            $sql = "UPDATE banco_reelfriends.usuario_avalia_producao
            SET nota = $novaNota
            WHERE usuario_idusuario = $idusuario AND producao_idproducao = $idProducao";

            $stmt = $this->PDO->prepare($sql);    //prepara
            $result = $stmt->execute();    //executa

            if(!$result){
                var_dump($stmt->errorInfo());
                    exit;
                }
            else{
                echo "Nota alterada para $novaNota estrelas!";
            }
        }

        function verificaAvaliacao($userEmail, $idProducao){
            $idusuario = $this->pesquisaEmailUsuario($userEmail)["idusuario"];

            $sql = "SELECT * FROM usuario_avalia_producao WHERE usuario_idusuario LIKE :u AND producao_idproducao = :p";
            $stmt = $this->PDO->prepare($sql);    //prepara
            $stmt->bindParam(':u', $idusuario);    //vincula
            $stmt->bindParam(':p', $idProducao);    //vincula
            $result = $stmt->execute();    //executa
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if($rows == null){
                return false;
            } else {
                return true;
            }
        }

        function pesquisaComentarios($idProducao){
            $search = $idProducao;
            $sql = "SELECT * FROM comentario WHERE producao_idproducao LIKE :s";
            $stmt = $this->PDO->prepare($sql);    //prepara
            $stmt->bindParam(':s', $search);    //vincula
            $result = $stmt->execute();    //executa
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rows;
        }

        function cadastraComentario($userEmail, $idProducao, $comentario){
            $idusuario = $this->pesquisaEmailUsuario($userEmail)["idusuario"];

            $sql = "INSERT into comentario(usuario_idusuario, producao_idproducao, conteudo_comentario) VALUES(:usuario, :producao, :comentario)";

            $stmt = $this->PDO->prepare($sql);    //prepara
            $stmt->bindParam(':usuario', $idusuario);   //vincula
            $stmt->bindParam(':producao', $idProducao);     //vincula
            $stmt->bindParam(':comentario', $comentario);     //vincula

            $result = $stmt->execute();     //executa

            if(!$result){
                var_dump($stmt->errorInfo());
                    exit;
                }
            else{
                echo "Avaliação registrada com sucesso";
            }
        }

        function apagarComentario($idComentario){
            $sql = "DELETE FROM comentario WHERE idcomentario = $idComentario";
            $stmt = $this->PDO->prepare($sql);    //prepara
            $result = $stmt->execute();     //executa
            
            if(!$result){
                var_dump($stmt->errorInfo());
                    exit;
                }
            else{
                echo "Comentário apagado com sucesso";
            }
        }

        function cadastraSeguidor($idSeguidor, $idSeguido){
            $sql = "INSERT into usuario_segue_usuario(usuario_idusuario, usuario_idusuario1) VALUES(:seguidor, :seguido)";

            $stmt = $this->PDO->prepare($sql);    //prepara
            $stmt->bindParam(':seguidor', $idSeguidor);   //vincula
            $stmt->bindParam(':seguido', $idSeguido);     //vincula

            $result = $stmt->execute();     //executa

            if(!$result){
                var_dump($stmt->errorInfo());
                    exit;
                }
            else{
                header("Location: pagina-usuario.php?user=$idSeguido");
            }
        }

        function apagarSeguimento($idSeguidor, $idSeguido){ //O nome ruim da função é só pra manter o padrão
            $sql = "DELETE FROM usuario_segue_usuario WHERE usuario_idusuario = $idSeguidor AND usuario_idusuario1 = $idSeguido";
            $stmt = $this->PDO->prepare($sql);    //prepara
            $result = $stmt->execute();     //executa
            
            if(!$result){
                var_dump($stmt->errorInfo());
                    exit;
                }
            else{
                header("Location: pagina-usuario.php?user=$idSeguido");
            }
        }

        function verificaSeguidor($idSeguidor, $idSeguido){
            $sql = "SELECT * FROM usuario_segue_usuario WHERE usuario_idusuario = $idSeguidor AND usuario_idusuario1 = $idSeguido";
            $stmt = $this->PDO->prepare($sql);    //prepara
            $result = $stmt->execute();    //executa
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if($rows == null){
                return true;
            } else {
                return false;
            }
        }

        function pesquisaNumeroSeguidores($idSeguido){
            $search = $idSeguido;
            $sql = "SELECT COUNT(*) FROM usuario_segue_usuario WHERE usuario_idusuario1 LIKE :s";
            $stmt = $this->PDO->prepare($sql);    //prepara
            $stmt->bindParam(':s', $search);    //vincula
            $result = $stmt->execute();    //executa
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rows[0]['COUNT(*)'];
        }

        function pesquisaNumeroSeguimentos($idSeguidor){
            $search = $idSeguidor;
            $sql = "SELECT COUNT(*) FROM usuario_segue_usuario WHERE usuario_idusuario LIKE :s";
            $stmt = $this->PDO->prepare($sql);    //prepara
            $stmt->bindParam(':s', $search);    //vincula
            $result = $stmt->execute();    //executa
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rows[0]['COUNT(*)'];
        }

        function cadastraFavorito($idusuario, $idProducao){
            $sql = "INSERT into usuario_favorita_producao(usuario_idusuario, producao_idproducao) VALUES(:usuario, :producao)";

            $stmt = $this->PDO->prepare($sql);    //prepara
            $stmt->bindParam(':usuario', $idusuario);   //vincula
            $stmt->bindParam(':producao', $idProducao);     //vincula

            $result = $stmt->execute();     //executa

            if(!$result){
                var_dump($stmt->errorInfo());
                    exit;
                }
            else{
                header("Location: pagina-producao.php?prod=$idProducao");
            }
        }

        function apagarFavorito($idusuario, $idProducao){
            $sql = "DELETE FROM usuario_favorita_producao WHERE usuario_idusuario = $idusuario AND producao_idproducao = $idProducao";
            $stmt = $this->PDO->prepare($sql);    //prepara
            $result = $stmt->execute();     //executa
            
            if(!$result){
                var_dump($stmt->errorInfo());
                    exit;
                }
            else{
                header("Location: pagina-producao.php?prod=$idProducao");
            }
        }

        function verificaFavorito($idusuario, $idProducao){
            $sql = "SELECT * FROM usuario_favorita_producao WHERE usuario_idusuario = $idusuario AND producao_idproducao = $idProducao";
            $stmt = $this->PDO->prepare($sql);    //prepara
            $result = $stmt->execute();    //executa
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if($rows == null){
                return true;
            } else {
                return false;
            }
        }
    }
?>