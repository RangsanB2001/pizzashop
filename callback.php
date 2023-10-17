<?php
require_once('confing.php');
require_once('LineLogin.php');

$line = new LineLogin();
$get = $_GET;

$code = $get['code'];
$state = $get['state'];
$token = $line->token($code, $state);

if (property_exists($token, 'error')){
    header('location: Login.php');
}
if ($token->id_token) {

    $profile2 = $line->profileFormIdToken($token);
    $profile = $line->profile($token->access_token);
    $_SESSION['pro'] = $profile2;
    $_SESSION['profile'] = $profile;

    $id = mysqli_real_escape_string($db_connection, $profile->userId);
    $full_name = mysqli_real_escape_string($db_connection, trim($profile->displayName));
    $email = mysqli_real_escape_string($db_connection, $profile2->email);
    $profile_pic = mysqli_real_escape_string($db_connection, $profile2->picture);

    // Check if the user already exists
    $get_user_stmt = $db_connection->prepare("SELECT gg_id FROM user WHERE gg_id = ?");
    $get_user_stmt->bind_param("s", $id);
    $get_user_stmt->execute();
    $get_user_stmt->store_result();
    if ($get_user_stmt->num_rows > 0) {
        header('location: index.php');
        exit;
    } else {
        $insert_stmt = $db_connection->prepare("INSERT INTO `user`(`gg_id`, `fullname`, `email`, `image`) VALUES (?, ?, ?, ?)");
        $insert_stmt->bind_param("ssss",$id, $full_name, $email, $profile_pic);
        $insert_result = $insert_stmt->execute();
        if ($insert_result) {
            header('location: index.php');
            exit;
        } else {
            header('location: login.php');
            exit;
        }
    }
}
// print_r($profile);
?>