<?php

    class Message {

        private $url;

        public function __construct($url)
        {
            $this->url = $url;
        }

        public function setMessage($msg, $type, $redirect = "index.php") // insere mensagem
        {
            $_SESSION["msg"] = $msg;
            $_SESSION["type"] = $type;

            if($redirect != "back") {
                header("Location: $this->url" . $redirect);
            } else {
                header("Location: " . $_SERVER["HTTP_REFERER"]); // ULTIMA PAGINA ACESSADA
            }
        }

        public function getMessage() // exibe mensagem
        {
            if(!empty($_SESSION["msg"])){
                return [
                    "msg" => $_SESSION["msg"],
                    "type" => $_SESSION["type"]
                ];
            } else {
                return false;
            }
        }
        public function clearMessage() // limpa mensagem
        {
            $_SESSION["msg"] = "";
            $_SESSION["type"] = "";
        }
    }