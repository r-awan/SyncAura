<?php
//include_once "../../../config.php";
//include_once('C:\xampp\htdocs\Farm2Fork\gest_utilisateur\controllers\UserController.php');
include_once "../../../models/usersign/model.php";

$api_key = 'p1ZElzM-B7KNcQBJHtX6Yo4e8NteQN7g';
$api_secret = 'LpcCXkyX7UHjug1s3oNXitqhwA5HAsnd';
$image_data = $_POST['image_data'];
$url = 'https://api-us.faceplusplus.com/facepp/v3/search';


$data = [
    'api_key' => $api_key,
    'api_secret' => $api_secret,
    'image_base64' => explode(',', $image_data)[1],
    'faceset_token' => '22a15f2b9fde630de1cbe3fffcdfdbcc'
];

$options = [
    'http' => [
        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
        'method' => 'POST',
        'content' => http_build_query($data)
    ]
];
$context = stream_context_create($options);
//error_log(http_build_query($data));  // Check how your data is being encoded


try {
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) {
        $last_error = error_get_last();
        throw new Exception('HTTP request failed. Error: ' . $last_error['message']);
    }
    $response = json_decode($result, true);


    if (isset($response['results']) && $response['results'][0]['confidence'] > 80) {
        $face_token = $response['results'][0]['face_token'];
        $user=getUserByFaceId($face_token);

        if ($user) {


            session_start();
            // Set session variables for the authenticated user
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        $_SESSION["profile_picture"] = $user["profile_picture"]; // Ensure profile picture is saved

        // Redirect to the user dashboard (main.php or wherever you want)
        $redirectUrl = "../loading_screen/loading_main.html";
            echo json_encode(['success' => true, 'message' => 'Welcome!','redirect'=>$redirectUrl, 'face_id' => $face_token]);
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'Face ID does not match any user.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No face detected or API error']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' .error_get_last()['message']
]);
}
?>
