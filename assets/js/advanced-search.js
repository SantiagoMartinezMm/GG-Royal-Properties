jQuery(document).ready(function($) {
  $('#advanced-search-form').on('submit', function(e) {
      e.preventDefault();

      let formData = $(this).serialize();
      let searchResultsContainer = $('#search-results-container');

      $.ajax({
          url: ggAdvancedSearchData.ajaxurl,
          type: 'POST',
          data: {
              action: 'gg_advanced_property_search',
              nonce: ggAdvancedSearchData.nonce,
              formData: formData
          },
          beforeSend: function() {
              searchResultsContainer.html('<p>Cargando resultados...</p>');
          },
          success: function(response) {
              if (response.success) {
                  let results = response.data;
                  let html = '';

                  if (results.length > 0) {
                      $.each(results, function(index, property) {
                          html += `
                              <div class="property-card">
                                  <div class="property-thumbnail">
                                      <a href="${property.permalink}">
                                          <img src="${property.thumbnail}" alt="${property.title}">
                                      </a>
                                  </div>
                                  <div class="property-details">
                                      <h2 class="property-title">
                                          <a href="${property.permalink}">${property.title}</a>
                                      </h2>
                                      <div class="property-price">${property.price}</div>
                                      <div class="property-location">${property.location}</div>
                                  </div>
                              </div>`;
                      });
                  } else {
                      html = '<p>No se encontraron propiedades.</p>';
                  }

                  searchResultsContainer.html(html);
              } else {
                  searchResultsContainer.html('<p>Error al realizar la búsqueda. Por favor intenta nuevamente.</p>');
              }
          },
          error: function() {
              searchResultsContainer.html('<p>Error de comunicación con el servidor. Por favor intenta nuevamente.</p>');
          }
      });
  });
});
