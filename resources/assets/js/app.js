
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.$ = window.jQuery = require('jquery');
require('./bootstrap');

require('./analytics');
// Google Analytics
window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};
ga('create', 'UA-40636205-6', 'auto');
ga('set', 'transport', 'beacon');
ga('send', 'pageview');
