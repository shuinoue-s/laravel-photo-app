/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!******************************!*\
  !*** ./resources/js/main.js ***!
  \******************************/
 //メニューバーを表示・非表示

var hamburger_menu = document.getElementById('hamburger-menu');
var menu_wrapper = document.getElementById('menu-wrapper');
var mask_wrapper = document.getElementById('mask-wrapper');
hamburger_menu.addEventListener('click', function () {
  hamburger_menu.classList.toggle('clicked');
  menu_wrapper.classList.toggle('clicked');
  mask_wrapper.classList.toggle('clicked');
});
document.getElementById('mask').addEventListener('click', function () {
  hamburger_menu.classList.toggle('clicked');
  menu_wrapper.classList.toggle('clicked');
  mask_wrapper.classList.toggle('clicked');
});
/******/ })()
;