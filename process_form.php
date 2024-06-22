<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recaptcha_secret = '6LeHWw8oAAAAAMQ17Lw4gWeC_Ry5P-o7YeabSyW5';
    $recaptcha_response = $_POST['g-recaptcha-response'];

    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = [
        'secret' => $recaptcha_secret,
        'response' => $recaptcha_response
    ];

    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        ]
    ];

    $context = stream_context_create($options);
    $verify = file_get_contents($url, false, $context);
    $captcha_success = json_decode($verify);

    if ($captcha_success->success) {
        $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if ($conn->connect_error) {
            die("Conexiunea a eșuat: " . $conn->connect_error);
        }

        $first_name = $conn->real_escape_string($_POST['first_name']);
        $last_name = $conn->real_escape_string($_POST['last_name']);
        $email = $conn->real_escape_string($_POST['email']);
        $phone = $conn->real_escape_string($_POST['phone']);
        $social = $conn->real_escape_string($_POST['social']);
        $city = $conn->real_escape_string($_POST['city']);
        $category = $conn->real_escape_string($_POST['category']);
        $recommendation = $conn->real_escape_string($_POST['recommendation']);
        $motivation = $conn->real_escape_string($_POST['motivation']);
        $criteria = $conn->real_escape_string($_POST['criteria']);
        $project = $conn->real_escape_string($_POST['project']);
        $additional = $conn->real_escape_string($_POST['additional']);
        $gdpr = isset($_POST['gdpr']) ? 1 : 0;

        $verification_code = mt_rand(1000, 9999);

        $sql_check = "SELECT * FROM `aplicatii-jurati` WHERE `email`='$email'";
        $result_check = $conn->query($sql_check);

        if ($result_check->num_rows > 0) {
            echo "Ai completat deja acest formular.";
        } else {

            $sql_insert = "INSERT INTO `aplicatii-jurati` (first_name, last_name, email, phone, social, city, category, recommendation, motivation, criteria, project, additional, gdpr, verification_code)
                VALUES ('$first_name', '$last_name', '$email', '$phone', '$social', '$city', '$category', '$recommendation', '$motivation', '$criteria', '$project', '$additional', '$gdpr', '$verification_code')";

            if ($conn->query($sql_insert) === TRUE) {
                $to = $email . ', aplicatii@ivoluntar.org';
                $subject = "Ai aplicat cu succes - Gala Voluntariatului";
                $message = "Salutare,\n  $first_name, îți mulțumim că ai aplicat să faci parte din juriul Galei Voluntariatului 2024. Revenim către tine cu vești în perioada 1-10 septembrie 2024.\n
                            Aplicația ta are numărul de înregistrare $verification_code. Te ținem la curent cât ai zice FACEM BINE.\n\n
                            
                            Cu drag,\n
                            Echipa Gala Voluntariatului";

                $headers = "From: Gala Voluntariatului <aplicatii@ivoluntar.org>";

                if (mail($to, $subject, $message, $headers)) {
                    echo "Formularul a fost trimis cu succes. Vei primi un email de confirmare.";
                } else {
                    echo "Eroare la trimiterea email-ului de confirmare.";
                }
            } else {
                echo "Eroare: " . $sql_insert . "<br>" . $conn->error;
            }
        }

        $conn->close();
    } else {
    
        echo "Te rugăm să completezi reCAPTCHA corect.";
    }
} else {
    echo "Acces neautorizat la formular.";
}
?>
