lwwb.Builder.Mn.Views['image'] = lwwb.Builder.Mn.Views['elmn'].extend({
    onRender() {
        let eData = this.model.get('elmn_data');

        if ((eData['image_lightbox'] === 'yes') && (eData['link_to'] === 'media_file')) {
            $(this.$el.find('a')).addClass('lwwb-image');
            $('.lwwb-image').magnificPopup({
                type: 'image'
            });
        }
        if (eData['image_hover_animation']){
            this.$el.find('.lwwb-elmn-content img').addClass('lwwb-animation-'+eData['image_hover_animation']);
        }

    },
    onUpdateImage(childView, dataKey, data) {
        this.render();
    },
    onUpdateImageSize(childView, dataKey, data) {
        this.render();
    },
    onUpdateCaptionType(childView, dataKey, data) {
        this.render();
    },
    onUpdateLinkTo(childView, dataKey, data) {
        this.render();
    },
    onUpdateCustomImageLinkTo(childView, dataKey, data) {
        this.render();
    },
    onUpdateImageCustomCaption(childView, dataKey, data) {
        this.render();
    },
    onUpdateImageCustomCaption(childView, dataKey, data) {
        this.render();
    },
    onUpdateImageHoverAnimation(childView, dataKey, data) {
        $(this.$el.find('.lwwb-elmn-content img')).removeClass(function (index, css) {
            return (css.match(/\blwwb-animation-\S+/g) || []).join(' ');
        }).addClass('lwwb-animation-' + data);
    },



    onUpdateImageLightbox(childView, dataKey, data) {
        this.render();
        if ('yes' === data) {
            $('.lwwb-image').magnificPopup({
                type: 'image'
            });
        }
    },

    _getAttachmentData() {
        let eData = this.model.get('elmn_data');
        let id = eData.image.id;
        let url = eData.image.url;
        let self = this;
        if ('undefined' === typeof wp.media.attachment(id).get('caption')) {
            wp.media.attachment(id).fetch().then(function (data) {
                self.render();
            });
        }

        return {
            caption: wp.media.attachment(id).get('caption'),
            alt: wp.media.attachment(id).get('alt'),
            title: wp.media.attachment(id).get('title'),
            sizes: wp.media.attachment(id).get('sizes')
        }
    }


});