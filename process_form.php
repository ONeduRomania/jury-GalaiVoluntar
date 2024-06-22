<?php
include 'config.php';

$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($conn->connect_error) {
    die("Conexiunea a eșuat: " . $conn->connect_error);
}

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$social = $_POST['social'];
$city = $_POST['city'];
$category = $_POST['category'];
$recommendation = $_POST['recommendation'];
$motivation = $_POST['motivation'];
$criteria = $_POST['criteria'];
$project = $_POST['project'];
$additional = $_POST['additional'];
$gdpr = isset($_POST['gdpr']) ? 1 : 0;

// Generare cod unic de 4 cifre
$verification_code = mt_rand(1000, 9999);

// Escapare parametrii pentru a preveni SQL injection
$first_name = $conn->real_escape_string($first_name);
$last_name = $conn->real_escape_string($last_name);
$email = $conn->real_escape_string($email);
$phone = $conn->real_escape_string($phone);
$social = $conn->real_escape_string($social);
$city = $conn->real_escape_string($city);
$category = $conn->real_escape_string($category);
$recommendation = $conn->real_escape_string($recommendation);
$motivation = $conn->real_escape_string($motivation);
$criteria = $conn->real_escape_string($criteria);
$project = $conn->real_escape_string($project);
$additional = $conn->real_escape_string($additional);

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
                    Echipa Gala Voluntariatului"

        $headers = "From: Gala Voluntariatului<aplicatii@ivoluntar.org>";

        mail($to, $subject, $message, $headers);

        echo "Formularul a fost trimis cu succes. Vei primi un email de confirmare.";
    } else {
        echo "Eroare: " . $sql_insert . "<br>" . $conn->error;
    }
}

$conn->close();
?>
