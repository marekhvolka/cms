/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

var ckeditorConfig = {
    toolbarGroups: [
        {name: 'styles'},
        {name: 'colors'},
        {name: 'clipboard', groups: ['clipboard', 'undo']},
        {name: 'editing', groups: ['find', 'selection', 'spellchecker']},
        {name: 'links'},
        {name: 'insert'},
        {name: 'tools'},
        {name: 'document', groups: ['mode', 'document', 'doctools']},
        {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
        {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi']},
    ],

    // Remove some buttons provided by the standard plugins, which are
    // not needed in the Standard(s) toolbar.
    removeButtons: 'Underline,Subscript,Superscript',

    // Set the most common block elements.
    format_tags: 'p;h1;h2;h3;pre',

    // Simplify the dialog windows.
    removeDialogTabs: 'image:advanced;link:advanced',

    extraPlugins: 'custimage' //enable custimage tool button
    //config.removePlugins = 'image';
};
