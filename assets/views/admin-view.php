<div class="wetuts-bio-wrap">
        <div class="avatar-image">
            <?php echo get_avatar( $author->ID, 64 ); ?>
        </div>

        <div class="wetuts-bio-content">
            <div class="author-name"><?php echo $data["name"]; ?></div>

            <div class="wetuts-author-bio">
                <?php echo wpautop( wp_kses_post( $data["bio"] ) ); ?>
            </div>
            <ul class="wetuts-socials">
                <?php if (  $data["email"] ) { ?>
                    <li><a href="<?php echo esc_html_e( "mailto:".$data["email"] ); ?>"><?php _e( 'Email', 'wetuts' ); ?></a></li>
                <?php } ?>

                <?php if ( ! empty( $data["twitter"] ) ) { ?>
                    <li><a href="<?php echo esc_url( $data["twitter"] ); ?>"><?php _e( 'Twitter', 'wetuts' ); ?></a></li>
                <?php } ?>

                <?php if ( ! empty( $data["facebook"] ) ) { ?>
                    <li><a href="<?php echo esc_url( $data["facebook"] ); ?>"><?php _e( 'Facebook', 'wetuts' ); ?></a></li>
                <?php } ?>

                <?php if ( ! empty( $data["linkedin"] ) ) { ?>
                    <li><a href="<?php echo esc_url( $data["linkedin"] ); ?>"><?php _e( 'LinkedIn', 'wetuts' ); ?></a></li>
                <?php } ?>

                <?php if ( ! empty( $data["youtube"] ) ) { ?>
                    <li><a href="<?php echo esc_url( $data["youtube"] ); ?>"><?php _e( 'Youtube', 'wetuts' ); ?></a></li>
                <?php } ?>
            </ul>
        </div>
</div>