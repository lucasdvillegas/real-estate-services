/*
| Public website interactions. Vanilla JS on purpose: the Blade site does not
| need Vue/Inertia for this.
*/

const initMobileMenu = () => {
    const panel = document.getElementById('mobile-menu');

    if (!panel) {
        return;
    }

    const openButtons = document.querySelectorAll('[data-menu-open]');
    const closeButtons = panel.querySelectorAll('[data-menu-close]');
    const firstLink = panel.querySelector('[data-menu-link]');
    let lastFocused = null;

    const open = () => {
        lastFocused = document.activeElement;
        panel.hidden = false;
        document.body.classList.add('overflow-hidden');
        openButtons.forEach((button) =>
            button.setAttribute('aria-expanded', 'true'),
        );
        firstLink?.focus({ preventScroll: true });
    };

    const close = () => {
        panel.hidden = true;
        document.body.classList.remove('overflow-hidden');
        openButtons.forEach((button) =>
            button.setAttribute('aria-expanded', 'false'),
        );

        if (lastFocused instanceof HTMLElement) {
            lastFocused.focus({ preventScroll: true });
        }
    };

    openButtons.forEach((button) => {
        button.setAttribute('aria-expanded', 'false');
        button.addEventListener('click', open);
    });

    closeButtons.forEach((button) => button.addEventListener('click', close));

    panel
        .querySelectorAll('a')
        .forEach((link) => link.addEventListener('click', close));

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !panel.hidden) {
            close();
        }
    });
};

const initHeaderShadow = () => {
    const header = document.getElementById('site-header');

    if (!header) {
        return;
    }

    const update = () => {
        header.classList.toggle(
            'shadow-[0_1px_0_0_var(--color-line)]',
            window.scrollY > 8,
        );
    };

    update();
    window.addEventListener('scroll', update, { passive: true });
};

const boot = () => {
    initMobileMenu();
    initHeaderShadow();
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
} else {
    boot();
}
