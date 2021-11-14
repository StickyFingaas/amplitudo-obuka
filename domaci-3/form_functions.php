<?php

    function showAlertDiv($message, $class, $colClass = "col-12"){
        echo "
            <div class=\"row\">
                <div class=\"$colClass alert $class text-center\">
                    $message
                </div>
            </div>
        ";
    }

?>