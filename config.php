<?php
// Server
    define('SERVER_NAME',       'LTE REST Server');
    define('FILE_DIR',          '/var/www/lte_rest/uploads/');

// Mail
    define('MAIL_FROM',         'let-rest@beispiel.de');
    define('ERROR_MAIL',        'elvira.hugendubel@beispiel.de');

// Log
    define('LOG_FOLDER',        dirname(__FILE__).'/logs/');
    
// Login
    define('LOGIN_USER',        'lte-user');
    // The followed hash is created by the php password_hash function.
    define('LOGIN_PASSWORD',    '$2y$10$l3beIUZL9DH.lb5vP8V/t.mpgz5SkC8kdh/.ZnK2YsxDo7llsuyyC');

// Allowed upload file typs
    define('ALLOWED_FILES',     array(
        'application/pdf'       => 'pdf',
        'application/xml'       => 'xml',
        'application/json'      => 'json'
        )
    );

?>
