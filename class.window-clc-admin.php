<?php

class WindowClc_Admin {

    private static $notices   = array();

    public static function init() {
        add_action( 'admin_init', array( 'WindowClc_Admin', 'admin_init' ) );
        add_action( 'admin_menu', array( 'WindowClc_Admin', 'admin_menu' ), 5 );
    }

    public static function admin_init() {

    }

    public static function admin_menu() {
        if ( class_exists( 'Jetpack' ) )
            add_action( 'jetpack_admin_menu', array( 'Akismet_Admin', 'load_menu' ) );
        else
            self::load_menu();
    }

    public static function load_menu() {
        if ( class_exists( 'Jetpack' ) ) {
            add_submenu_page( 'jetpack', __( 'Window CLC' , 'WindowCalculator'), __( 'Window CLC' , 'WindowCalculator'), 'manage_options', 'window-clc-config', array( 'WindowClc_Admin', 'display_page' ) );
        }
        else {
            add_options_page( __('Window CLC', 'WindowCalculator'), __('Window CLC', 'WindowCalculator'), 'manage_options', 'window-clc-config', array( 'WindowClc_Admin', 'display_page' ) );
        }
    }

    public static function display_page() {
        self::display_configuration_page();
    }

    public static function display_configuration_page() {

        $file = WINDOW_CLC__PLUGIN_DIR . 'views/conf-page.php';

        include( $file );
    }

    public static function saveOptions() {

        global $wpdb;

        $_POST['options_obj'] = str_replace("\\", "", $_POST['options_obj']);

        $results = json_decode($_POST['options_obj'], true);

    }

    public static function getOptions() {

            global $wpdb;

            $table_name = $wpdb->prefix . "window_clc";

            $res = $wpdb->get_results("SELECT * FROM $table_name");

            if ($res === null || count($res) <= 0) {
                return;
            }

            foreach ($res as $k => $v) {
                $image_id = $v->main_image_id;
                $mimage_id = $v->image_id;
        ?>
            <h2><?=$v->option_name?></h2>
            <div class="form-table option-container" role="presentation">
                <input type="hidden" name="option" value="<?=$v->id?>">
                <div>
                    <p class="option-field">
                        <div>
                            <label for="">Тип</label>
                            <select name="option-type<?=$v->id?>" value="<?=$v->type?>" id="option-type<?=$v->id?>">
                                <option class="level-0" value="1" <?=$v->type == 1 ? 'selected' : '' ?>>Рехау</option>
                                <option class="level-0" value="2" <?=$v->type == 2 ? 'selected' : '' ?>>Брусбокс</option>
                            </select>
                            <label for="option-name<?=$v->id?>">Имя</label>
                            <input name="option-name<?=$v->id?>" type="text" id="option-name<?=$v->id?>" value="<?=$v->option_name?>">
                            <label for="option-value<?=$v->id?>">Сумма</label>
                            <input name="option-value<?=$v->id?>" type="text" id="option-value<?=$v->id?>" value="<?=$v->option_value?>">
                        </div>
                        <div>
                            <label for="option-podvalue<?=$v->id?>">Подоконник отлив</label>
                            <input name="option-podvalue<?=$v->id?>" type="text" id="option-podvalue<?=$v->id?>" value="<?=$v->pod_value?>">
                            <label for="option-monvalue<?=$v->id?>">Монтажные работы</label>
                            <input name="option-monvalue<?=$v->id?>" type="text" id="option-monvalue<?=$v->id?>" value="<?=$v->mon_value?>">
                            <label for="">Изображение</label>
                            <?php if( $image = wp_get_attachment_image_src( $image_id ) ) {

                                echo '<a href="#" class="window-clc-upl"><img width="200px" height="200px" src="' . $image[0] . '" /></a>
                                              <a href="#" class="window-clc-rmv">Remove image</a>
                                              <input data-hidden-image type="hidden" name="option-mainimg' . $v->id . '" value="' . $image_id . '">';
                            } else {
                                echo '<a href="#" class="window-clc-upl">Upload image</a>
                                            <a href="#" class="window-clc-rmv" style="display:none">Remove image</a>
                                            <input data-hidden-image type="hidden" name="option-mainimg' . $v->id . '" value="">';
                            }
                            ?>
                            <label for="">Мини изображение</label>
                            <?php if( $image = wp_get_attachment_image_src( $mimage_id ) ) {
                                echo '<a href="#" class="window-clc-upl"><img width="200px" height="200px"  src="' . $image[0] . '" /></a>
                                                  <a href="#" class="window-clc-rmv">Remove image</a>
                                                  <input data-hidden-image type="hidden" name="option-minimg' . $v->id . '" value="' . $image_id . '">';
                            } else {
                                echo '<a href="#" class="window-clc-upl">Upload image</a>
                                                <a href="#" class="window-clc-rmv" style="display:none">Remove image</a>
                                                <input data-hidden-image type="hidden" name="option-minimg' . $v->id . '" value="">';
                            }
                            ?>
                        </div>
                    </p>
                </div>
            </div>
            <br><br>
            <br><br>
            <?php
        }
    }

}