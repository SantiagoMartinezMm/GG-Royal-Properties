<?php
/**
 * Template for the advanced property search form
 */
?>
<div class="property-search-form">
    <form id="advanced-property-search" action="<?php echo esc_url(home_url('/')); ?>" method="get">
        <input type="hidden" name="post_type" value="property">
        
        <div class="search-field">
            <label for="location">Ubicación</label>
            <input type="text" id="location" name="location" placeholder="Ingrese ubicación">
        </div>

        <div class="search-field">
            <label for="property_type">Tipo de Propiedad</label>
            <?php
            wp_dropdown_categories(array(
                'taxonomy' => 'property_type',
                'name' => 'property_type',
                'show_option_all' => 'Todos los tipos',
                'hierarchical' => true
            ));
            ?>
        </div>

        <div class="search-field">
            <label for="price_range">Rango de Precio</label>
            <select name="price_range" id="price_range">
                <option value="">Cualquier precio</option>
                <option value="0-100000">Hasta $100,000</option>
                <option value="100000-200000">$100,000 - $200,000</option>
                <option value="200000-300000">$200,000 - $300,000</option>
                <option value="300000+">Más de $300,000</option>
            </select>
        </div>

        <div class="search-field">
            <label for="property_status">Estado</label>
            <?php
            wp_dropdown_categories(array(
                'taxonomy' => 'property_status',
                'name' => 'property_status',
                'show_option_all' => 'Todos los estados',
                'hierarchical' => true
            ));
            ?>
        </div>

        <button type="submit" class="search-submit">Buscar Propiedades</button>
    </form>
</div>
