// ===== LIKES =====
const likeBtn = document.getElementById('like-btn');
if (likeBtn) {
    likeBtn.addEventListener('click', () => {
        if (!IS_LOGGED) {
            window.location.href = ROOT_URL + 'signin.php';
            return;
        }
        const fd = new FormData();
        fd.append('post_id', POST_ID);

        fetch(ROOT_URL + 'like-post.php', { method: 'POST', body: fd })
            .then(r => r.json())
            .then(data => {
                if (!data.success) { alert(data.message); return; }
                document.getElementById('like-count').textContent = data.count;
                likeBtn.classList.toggle('liked', data.liked);
            });
    });
}

// ===== SHARE =====
function trackShare(platform, postId) {
    const fd = new FormData();
    fd.append('post_id', postId);
    fd.append('platform', platform);
    fetch(ROOT_URL + 'share-post.php', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                const el = document.getElementById('share-count');
                if (el) el.textContent = data.count + (data.count === 1 ? ' share' : ' shares');
            }
        });
}

document.querySelectorAll('.share__btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
        const platform = this.dataset.platform;
        const postId   = this.dataset.postId;

        if (platform === 'copy') {
            e.preventDefault();
            navigator.clipboard.writeText(POST_URL).then(() => {
                const orig = this.innerHTML;
                this.innerHTML = '<i class="uil uil-check"></i>';
                this.title = 'Copied!';
                setTimeout(() => { this.innerHTML = orig; this.title = 'Copy link'; }, 1500);
            });
        }
        trackShare(platform, postId);
    });
});

// ===== COMMENTS =====
const commentForm = document.getElementById('comment-form');
if (commentForm) {
    commentForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const body = document.getElementById('comment-body').value.trim();
        if (!body) return;

        const fd = new FormData(this);
        const btn = this.querySelector('button[type="submit"]');
        btn.disabled = true;
        btn.textContent = 'Posting…';

        fetch(ROOT_URL + 'add-comment.php', { method: 'POST', body: fd })
            .then(r => r.json())
            .then(data => {
                btn.disabled = false;
                btn.textContent = 'Post Comment';
                if (!data.success) { alert(data.message); return; }

                document.getElementById('comment-body').value = '';
                const c = data.comment;

                // Build comment HTML
                const div = document.createElement('div');
                div.className = 'comment__item comment__item--new';
                div.innerHTML = `
                    <div class="comment__avatar">
                        <img src="${ROOT_URL}images/${c.avatar}" alt="">
                    </div>
                    <div class="comment__body">
                        <div class="comment__meta">
                            <strong>${escHtml(c.username)}</strong>
                            <small>${c.created_at}</small>
                        </div>
                        <p>${escHtml(c.body).replace(/\n/g, '<br>')}</p>
                    </div>`;

                const list = document.getElementById('comment-list');
                list.prepend(div);

                // Update counts
                const countEl  = document.getElementById('comment-count');
                const countBar = document.getElementById('comment-count-bar');
                const current  = parseInt(countEl.textContent) || 0;
                countEl.textContent  = current + 1;
                if (countBar) countBar.textContent = current + 1;

                // Smooth scroll to the new comment
                div.scrollIntoView({ behavior: 'smooth', block: 'center' });
            });
    });
}

function escHtml(str) {
    return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;')
              .replace(/"/g,'&quot;').replace(/'/g,'&#039;');
}
