<?php
require_once 'LiveUser.php';
require_once 'Log.php';

$conf = array('mode' => 0600, 'timeFormat' => '%X %x');
$logger = Log::singleton('file', 'out.log', 'ident', $conf);

// BOOK CODE START CONF EXAMPLE
// this is a minimum to get a working installation
$liveuserConfig = array(
    'debug' => $logger,
    'session' => array(
        'force_start' => true,
    ),
    'logout' => array(
        'destroy'  => true
    ),
    'authContainers' => array(
        0 => array(
            'loginTimeout' => 0,
            'expireTime'   => 3600,
            'idleTime'     => 1800,
            'allowDuplicateHandles'  => false,
            'passwordEncryptionMode' => 'MD5',
            'allowEmptyPasswords' => false,
            'type' => 'XML',
            'storage' => array(
                'file' => 'Auth_XML.xml',
                'alias' => array(
                    'auth_user_id' => 'userId',
                    'passwd'       => 'password',
                    'lastlogin'    => 'lastLogin',
                    'is_active'    => 'isActive',
                    'name'         => 'name'
                ),
            )
        )
    )
);
// END BOOK CODE START CONF EXAMPLE
 
// BOOK CODE AUTHENTICATION EXAMPLE
$lu = LiveUser::factory($liveuserConfig);
$init_status = $lu->init('arnaud', 'arnaud');
if ($init_status == false) {
    errHandler($lu->getErrors());
}

if ($lu->getStatus() == LIVEUSER_STATUS_OK) {
    echo 'User logged in successfully';
} else {
    echo 'There was something wrong: ' . $lu->statusMessage($lu->getStatus());
}
// BOOK CODE AUTHENTICATION EXAMPLE

// BOOK CODE CHECK RIGHT
if ($lu->checkRight(ADD_MOVIE)) {
    echo 'You are allowed to add movies to the queue';
} else {
    echo 'You cannot add movies';
}
// BOOK CODE CHECK RIGHT

function errHandler($errors)
{
    foreach($errors as $index => $error) {
        echo "Message for error $index: " . $error['message'];
    }
}
?>
