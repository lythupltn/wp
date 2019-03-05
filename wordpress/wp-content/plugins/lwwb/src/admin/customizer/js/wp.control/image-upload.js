lwwb.Control.Wp['image-upload'] = {
    $control: null,
    init: function($ctr) {
        var $document = $ctr? $ctr: $(document);
        const self = this;
        $document.on('click', '.lwwb-control-lwwb-media-upload .image-upload-button, .lwwb-control-lwwb-media-upload .thumbnail, .lwwb-control-lwwb-media-upload .placeholder', function(event) {
            event.preventDefault();
            self.$control = $(this).parents('.lwwb-control-lwwb-media-upload').first();
            var image = wp.media({
                multiple: false
            }).open().on('select', function() {
                // This will return the selected image from the Media Uploader, the result is an object.
                var uploadedImage = image.state().get('selection').first(),
                    previewImage = uploadedImage.toJSON().sizes.full.url,
                    imageUrl,
                    imageID,
                    imageWidth,
                    imageHeight,
                    preview,
                    removeButton;
                if (!_.isUndefined(uploadedImage.toJSON().sizes.medium)) {
                    previewImage = uploadedImage.toJSON().sizes.medium.url;
                } else if (!_.isUndefined(uploadedImage.toJSON().sizes.thumbnail)) {
                    previewImage = uploadedImage.toJSON().sizes.thumbnail.url;
                }
                imageUrl = uploadedImage.toJSON().sizes.full.url;
                imageID = uploadedImage.toJSON().id;
                imageWidth = uploadedImage.toJSON().width;
                imageHeight = uploadedImage.toJSON().height;
                preview = self.$control.find('.placeholder, .thumbnail');
                removeButton = self.$control.find('.image-upload-remove-button');
                if (preview.length) {
                    preview.removeClass().addClass('thumbnail thumbnail-image').html('<img src="' + previewImage + '" alt="" />');
                }
                if (removeButton.length) {
                    removeButton.show();
                }
                self.$control.find('input[data-key="url"]').val(imageUrl).change();
                self.$control.find('input[data-key="id"]').val(imageID).change();
            });
        });
        $document.on('click', '.image-upload-remove-button', function(e) {
            e.preventDefault();
            self.$control = $(this).parents('.lwwb-control-lwwb-media-upload').first();
            var preview,
                removeButton;
            preview = self.$control.find('.placeholder, .thumbnail');
            removeButton = self.$control.find('.image-upload-remove-button');
            self.$control.find('> .image-field-control').hide();
            if (preview.length) {
                preview.removeClass().addClass('placeholder').html('<i class="fa fa-2x fa-image"></i>');
            }
            if (removeButton.length) {
                removeButton.hide();
            }
            self.$control.find('input[data-key="url"]').val('').change();
            self.$control.find('input[data-key="id"]').val('').change();
        });
    },
}
