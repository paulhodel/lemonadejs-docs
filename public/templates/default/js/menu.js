var menu = (function() {
    var m = document.querySelector('.jmenu');
    if (m.style.display) {
        jSuites.animation.slideLeft(m, 0, function() {
            m.style.display = '';
        });
    } else {
        m.style.display = 'block';
        jSuites.animation.slideLeft(m, 1);
    }
});

menu.loadState = function() {
    if (localStorage) {
        var menu = document.querySelectorAll('.jmenu nav');
        for (var i = 0; i < menu.length; i++) {
            menu[i].classList.remove('selected');
            if (menu[i].getAttribute('data-id')) {
                var state = localStorage.getItem('jmenu-' + menu[i].getAttribute('data-id'));
                if (state == 1) {
                    menu[i].classList.add('selected');
                }
            }
        }
        var href = localStorage.getItem('jmenu-href');
        if (href) {
            var menu = document.querySelector('.jmenu a[href="'+ href +'"]');
            if (menu) {
                menu.classList.add('selected');
            }
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    var actionDown = function(e) {
        if (e.target.tagName == 'H2') {
            if (e.target.parentNode.classList.contains('selected')) {
                e.target.parentNode.classList.remove('selected');
                localStorage.setItem('jmenu-' + e.target.parentNode.getAttribute('data-id'), 0);
            } else {
                e.target.parentNode.classList.add('selected');
                localStorage.setItem('jmenu-' + e.target.parentNode.getAttribute('data-id'), 1);
            }
        } else if (e.target.tagName == 'A') {
            localStorage.setItem('jmenu-href', e.target.getAttribute('href'));
        }
    }

    var m = document.querySelector('.jmenu');
    if (m) {
        if ('ontouchstart' in document.documentElement === true) {
            m.addEventListener('touchstart', actionDown);
        } else {
            m.addEventListener('mousedown', actionDown);
        }

        menu.loadState();
    }
});