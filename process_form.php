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
        $subject = "Confirmare aplicare jurat Gala Voluntariatului";
        $message = "Mulțumim pentru aplicarea ca jurat la Gala Voluntariatului.\n\n"
                 . "Datele tale:\n"
                 . "Nume: $first_name $last_name\n"
                 . "Email: $email\n"
                 . "Telefon: $phone\n"
                 . "Social: $social\n"
                 . "Oraș: $city\n"
                 . "Categorie: $category\n"
                 . "Recomandare: $recommendation\n"
                 . "Motivație: $motivation\n"
                 . "Criterii: $criteria\n"
                 . "Proiect: $project\n"
                 . "Informații suplimentare: $additional\n\n"
                 . "Cod unic de verificare: $verification_code";

        $headers = "From: contact@ivoluntar.org";

        mail($to, $subject, $message, $headers);

        echo "Formularul a fost trimis cu succes. Vei primi un email de confirmare.";
    } else {
        echo "Eroare: " . $sql_insert . "<br>" . $conn->error;
    }
}

$conn->close();
?>
