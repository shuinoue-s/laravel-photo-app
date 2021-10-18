'use strict';

//メニューバーを表示・非表示
const hamburger_menu = document.getElementById('hamburger-menu');
const menu_wrapper = document.getElementById('menu-wrapper');
const mask_wrapper = document.getElementById('mask-wrapper');

hamburger_menu.addEventListener('click', () => {
    hamburger_menu.classList.toggle('clicked');
    menu_wrapper.classList.toggle('clicked');
    mask_wrapper.classList.toggle('clicked');
});

document.getElementById('mask').addEventListener('click', () => {
    hamburger_menu.classList.toggle('clicked');
    menu_wrapper.classList.toggle('clicked');
    mask_wrapper.classList.toggle('clicked');
});

