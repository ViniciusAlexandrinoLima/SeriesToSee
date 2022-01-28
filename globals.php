<?php

    session_start();
    $BASE_URL = "http://" . $_SERVER["SERVER_NAME"] . dirname($_SERVER["REQUEST_URI"]."?") . "/";

    //serve para achar mais fácil os arquivos no sistema