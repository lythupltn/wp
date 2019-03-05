lwwb.Builder.Mn.Views['video'] = lwwb.Builder.Mn.Views['elmn'].extend({
    onRender() {
        this.renderVideo();
        this.renderOverlay();
        this.renderLightbox();
        this.renderPlayIcon();
    },
    renderVideo() {
        let eData = this.model.get('elmn_data');
        let sourceType = eData['source_type'];
        let linkVideo = eData[sourceType + '_link'];
        if (!linkVideo) {
            this.$el.find('.lwwb-video-wrapper').html('<div class="lwwb-image-placeholder"><i class="fa fa-2x fa-video-camera" aria-hidden="true"></i></div>');
        } else {
            this.renderVideoAjax(linkVideo);
        }
    },

    renderOverlay() {
        let eData = this.model.get('elmn_data');
        let $bgOverlayEl = this.$el.find('.lwwb-video-bg-overlay');
        if (('yes' !== eData['image_overlay_switch'])) {
            $bgOverlayEl.hide();
        } else {
            $bgOverlayEl.show();

            if(!eData['bg_overlay_img']['url']){
                $bgOverlayEl.css('background-color','#dedede');
            }
        }
    },

    renderLightbox() {
        let eData = this.model.get('elmn_data');
        let $btnPlay = this.$el.find('.lwwb-play-icon');
        let $bgover = this.$el.find('.lwwb-video-bg-overlay');
        let self = this;
        if ('yes' === eData['video_lightbox']) {
            self.showVideoLightbox();
        } else {
            $(document).on('click',$btnPlay, function (e) {
                $('.lwwb-video-bg-overlay').hide();
                e.preventDefault();
            });
            $bgover.on('click', function (e) {
                $('.lwwb-video-bg-overlay').hide();
                e.preventDefault();
            });
        }
    },

    renderPlayIcon() {
        let eData = this.model.get('elmn_data');
        let $playIconEl = this.$el.find('.lwwb-play-icon');

        if ('yes' === eData['switch_play_icon']) {
            $playIconEl.show();
        } else {
            $playIconEl.hide();
        }
    },

    onUpdateSourceType(childView, dataKey, data) {

        this.renderVideo();

    },

    onUpdateYoutubeLink(childView, dataKey, data) {
        if (data) {
            this.renderVideoAjax(data)
        }
    },

    onUpdateVimeoLink(childView, dataKey, data) {
        if (data) {
            this.renderVideoAjax(data)
        }
    },

    onUpdateDailymotionLink(childView, dataKey, data) {
        if (data) {
            this.renderVideoAjax(data)
        }
    },

    onUpdateImageOverlaySwitch(childView, dataKey, data) {
        this.renderOverlay();
    },

    onUpdateSwitchPlayIcon(childView, dataKey, data) {
        this.renderPlayIcon()
    },

    onUpdateVideoLightbox(childView, dataKey, data) {
        this.render();
        this.renderLightbox();
    },

    showVideoLightbox() {
        let self = this;
        let $btnPlay = this.$el.find('.show-lightbox');
        let eData = this.model.get('elmn_data');
        let sourceType = eData['source_type'];
        let linkVideo = eData[sourceType + '_link'];

        $btnPlay.magnificPopup({
            items: {
                src: linkVideo
            },
            type: 'iframe',

            iframe: {
                markup: '<div class="mfp-iframe-scaler">' +
                    '<div class="mfp-close"></div>' +
                    '<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>' +
                    '</div>',
                patterns: {
                    youtube: {
                        index: 'youtube.com/', // String that detects type of video (in this case YouTube). Simply via url.indexOf(index).

                        id: 'v=', // String that splits URL in a two parts, second part should be %id%
                        // Or null - full URL will be returned
                        // Or a function that should return %id%, for example:
                        // id: function(url) { return 'parsed id'; }

                        src: '//www.youtube.com/embed/%id%?autoplay=1' // URL that will be set as a source for iframe.
                    },
                    vimeo: {
                        index: 'vimeo.com/',
                        id: '/',
                        src: '//player.vimeo.com/video/%id%?autoplay=1'
                    },
                    dailymotion: {
                        index: 'dailymotion.com',
                        id: function (url) {
                            var m = url.match(/^.+dailymotion.com\/(video|hub)\/([^_]+)[^#]*(#video=([^_&]+))?/);
                            if (m !== null) {
                                if (m[4] !== undefined) {

                                    return m[4];
                                }
                                return m[2];
                            }
                            return null;
                        },
                        src: 'https://www.dailymotion.com/embed/video/%id%'
                    },
                },
                srcAction: 'iframe_src',
            },

            midClick: true,

            callbacks: {
                close: function () {
                    self.renderOverlay();
                    self.renderPlayIcon();
                },
            }
        });
    },

    renderVideoAjax(linkVideo) {
        let self = this;
        $.ajax({
            type: "post",
            url: _lwwbData.config.ajaxUrl,
            data: {
                action: 'get_video_via_ajax',
                link: linkVideo
            },
            success: function (res) {
                if (res.success) {
                    self.$el.find('.lwwb-video-wrapper').html(res.html);
                }
            }
        });
    },

});