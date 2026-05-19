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
                <h4>Categories</h4>
                <ul>
                    <li><a href="">Art</a></li>
                    <li><a href="">Wild Life</a></li>
                    <li><a href="">Travel</a></li>
                    <li><a href="">Science & Technology</a></li>
                    <li><a href="">Food</a></li>
                    <li><a href="">Music</a></li>
                </ul>
            </article>
            <article>
                <h4>Support</h4>
                <ul>
                    <li><a href="">Online support</a></li>
                    <li><a href="">Call numbers</a></li>
                    <li><a href="">Email support</a></li>
                    <li><a href="">Social support</a></li>
                    <li><a href="">Location</a></li>
                </ul>
            </article>
            <article>
                <h4>Blog</h4>
                <ul>
                    <li><a href="">Safety</a></li>
                    <li><a href="">Repair</a></li>
                    <li><a href="">Recent</a></li>
                    <li><a href="">Popular</a></li>
                    <li><a href="">Categories</a></li>
                </ul>
            </article>
            <article>
                <h4>Permalinks</h4>
                <ul>
                    <li><a href="">Home</a></li>
                    <li><a href="">Blog</a></li>
                    <li><a href="">About</a></li>
                    <li><a href="">Services</a></li>
                    <li><a href="">Contact</a></li>
                </ul>
            </article>
        </div>
        <div class="footer__copyright">
            <small>Copyright &copy; WriteX blog. All rights reserved.</small>
        </div>
    </footer>

    <!-- Chatbot bubble — shfaqet vetëm nëse useri është i kyçur -->
    <?php if (isset($_SESSION['user-id'])): ?>
    <button id="chatbot-bubble" aria-label="Hap support chat">
        <i class="uil uil-comment-dots"></i>
        <span class="bubble__badge"></span>
    </button>

    <div id="chatbot-window" role="dialog" aria-label="Support Chat">
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
                <div class="msg__bubble">Përshëndetje! 👋 Jam asistenti i WriteX. Si mund t'ju ndihmoj sot?</div>
                <span class="msg__time"><?= date('H:i') ?></span>
            </div>
        </div>
        <div class="chatbot__input-area">
            <textarea id="chatbot-input" placeholder="Shkruaj një pyetje..." rows="1"></textarea>
            <button id="chatbot-send" aria-label="Dërgo"><i class="uil uil-message"></i></button>
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