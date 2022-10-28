<?php
    namespace Filter;

    session_start();

    function FilterRequest($allowedRoles) {

        if(isset($_SESSION["role"]) && in_array($_SESSION["role"], $allowedRoles))
            return;

        http_response_code(401);
        session_unset();
        session_destroy();
        exit(0);
    }

    function AdminOnly() {
        FilterRequest([ "administrador" ]);
    }

    function AuthenticatedOnly() {
        FilterRequest([ "administrador", "representante" ]);
    }

?>