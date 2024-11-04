<?php
/**
 * Template for the property gallery metabox
 */
?>
<div class="property-gallery-container">
    <div id="property-gallery-images" class="gallery-images">
        <?php
        if (is_array($gallery_images)) {
            foreach ($gallery_images as $image_id) {
                echo wp_get_attachment_image($image_id, 'thumbnail');
            }
        }
        ?>
    </div>
    <input type="hidden" name="property_gallery_images" id="property_gallery_images" 
           value="<?php echo esc_attr(implode(',', (array)$gallery_images)); ?>">
    <button type="button" class="button" id="upload_gallery_images">Añadir Imágenes</button>
</div>

<script>
    jQuery(document).ready(function($) {
        var gallery_frame;
        $('#upload_gallery_images').on('click', function(e) {
            e.preventDefault();
            
            if (gallery_frame) {
                gallery_frame.open();
                return;
            }
            
            gallery_frame = wp.media({
                title: 'Seleccionar Imágenes',
                button: {
                    text: 'Añadir a la galería'
                },
                multiple: true
            });
            
            gallery_frame.on('select', function() {
                var attachments = gallery_frame.state().get('selection').toJSON();
                var galleryContainer = $('#property-gallery-images');
                var imageIds = [];
                
                $.each(attachments, function(index, attachment) {
                    galleryContainer.append('<img src="' + attachment.sizes.thumbnail.url + '" alt="">');
                    imageIds.push(attachment.id);
                });
                
                $('#property_gallery_images').val(imageIds.join(','));
            });
            
            gallery_frame.open();
        });
    });
</script>
