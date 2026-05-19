(() => {
    // Historia e bisedës
    let history = [];
    let isTyping = false;

    const bubble  = document.getElementById('chatbot-bubble');
    const win     = document.getElementById('chatbot-window');
    const closeBtn= document.getElementById('chatbot-close');
    const msgList = document.getElementById('chatbot-messages');
    const input   = document.getElementById('chatbot-input');
    const sendBtn = document.getElementById('chatbot-send');

    if (!bubble) return; // Nuk është i kyçur — nuk shfaqet

    // ── Hap / Mbyll ─────────────────────────────────────────
    bubble.addEventListener('click', () => {
        const isOpen = win.classList.toggle('open');
        bubble.querySelector('i').className = isOpen ? 'uil uil-times' : 'uil uil-comment-dots';
        bubble.classList.remove('has-badge');
        if (isOpen) {
            input.focus();
            scrollToBottom();
        }
    });

    closeBtn.addEventListener('click', () => {
        win.classList.remove('open');
        bubble.querySelector('i').className = 'uil uil-comment-dots';
    });

    // ── Dërgo mesazh ────────────────────────────────────────
    const sendMessage = async () => {
        const text = input.value.trim();
        if (!text || isTyping) return;

        // Shto mesazhin e userit
        addMessage('user', text);
        history.push({ role: 'user', content: text });
        input.value = '';
        input.style.height = 'auto';

        // Shfaq typing indicator
        const typingEl = showTyping();
        isTyping = true;
        sendBtn.disabled = true;

        try {
            const res = await fetch(ROOT_URL + 'chatbot.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ messages: history }),
            });

            const data = await res.json();
            typingEl.remove();

            if (data.error) {
                addMessage('bot', '⚠️ ' + data.error);
            } else {
                addMessage('bot', data.reply);
                history.push({ role: 'assistant', content: data.reply });

                // Badge nëse dritarja është e mbyllur
                if (!win.classList.contains('open')) {
                    bubble.classList.add('has-badge');
                }
            }
        } catch (e) {
            typingEl.remove();
            addMessage('bot', '⚠️ Problem lidhje. Provo përsëri.');
        }

        isTyping = false;
        sendBtn.disabled = false;
        input.focus();
    };

    sendBtn.addEventListener('click', sendMessage);

    input.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });

    // Auto-resize textarea
    input.addEventListener('input', () => {
        input.style.height = 'auto';
        input.style.height = Math.min(input.scrollHeight, 100) + 'px';
    });

    // ── Helper: shto mesazh ─────────────────────────────────
    function addMessage(role, text) {
        const now  = new Date();
        const time = now.getHours().toString().padStart(2,'0') + ':' +
                     now.getMinutes().toString().padStart(2,'0');

        const div = document.createElement('div');
        div.className = `msg ${role}`;
        div.innerHTML = `
            <div class="msg__bubble">${escHtml(text).replace(/\n/g, '<br>')}</div>
            <span class="msg__time">${time}</span>`;
        msgList.appendChild(div);
        scrollToBottom();
    }

    // ── Helper: typing indicator ────────────────────────────
    function showTyping() {
        const div = document.createElement('div');
        div.className = 'msg bot typing';
        div.innerHTML = `
            <div class="msg__bubble">
                <span class="typing__dot"></span>
                <span class="typing__dot"></span>
                <span class="typing__dot"></span>
            </div>`;
        msgList.appendChild(div);
        scrollToBottom();
        return div;
    }

    function scrollToBottom() {
        msgList.scrollTop = msgList.scrollHeight;
    }

    function escHtml(str) {
        return str.replace(/&/g,'&amp;').replace(/</g,'&lt;')
                  .replace(/>/g,'&gt;').replace(/"/g,'&quot;')
                  .replace(/'/g,'&#039;');
    }
})();