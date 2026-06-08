<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NovaCode - Консультация</title>
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    
    <script src="assets/js/header.js" defer></script>
    <script src="assets/js/ai-chat.js" defer></script>
    <script src="assets/js/animations.js" defer></script>
    
    <link rel="icon" type="image/svg+xml" href="assets/images/main.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Black+Han+Sans&display=swap" rel="stylesheet">
</head>
<body>

    <header>
        <img src="./assets/images/iconHeader.svg" alt="icon">
        <a href="./index.html">Главная</a>
        <a href="./catalog.html">Курсы</a>
        
        <a href="#" id="navProfileLink" style="opacity: 0; transition: opacity 0.3s ease;">Профиль</a>

        <button id="consultation" onclick="window.location.href='./consultation.php';">
            консультация
        </button>
    </header>

    <main class="ai-advisor-section">
        <div class="container">
            <div class="ai-chat-window fade-element">
                <div class="chat-header">
                    <span class="neon-dot"></span> ИИ-Ментор NovaCode
                </div>
                
                <div class="chat-messages" id="chatBox">
                    <div class="message ai-message">
                        Привет! Я нейросетевой ассистент NovaCode. Расскажи, чем ты хочешь заниматься в IT (делать игры, ковыряться в железе, писать бизнес-логику?), и я подберу идеальный язык для старта.
                    </div>
                </div>

                <div class="chat-input-area">
                    <input type="text" id="aiInput" placeholder="Напиши свой ответ здесь..." autocomplete="off">
                    <button id="sendAiBtn" class="btn-send">Отправить</button>
                </div>
            </div>
        </div>
    </main>

</body>
</html>