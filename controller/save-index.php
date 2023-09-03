<?php
    session_start();
    if (isset($_POST['index'])) {
        $_SESSION['index'] = $_POST['index'];
        echo 'success';
    } else {
        echo 'failure';
    }
?>