<?php
include 'config.php';

$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($conn->connect_error) {
    die("Conexiunea a eșuat: " . $conn->connect_error);
}

$email = $_POST['email'];
$name = $_POST['name'];
$phone = $_POST['phone'];
$social = $_POST['social'];
$category = $_POST['category'];
$recommendation = $_POST['recommendation'];
$motivation = $_POST['motivation'];
$criteria = $_POST['criteria'];
$project = $_POST['project'];
$additional = $_POST['additional'];

$sql = "SELECT * FROM jurati WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "Ai completat deja acest formular.";
} else {
    $sql = "INSERT INTO jurati (email, name, phone, social, category, recommendation, motivation, criteria, project, additional)
            VALUES ('$email', '$name', '$phone', '$social', '$category', '$recommendation', '$motivation', '$criteria', '$project', '$additional')";

    if ($conn->query($sql) === TRUE) {
        $to = $email . ', aplicatii@ivoluntar.org';
        $subject = "Confirmare aplicare jurat Gala Voluntariatului";
        $message = "Multumim pentru aplicarea ca jurat la Gala Voluntariatului.\n\n"
                 . "Datele tale:\n"
                 . "Email: $email\n"
                 . "Nume: $name\n"
                 . "Telefon: $phone\n"
                 . "Social: $social\n"
                 . "Categorie: $category\n"
                 . "Recomandare: $recommendation\n"
                 . "Motivatie: $motivation\n"
                 . "Criterii: $criteria\n"
                 . "Proiect: $project\n"
                 . "Informatii suplimentare: $additional";

        $headers = "From: contact@ivoluntar.org";

        mail($to, $subject, $message, $headers);

        echo "Formularul a fost trimis cu succes. Vei primi un email de confirmare.";
    } else {
        echo "Eroare: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
