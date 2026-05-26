    (() => {
        const track   = document.getElementById('carouselTrack');
        const wrap    = document.getElementById('trackWrap');
        const btnPrev = document.getElementById('btnPrev');
        const btnNext = document.getElementById('btnNext');
        const dotsEl  = document.getElementById('carouselDots');

        const cards   = Array.from(track.querySelectorAll('.guru-card'));
        const total   = cards.length;
        let current   = 0;
        let startX    = 0;
        let isDrag    = false;

        function buildDots() {
            dotsEl.innerHTML = '';
            const count = Math.max(1, total - getVisibleCount() + 1);
            for (let i = 0; i < count; i++) {
                const dot = document.createElement('button');
                dot.className = 'dot' + (i === current ? ' active' : '');
                dot.setAttribute('aria-label', `Posisi ke-${i+1}`);
                dot.addEventListener('click', () => goTo(i));
                dotsEl.appendChild(dot);
            }
        }

        function updateDots() {
            dotsEl.querySelectorAll('.dot').forEach((d, i) =>
                d.classList.toggle('active', i === current));
        }

        const GAP = 24;

        function getVisibleCount() {
            const wrapW = wrap.offsetWidth;
            if (wrapW >= 960) return Math.min(3, total);
            if (wrapW >= 700) return Math.min(2, total);
            return 1;
        }

        function getCardWidth() {
            const wrapW = wrap.offsetWidth;
            const vis = getVisibleCount();
            const cardW = (wrapW - GAP * (vis - 1)) / vis;
            cards.forEach(c => { c.style.flex = `0 0 ${cardW}px`; });
            return cardW + GAP;
        }

        function updateArrows() {
            const maxIdx = Math.max(0, total - getVisibleCount());
            btnPrev.disabled = current === 0;
            btnNext.disabled = current >= maxIdx;
        }

        function goTo(idx) {
            const cardW = getCardWidth();
            const maxIdx = Math.max(0, total - getVisibleCount());
            current = Math.max(0, Math.min(idx, maxIdx));
            track.style.transform = `translateX(-${current * cardW}px)`;
            updateDots();
            updateArrows();
        }

        btnPrev.addEventListener('click', () => goTo(current - 1));
        btnNext.addEventListener('click', () => goTo(current + 1));

        // Touch / drag swipe
        track.addEventListener('touchstart', e => { startX = e.touches[0].clientX; isDrag = true; }, { passive: true });
        track.addEventListener('touchend', e => {
            if (!isDrag) return;
            const dx = e.changedTouches[0].clientX - startX;
            if (Math.abs(dx) > 50) goTo(current + (dx < 0 ? 1 : -1));
            isDrag = false;
        });
        // Mouse drag
        track.addEventListener('mousedown', e => { startX = e.clientX; isDrag = true; });
        document.addEventListener('mouseup', e => {
            if (!isDrag) return;
            const dx = e.clientX - startX;
            if (Math.abs(dx) > 60) goTo(current + (dx < 0 ? 1 : -1));
            isDrag = false;
        });

        // Keyboard arrow navigation
        document.addEventListener('keydown', e => {
            if (e.key === 'ArrowLeft') goTo(current - 1);
            if (e.key === 'ArrowRight') goTo(current + 1);
        });

        // Init
        buildDots();
        updateArrows();

        // Recalc on resize
        window.addEventListener('resize', () => { goTo(current); buildDots(); });
    })();