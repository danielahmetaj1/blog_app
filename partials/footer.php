<footer>
        <div class="footer__socials">
            <a href="https://www.facebook.com/" target="_blank" rel="noopener noreferrer" title="Facebook"><i class="uil uil-facebook-f"></i></a>
            <a href="https://www.twitter.com/"  target="_blank" rel="noopener noreferrer" title="Twitter"><i class="uil uil-twitter"></i></a>
            <a href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer" title="Instagram"><i class="uil uil-instagram"></i></a>
            <a href="https://www.linkedin.com/" target="_blank" rel="noopener noreferrer" title="LinkedIn"><i class="uil uil-linkedin"></i></a>
            <a href="https://www.youtube.com/"  target="_blank" rel="noopener noreferrer" title="YouTube"><i class="uil uil-youtube"></i></a>
        </div>
        <div class="container footer__container">
            <article>
                <h4>Kategorite</h4>
                <ul>
                    <li><a href="">Art</a></li>
                    <li><a href="">Jeta e Eger</a></li>
                    <li><a href="">Udhetime</a></li>
                    <li><a href="">Shkence & Teknologji</a></li>
                    <li><a href="">Ushqim</a></li>
                    <li><a href="">Muzike</a></li>
                </ul>
            </article>
            <article>
                <h4>Mbeshtetje</h4>
                <ul>
                    <li><a href="">Mbeshtetje online</a></li>
                    <li><a href="">Numra kontakti</a></li>
                    <li><a href="">Mbeshtetje me email</a></li>
                    <li><a href="">Mbeshtetje sociale</a></li>
                    <li><a href="">Vendndodhja</a></li>
                </ul>
            </article>
            <article>
                <h4>Blog</h4>
                <ul>
                    <li><a href="">Siguria</a></li>
                    <li><a href="">Riparime</a></li>
                    <li><a href="">Te fundit</a></li>
                    <li><a href="">Me te njohurit</a></li>
                    <li><a href="">Kategorite</a></li>
                </ul>
            </article>
            <article>
                <h4>Lidhje</h4>
                <ul>
                    <li><a href="">Faqja kryesore</a></li>
                    <li><a href="">Blog</a></li>
                    <li><a href="">Rreth Nesh</a></li>
                    <li><a href="">Sherbime</a></li>
                    <li><a href="">Kontakt</a></li>
                </ul>
            </article>
        </div>
        <div class="footer__copyright">
            <small>E drejta e autorit &copy; WriteX blog. Te gjitha te drejtat e rezervuara.</small>
        </div>
    </footer>

    <!-- Chatbot bubble - shfaqet vetem nese useri eshte i kycur -->
    <?php if (isset($_SESSION['user-id'])): ?>
    <button id="chatbot-bubble" aria-label="Hap chat-in e mbeshtetjes">
        <i class="uil uil-comment-dots"></i>
        <span class="bubble__badge"></span>
    </button>

    <div id="chatbot-window" role="dialog" aria-label="Chat Mbeshtetje">
        <div class="chatbot__header">
            <div class="chatbot__avatar"><i class="uil uil-robot"></i></div>
            <div class="chatbot__info">
                <span class="chatbot__name">WriteX Support</span>
                <span class="chatbot__status">Online</span>
            </div>
            <button id="chatbot-close" aria-label="Mbyll chat"><i class="uil uil-times"></i></button>
        </div>
        <div class="chatbot__messages" id="chatbot-messages">
            <div class="msg bot">
                <div class="msg__bubble">Pershendetje! 👋 Jam asistenti i WriteX. Si mund t'ju ndihmoj sot?</div>
                <span class="msg__time"><?= date('H:i') ?></span>
            </div>
        </div>
        <div class="chatbot__input-area">
            <textarea id="chatbot-input" placeholder="Shkruaj nje pyetje..." rows="1"></textarea>
            <button id="chatbot-send" aria-label="Dergo"><i class="uil uil-message"></i></button>
        </div>
    </div>
    <script>
        const ROOT_URL = '<?= ROOT_URL ?>';
    </script>
    <script src="<?= ROOT_URL ?>js/Chatbot.js"></script>
    <?php endif ?>

    <script src="<?= ROOT_URL ?>js/main.js"></script>
</body>
</html>
