jQuery(document).ready(function($) {
  $('.favorite-button').on('click', function(e) {
      e.preventDefault();
      
      const button = $(this);
      const propertyId = button.data('property-id');
      
      $.ajax({
          url: ggFavoritesData.ajaxurl,
          type: 'POST',
          data: {
              action: 'toggle_favorite',
              property_id: propertyId,
              nonce: ggFavoritesData.nonce
          },
          success: function(response) {
              if (response.success) {
                  if (response.data.status === 'added') {
                      button.addClass('is-favorite');
                      button.attr('title', 'Quitar de favoritos');
                  } else {
                      button.removeClass('is-favorite');
                      button.attr('title', 'Añadir a favoritos');
                  }
              }
          }
      });
  });
});
