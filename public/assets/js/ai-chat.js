document.addEventListener('DOMContentLoaded', () => {
    const inputField = document.getElementById('aiInput');
    const sendBtn = document.getElementById('sendAiBtn');
    const chatBox = document.getElementById('chatBox');

    async function sendMessage() {
        const text = inputField.value.trim();
        if (!text) return;

        appendMessage(text, 'user-message');
        inputField.value = '';

        const typingId = 'typing-' + Date.now();
        appendMessage('Анализирую профиль...', 'ai-message', typingId);

        try {
            const response = await fetch('../api/ai-advisor.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ message: text })
            });

            const data = await response.json();
            
            document.getElementById(typingId).remove();

            if (data.reply) {
                appendMessage(data.reply, 'ai-message');
            } else {
                appendMessage('Ошибка связи с нейросетью.', 'ai-message');
            }

        } catch (error) {
            document.getElementById(typingId).remove();
            appendMessage('Сервер временно недоступен.', 'ai-message');
        }
    }

    function appendMessage(text, className, id = '') {
        const msgDiv = document.createElement('div');
        msgDiv.className = `message ${className}`;
        msgDiv.textContent = text;
        if (id) msgDiv.id = id;
        chatBox.appendChild(msgDiv);
        chatBox.scrollTop = chatBox.scrollHeight; 
    }

    sendBtn.addEventListener('click', sendMessage);
    inputField.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') sendMessage();
    });
});