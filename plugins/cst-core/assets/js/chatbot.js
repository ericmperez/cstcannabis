/**
 * CST Chatbot — Chat UI, typing indicator, keyboard accessible, aria-live.
 */
(function () {
    'use strict';

    function init() {
        var config = window.cstChatbot;
        if (!config) return;

        var toggle   = document.getElementById('cst-chatbot-toggle');
        var chatWin  = document.getElementById('cst-chatbot-window');
        var messages = document.getElementById('cst-chatbot-messages');
        var form     = document.getElementById('cst-chatbot-form');
        var input    = document.getElementById('cst-chatbot-input');
        var closeBtn = document.getElementById('cst-chatbot-close');

        if (!toggle || !chatWin || !messages || !form || !input) return;

        var iconChat  = toggle.querySelector('.cst-chatbot__toggle-icon--chat');
        var iconClose = toggle.querySelector('.cst-chatbot__toggle-icon--close');
        var isOpen    = false;
        var hasGreeted = false;

        /* -------------------------------------------------------------- */
        /*  Toggle                                                        */
        /* -------------------------------------------------------------- */

        function openChat() {
            isOpen = true;
            chatWin.classList.add('is-open');
            toggle.setAttribute('aria-expanded', 'true');
            toggle.setAttribute('aria-label', config.i18n.close);
            if (iconChat) iconChat.style.display = 'none';
            if (iconClose) iconClose.style.display = '';

            if (!hasGreeted) {
                addMessage(config.greeting, 'bot');
                hasGreeted = true;
            }

            input.focus();
        }

        function closeChat() {
            isOpen = false;
            chatWin.classList.remove('is-open');
            toggle.setAttribute('aria-expanded', 'false');
            toggle.setAttribute('aria-label', config.i18n.open);
            if (iconChat) iconChat.style.display = '';
            if (iconClose) iconClose.style.display = 'none';

            toggle.focus();
        }

        toggle.addEventListener('click', function () {
            isOpen ? closeChat() : openChat();
        });

        if (closeBtn) {
            closeBtn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                closeChat();
            });
        }

        // Escape key closes chat.
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && isOpen) {
                closeChat();
            }
        });

        // Trap focus within chat window when open.
        chatWin.addEventListener('keydown', function (e) {
            if (e.key !== 'Tab') return;

            var focusable = chatWin.querySelectorAll(
                'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
            );
            if (!focusable.length) return;

            var first = focusable[0];
            var last  = focusable[focusable.length - 1];

            if (e.shiftKey && document.activeElement === first) {
                e.preventDefault();
                last.focus();
            } else if (!e.shiftKey && document.activeElement === last) {
                e.preventDefault();
                first.focus();
            }
        });

        /* -------------------------------------------------------------- */
        /*  Messages                                                      */
        /* -------------------------------------------------------------- */

        function addMessage(text, sender) {
            var div = document.createElement('div');
            div.className = 'cst-chatbot__message cst-chatbot__message--' + sender;

            if (sender === 'bot') {
                // Allow simple HTML (links) in bot messages.
                div.innerHTML = text;
            } else {
                div.textContent = text;
            }

            messages.appendChild(div);
            messages.scrollTop = messages.scrollHeight;
        }

        function showTyping() {
            var typing = document.createElement('div');
            typing.className = 'cst-chatbot__typing';
            typing.id = 'cst-chatbot-typing';
            typing.setAttribute('aria-label', config.i18n.typing);
            typing.innerHTML =
                '<span class="cst-chatbot__typing-dot"></span>' +
                '<span class="cst-chatbot__typing-dot"></span>' +
                '<span class="cst-chatbot__typing-dot"></span>';
            messages.appendChild(typing);
            messages.scrollTop = messages.scrollHeight;
        }

        function hideTyping() {
            var typing = document.getElementById('cst-chatbot-typing');
            if (typing) typing.remove();
        }

        /* -------------------------------------------------------------- */
        /*  Send Message                                                  */
        /* -------------------------------------------------------------- */

        form.addEventListener('submit', function (e) {
            e.preventDefault();

            var text = input.value.trim();
            if (!text) return;

            addMessage(text, 'user');
            input.value = '';
            input.disabled = true;
            form.querySelector('.cst-chatbot__send').disabled = true;

            showTyping();

            fetch(config.endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-WP-Nonce': config.nonce
                },
                body: JSON.stringify({ message: text })
            })
            .then(function (res) {
                return res.json();
            })
            .then(function (data) {
                hideTyping();
                addMessage(data.reply || config.i18n.error, 'bot');
            })
            .catch(function () {
                hideTyping();
                addMessage(config.i18n.error, 'bot');
            })
            .finally(function () {
                input.disabled = false;
                form.querySelector('.cst-chatbot__send').disabled = false;
                input.focus();
            });
        });
    }

    // Wait for DOM to be ready.
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})();
