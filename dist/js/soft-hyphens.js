/******/ (() => { // webpackBootstrap
/*!******************************!*\
  !*** ./resources/js/bard.js ***!
  \******************************/
Statamic.booting(function () {
  Statamic.$bard.buttons(function () {
    return [{
      name: 'insertHyhpens',
      text: 'Insert Soft Hyphens',
      command: function command(editor) {
        return editor.commands.insertContent('↵');
      },
      html: "\u21B5"
    }];
  });
});
/******/ })()
;