(function ($) {
    'use strict';
    window.addEventListener("load", function () {
        // store tabs variables
        var tabs = document.querySelectorAll("ul.nav-tabs > li");

        for (var i = 0; i < tabs.length; i++) {
            tabs[i].addEventListener("click", switchTab);
        }

        function switchTab(event) {
            event.preventDefault();

            document.querySelector("ul.nav-tabs li.active").classList.remove("active");
            document.querySelector(".tab-pane.active").classList.remove("active");

            var clickedTab = event.currentTarget;
            var anchor = event.target;
            var activePaneID = anchor.getAttribute("href");

            clickedTab.classList.add("active");
            document.querySelector(activePaneID).classList.add("active");
        }
    });
    window.addEventListener("load", function () {
        this.cache = {};
        this.cache.$gutenberg = $('#editor');
        this.cache.$switchMode = $('#lwwb-gutenberg-button-switch-mode').html();
        if (this.cache.$gutenberg.length > 0) {
            this.cache.$gutenberg.find('.edit-post-header-toolbar').append(this.cache.$switchMode);
        }
    });

   

})(jQuery);
