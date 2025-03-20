<?php
session_start();

// Проверяваме дали потребителят е влязъл
if (isset($_SESSION['user_id'])) {
    header("Location: bmi_calculator.php"); // Пренасочване към вътрешната част на сайта
    exit();
}
?>
<!DOCTYPE html>
<html lang="bg">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FitnessHub - Добре дошли</title>
  <!-- Зареждане на Font Awesome за икони -->
  <link rel="stylesheet" href="index.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
  <!-- Херо секция -->
  <section class="hero">
    <div class="hero-content">
      <h1>Промени своя живот</h1>
      <p>Вдъхнови се, тренирай умно и живей здравословно с FitnessHub!</p>
      <a href="#services" class="btn-hero">Научи повече</a>
    </div>
  </section>

  <!-- За нас секция -->
  <section class="about" id="about">
    <h2>За нашия сайт</h2>
    <p>FitnessHub е вашият доверен партньор във фитнеса – предоставяме персонализирани тренировки, хранителни съвети и мотивация за постигане на здравословен и активен начин на живот.</p>
  </section>

  <!-- Услуги / Функции секция -->
  <section class="features" id="services">
    <h2>Нашите услуги</h2>
    <div class="feature-container">
      <div class="feature">
        <i class="fas fa-dumbbell"></i>
        <h3>Тренировъчни програми</h3>
        <p>Персонализирани тренировки, съобразени с вашето ниво и цели.</p>
      </div>
      <div class="feature">
        <i class="fas fa-heartbeat"></i>
        <h3>Хранителни съвети</h3>
        <p>Научете как да се храните правилно за оптимални резултати.</p>
      </div>
      <div class="feature">
        <i class="fas fa-users"></i>
        <h3>Общност</h3>
        <p>Присъединете се към нашата общност и споделяйте успехите си.</p>
      </div>
    </div>
  </section>

  <!-- Call to Action секция -->
  <section class="cta" id="contact">
    <h2>Готови ли сте за промяна?</h2>
    <p>Започнете своя път към по-здравословен живот още днес!</p>
    <a href="register.php" class="btn-cta">Регистрирай се сега</a>
  </section>
</body>
</html>
