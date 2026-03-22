<?php
/**
 * Search Form — форма поиска по сайту
 *
 * @package Ergonosphera
 */
?>
<form role="search" method="get" class="ergo-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label for="ergo-search-field" class="screen-reader-text"><?php esc_html_e( 'Искать', 'ergonosphera' ); ?></label>
    <input type="search" id="ergo-search-field" class="ergo-search-form__input" placeholder="<?php esc_attr_e( 'Искать…', 'ergonosphera' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
    <button type="submit" class="ergo-search-form__submit" aria-label="<?php esc_attr_e( 'Искать', 'ergonosphera' ); ?>">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
    </button>
</form>
