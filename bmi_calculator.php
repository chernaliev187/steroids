<?php
session_start();

// Проверяваме дали потребителят е влязъл
if (!isset($_SESSION['user_id'])) {
    header("Location: register.php"); // Пренасочване към регистрация
    exit();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli("localhost", "root", "190906", "bmi_calculator");

if ($conn->connect_error) {
    die("Грешка при свързване с базата данни: " . $conn->connect_error);
}

// Проверка дали заявката идва от AJAX и дали са подадени данни
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ajax'])) {
    $weight = $_POST['weight'];
    $height = $_POST['height'];
    $user_id = $_SESSION['user_id']; // Взимаме ID-то на логнатия потребител

    if (is_numeric($weight) && is_numeric($height)) {
        // Вмъкваме теглото и височината само за текущия потребител
        $stmt = $conn->prepare("INSERT INTO user_data (user_id, weight, height, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("idd", $user_id, $weight, $height);
        $stmt->execute();
        $stmt->close();
        echo "success";
    } else {
        echo "error";
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitness BMI Calculator</title>
    <link rel="stylesheet" href="bmi_calculator.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMI Калкулатор</title>
    <link rel="stylesheet" href="bmi_calculator.css">
</head>
<body>
<body>

<div class="wrapper">
    <header>
        <nav class="nav-menu">
            <ul>
                <li><a href="start-up.php">Начало</a></li>
                <li><a href="bmi_calculator.php">BMI Калкулатор</a></li>
                <li><a href="plan.php">Моят план</a></li>
                <li><a href="workouts.php">Моите тренировки</a></li>
                <li><a href="progress.php">Моят прогрес</a></li>
                <li><a href="profile.php">Моят профил</a></li>
            </ul>
        </nav>
    </header>

    <main class="main-content">
        <div class="container">
            <h1>Fitness BMI Калкулатор</h1>
            <p>Въведете вашите данни, за да изчислите Индекс на телесна маса (BMI).</p>

            <div class="form">
                <label for="weight">Тегло (kg):</label>
                <input type="number" id="weight" placeholder="Например: 70" required>

                <label for="height">Височина (cm):</label>
                <input type="number" id="height" placeholder="Например: 175" required>

                <button id="calculateBtn">Изчисли</button>
            </div>

            <div class="bmi-scale" style="display: none;">
                <table>
                    <tr>
                        <td class="underweight">Поднормено тегло</td>
                        <td class="normal">Нормално тегло</td>
                        <td class="overweight">Наднормено тегло</td>
                        <td class="obese">Затлъстяване</td>
                    </tr>
                </table>
                <div class="arrow">⬇</div>
            </div>

            <div id="result"></div>
        </div>
    </main>

    <footer class="site-footer">
        <?php include 'footer.php'; ?>
    </footer>
</div>

<script>
    document.getElementById("calculateBtn").addEventListener("click", function (event) {
        event.preventDefault(); // СПИРА ПРЕЗАРЕЖДАНЕТО

        let weight = parseFloat(document.getElementById("weight").value);
        let height = parseFloat(document.getElementById("height").value) / 100;

        if (!isNaN(weight) && weight > 0 && !isNaN(height) && height > 0) {
            let bmi = (weight / (height * height)).toFixed(2);
            let category = "";
            let arrowPosition = 0;

            if (bmi < 18.5) {
                category = "Поднормено тегло";
                arrowPosition = 12.5;
            } else if (bmi < 25) {
                category = "Нормално тегло";
                arrowPosition = 37.5;
            } else if (bmi < 30) {
                category = "Наднормено тегло";
                arrowPosition = 65.5;
            } else {
                category = "Затлъстяване";
                arrowPosition = 87.5;
            }

            document.getElementById("result").innerHTML = 
                `<h3>Вашият BMI: ${bmi}</h3>
                 <p>Категория: <strong>${category}</strong></p>`;

            document.querySelector(".bmi-scale").style.display = "block";
            document.querySelector(".arrow").style.left = arrowPosition + "%";

            // Изпращане на данните към базата
            let formData = new FormData();
            formData.append("weight", weight);
            formData.append("height", height);
            formData.append("ajax", true);

            fetch("", {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if (data.trim() === "success") {
                    console.log("Данните са записани успешно!");
                } else {
                    console.log("Грешка при записването!");
                }
            })
            .catch(error => console.log("Грешка: " + error));
        } else {
            document.getElementById("result").innerHTML = 
                `<p class="error">Моля, въведете валидни стойности!</p>`;
            document.querySelector(".bmi-scale").style.display = "none";
        }
    });
</script>

</body>
</html>
