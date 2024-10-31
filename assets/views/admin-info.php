<div class="wrap">
    <h2><?php _e( 'My Social Media Information', 'my-social-media' ); ?></h2>
    
    <?php 
        $data = $this->is_show_error_notice ( $this->is_submit ); 
        if( !empty( $data ) ){ ?>
        <div class="notice notice-<?php echo $data["status"] ?> is-dismissible">
            <p><?php echo $data['message'] ?></p>
        </div>
    <?php } ?>

    <form action="" method="post">
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row">
                        <label for="name"><?php _e( 'Name', 'my-social-media' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="name" id="name" class="regular-text" 
                        value="<?php isset( $this->form_info["name"] ) ? esc_attr_e( $this->form_info["name"], 'my-social-media') : '' ;  ?>">
                        
                        <?php if ( ! isset($this->errors['name'] )) { ?>
                            <p class="description"><?php _e('e.g. Jhon Doe', 'my-social-media') ?></p>
                        <?php } ?>

                        <?php if ( isset($this->errors['name'] )) { ?>
                            <p style="color:red;" class="description error"><?php _e ($this->errors['name'], 'my-social-media' ); ?></p>
                        <?php } ?>

                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="bio"><?php _e( 'Bio', 'my-social-media' ); ?></label>
                    </th>
                    <td>
                        <textarea class="regular-text" name="bio" id="bio"><?php isset( $this->form_info["bio"] ) ? esc_attr_e( $this->form_info["bio"], 'my-social-media') : '' ;  ?></textarea>
                       
                        <?php if ( ! isset($this->errors['bio'] )) { ?>
                            <p class="description"><?php _e('In a few words, explain about yourself.', 'my-social-media') ?></p>
                        <?php } ?>
                        
                        <?php if ( isset($this->errors['bio'] )) { ?>
                            <p style="color:red;" class="description error"><?php _e ($this->errors['bio'], 'my-social-media' ); ?></p>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="email"><?php _e( 'Email', 'my-social-media' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="email" id="email" class="regular-text" value="<?php isset( $this->form_info["email"] ) ? esc_attr_e( $this->form_info["email"], 'my-social-media') : '' ;  ?>">

                        <?php if ( ! isset($this->errors['email'] )) { ?>
                            <p class="description"><?php _e('e.g. admin@example.com', 'my-social-media') ?></p>
                        <?php } ?>

                        <?php if ( isset($this->errors['email'] )) { ?>
                            <p style="color:red;" class="description error"><?php _e ($this->errors['email'], 'my-social-media' ); ?></p>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="phone"><?php _e( 'Phone', 'my-social-media' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="phone" id="phone" class="regular-text" value="<?php isset( $this->form_info["phone"] ) ? esc_attr_e( $this->form_info["phone"], 'my-social-media') : '' ;  ?>">
                        <p class="description"><?php _e('e.g. 01234XXXXXX', 'my-social-media') ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="linkedin"><?php _e( 'LinkedIn', 'my-social-media' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="linkedin" id="linkedin" class="regular-text" value="<?php isset( $this->form_info["linkedin"] ) ? esc_attr_e( $this->form_info["linkedin"], 'my-social-media') : '' ;  ?>">
                        <p class="description"><?php _e('e.g. www.example.com', 'my-social-media') ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="youtube"><?php _e( 'Youtube', 'my-social-media' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="youtube" id="youtube" class="regular-text" value="<?php isset( $this->form_info["youtube"] ) ? esc_attr_e( $this->form_info["youtube"], 'my-social-media') : '' ;  ?>">
                        <p class="description"><?php _e('e.g. www.example.com', 'my-social-media') ?></p>
                    </td>
                    
                </tr>
                <tr>
                    <th scope="row">
                        <label for="facebook"><?php _e( 'Facebook', 'my-social-media' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="facebook" id="facebook" class="regular-text" value="<?php isset( $this->form_info["facebook"] ) ? esc_attr_e( $this->form_info["facebook"], 'my-social-media') : '' ;  ?>">
                        <p class="description"><?php _e('e.g. www.example.com', 'my-social-media') ?></p>
                    </td>
                   
                </tr>
                <tr>
                    <th scope="row">
                        <label for="twitter"><?php _e( 'Twitter', 'my-social-media' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="twitter" id="twitter" class="regular-text" value="<?php isset( $this->form_info["twitter"] ) ? esc_attr_e( $this->form_info["twitter"], 'my-social-media') : '' ;  ?>">
                        <p class="description"><?php _e('e.g. www.example.com', 'my-social-media') ?></p>
                    </td>
                    
                </tr>
            </tbody>
        </table>

        <?php wp_nonce_field( 'my-social-media' ); ?>
        <?php submit_button( __( 'Update Changes', 'my-social-media' ), 'primary', 'submit_media_info' ); ?>
    </form>
</div>