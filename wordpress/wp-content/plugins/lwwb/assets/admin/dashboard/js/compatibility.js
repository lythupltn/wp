(function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
"use strict";

(function ($, document) {
  'use strict';
  /**
   * The analyze module for Yoast SEO.
   */

  var module = {
    timeout: undefined,
    // Initialize
    init: function init() {
      if (typeof YoastSEO !== 'undefined') {
        // the variable is defined
        addEventListener('load', module.load);
      }
    },
    // Load plugin and add hooks.
    load: function load() {
      YoastSEO.app.registerPlugin('LWWB', {
        status: 'loading'
      }); // Update Yoast SEO analyzer when fields are updated.

      module.listenToField;
      YoastSEO.app.pluginReady('LWWB');
      YoastSEO.app.registerModification('content', module.addContent, 'LWWB', 5); // Make the Yoast SEO analyzer works for existing content when page loads.

      module.update();
    },
    // Add content to Yoast SEO Analyzer.
    addContent: function addContent(content) {
      content += ' ' + getFieldContent();
      return content;
    },
    // Listen to field change and update Yoast SEO analyzer.
    listenToField: function listenToField() {
      var field = document.getElementById('lwwb_meta_content');

      if (field) {
        field.addEventListener('keyup change', module.update);
      }
    },
    // Update the YoastSEO result. Use debounce technique, which triggers only when keys stop being pressed.
    update: function update() {
      clearTimeout(module.timeout);
      module.timeout = setTimeout(function () {
        YoastSEO.app.refresh();
      }, 250);
    }
  };
  /**
   * Get field content.
   * Works for normal inputs and TinyMCE editors.
   *
   * @param fieldId The field ID
   * @returns string
   */

  function getFieldContent() {
    var field = document.querySelector('textarea#lwwb_meta_content');

    if (field) {
      var content = field.value;
      return content ? content : '';
    }

    return '';
  } // Run on document ready.


  $(module.init);
})(jQuery, document);

},{}]},{},[1]);
