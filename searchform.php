<form role="search" method="get" class="search-form form-inline" action="<?php echo home_url( '/' ); ?>">
    <input type="search" class="form-control input-search" placeholder="<?php echo esc_attr_x( 'Search', 'eden' ) ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label' ) ?>" />
    <input type="submit" class="btn btn-primary btn-search" value="<?php echo esc_attr_x( 'Search', 'submit button' ) ?>" />
</form>