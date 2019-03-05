(function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
"use strict";

(function ($) {
  $(document).ready(function () {
    // Menu
    // Check for click events on the navbar burger icon
    $('.lwwb-elmn-navigation .navbar-burger').click(function () {
      // Toggle the 'is-active' class on both the 'navbar-burger' and the 'navbar-menu'
      $('.navbar-burger').toggleClass('is-active');
      $('.navbar-menu').toggleClass('is-active');
      $('.lwwb-navigation').toggleClass('lwwb-mobile');
    }); //video popup

    var dataLightbox = $('.lwwb-video-bg-overlay .lwwb-play-icon').attr('data-popup');

    if ('yes' === dataLightbox) {
      $('.lwwb-play-icon').magnificPopup({
        type: 'iframe',
        iframe: {
          markup: '<div class="mfp-iframe-scaler">' + '<div class="mfp-close"></div>' + '<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>' + '</div>'
        }
      });
    } else {
      $('.lwwb-play-icon').on('click', function (e) {
        e.preventDefault();
        $('.lwwb-video-bg-overlay').hide();
      });
      $('.lwwb-video-bg-overlay').on('click', function (e) {
        e.preventDefault();
        $('.lwwb-video-bg-overlay').hide();
      });
    }

    $('.lwwb-image').magnificPopup({
      type: 'image'
    });
  }); // Accordion

  lwwb_accordion_elmn();

  function lwwb_accordion_elmn() {
    var $accordionEl = $('.lwwb-elmn-accordion');
    $accordionEl.each(function () {
      var $aEl = $(this);
      $aEl.on('click', '.accordion-header', function () {
        var $aHeader = $(this);
        var $aPanel = $aHeader.next('.accordion-panel').not('.active');
        $aEl.find('.accordion-header').removeClass('active');
        $aEl.find('.accordion-panel').removeClass('active').slideUp('fast');
        $aHeader.addClass('active');
        $aPanel.slideDown('fast');
        $aPanel.addClass('active');
      });
    });
  }
})(jQuery);

},{}]},{},[1]);
