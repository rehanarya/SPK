/* ─────────────────────────────────────────────────────────────────────────
   SPK Pembiayaan KSPPS — JavaScript Entry
   ───────────────────────────────────────────────────────────────────────── */

import * as bootstrap from 'bootstrap';
import IMask from 'imask';

window.bootstrap = bootstrap;
window.IMask = IMask;

document.addEventListener('DOMContentLoaded', () => {
    initFlashDismiss();
    initPasswordToggle();
    initSidebarToggle();
    initRupiahMask();
    initConfirmActions();
    initSelectFilter();
});

/* ── Auto-dismiss alerts (DESIGN.md §5.3) ───────────────────────────────── */
function initFlashDismiss() {
    document.querySelectorAll('[data-auto-dismiss]').forEach((el) => {
        const delay = parseInt(el.dataset.autoDismiss, 10) || 5000;
        setTimeout(() => {
            el.style.transition = 'opacity 300ms ease';
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 300);
        }, delay);
    });

    document.querySelectorAll('.alert-close').forEach((btn) => {
        btn.addEventListener('click', () => {
            const alert = btn.closest('.alert');
            if (!alert) return;
            alert.style.transition = 'opacity 200ms ease';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 200);
        });
    });
}

/* ── Toggle password visibility (DESIGN.md §4.1) ─────────────────────────── */
function initPasswordToggle() {
    document.querySelectorAll('.toggle-pwd').forEach((btn) => {
        btn.addEventListener('click', () => {
            const target = document.querySelector(btn.dataset.target);
            if (!target) return;
            const isHidden = target.type === 'password';
            target.type = isHidden ? 'text' : 'password';
            const icon = btn.querySelector('i');
            if (icon) {
                icon.className = isHidden ? 'bi bi-eye-slash' : 'bi bi-eye';
            }
        });
    });
}

/* ── Sidebar off-canvas toggle (mobile) ──────────────────────────────────── */
function initSidebarToggle() {
    const burger = document.querySelector('[data-sidebar-toggle]');
    const sidebar = document.querySelector('.app-sidebar');
    const backdrop = document.querySelector('.sidebar-backdrop');

    if (!burger || !sidebar) return;

    const close = () => {
        sidebar.classList.remove('open');
        backdrop?.classList.remove('open');
    };

    burger.addEventListener('click', () => {
        sidebar.classList.toggle('open');
        backdrop?.classList.toggle('open');
    });

    backdrop?.addEventListener('click', close);

    document.querySelectorAll('.app-sidebar-item').forEach((item) => {
        item.addEventListener('click', () => {
            if (window.innerWidth < 992) close();
        });
    });
}

/* ── Rupiah mask via imask.js (DESIGN.md §4.3) ───────────────────────────── */
function initRupiahMask() {
    document.querySelectorAll('[data-mask="rupiah"]').forEach((input) => {
        const mask = IMask(input, {
            mask: Number,
            scale: 0,
            thousandsSeparator: '.',
            radix: ',',
            mapToRadix: ['.'],
            min: 0,
            max: 999999999999,
        });

        // Saat submit form: substitusi value dengan unmasked number
        const form = input.closest('form');
        if (form) {
            form.addEventListener('submit', () => {
                input.value = mask.unmaskedValue;
            });
        }

        // Apabila ada nilai awal (old() saat validation error), pasang ke mask
        if (input.value) {
            mask.value = input.value;
        }
    });
}

/* ── Live filter untuk <select> via input pencarian terpisah ────────────── */
/* Aktivasi: <input data-filters-select="#selector_select_id"> di atas <select> */
function initSelectFilter() {
    document.querySelectorAll('[data-filters-select]').forEach((input) => {
        const select = document.querySelector(input.dataset.filtersSelect);
        if (!select) return;
        const options = Array.from(select.options).filter((o) => o.value !== '');

        input.addEventListener('input', () => {
            const q = input.value.trim().toLowerCase();
            options.forEach((opt) => {
                const key = opt.dataset.search || opt.textContent.toLowerCase();
                const match = q === '' || key.includes(q);
                opt.hidden = !match;
            });
        });
    });
}

/* ── Konfirmasi aksi destruktif via dialog Bootstrap native ─────────────── */
function initConfirmActions() {
    document.querySelectorAll('[data-confirm]').forEach((el) => {
        el.addEventListener('click', (e) => {
            const msg = el.dataset.confirm || 'Apakah Anda yakin?';
            if (!window.confirm(msg)) {
                e.preventDefault();
                e.stopPropagation();
            }
        });
    });
}
