<?php

class WindowClc_Admin {

    private static $notices   = array();

    public static function init() {

	    add_shortcode( 'get_calculator' , function () {
		    self::generateHTML();
		    self::generateCSS();

		    wp_enqueue_style( 'window-clc-style', plugins_url(WINDOW_CLC__NAME . '/inc/generated_css.css'));
		    wp_enqueue_script( 'window-clc-script', plugins_url( WINDOW_CLC__NAME . '/inc/calculator-clc.js'), array('jquery'), '1.0.0', true );
	    });
    }

    public static function admin_init() {
	    add_action( 'admin_menu', array( 'WindowClc_Admin', 'admin_menu' ), 5 );
    }

    public static function admin_menu() {
        if ( class_exists( 'Jetpack' ) )
            add_action( 'jetpack_admin_menu', array( 'WindowClc_Admin', 'load_menu' ) );
        else
            self::load_menu();
    }

    public static function generateHTML () {
	    $file = WINDOW_CLC__PLUGIN_DIR . 'inc/generated_html.php';
	    $content = '';
	    try{
		    $content = file_get_contents($file);
        }catch (Exception $e){
        }

	    if (!($content !== null || $content !== '')) {
		    include($file);
	    }else {
            global $wpdb;
		    $table_name = $wpdb->prefix . "window_clc";

		    $results = $wpdb->get_results("SELECT * FROM $table_name");

		    $html = "<div class=\"section calculator-section\">
                        <div class=\"container\">
                            <div class=\"row\">
                                <div class=\"col-md-12\">
                                    <h1>Калькулятор цены окна</h1>
                                </div>
                            </div>
                            <div class=\"row choose-view\">
                                <div class='radio'>
                                    <input type='radio' id='choice1' value='1' name='choose-view' checked>
                                    <label for=\"choice1\">Рехау</label>
                                </div>
                                 <div class='radio'>
                                     <input type='radio' id='choice2' value='2' name='choose-view'>
                                     <label for=\"choice2\">Брусбокс</label>
                                 </div>
                            </div>
                        <div class=\"row base-container\">";

		    $types1Html = "<div class=\"type-container\">
                <div class=\"choose-type-window\">Выберите тип окана:</div>
                <div class=\"window-menu\">";
		    $types2Html = "<div class=\"type-container\" style='display: none'>
                <div class=\"choose-type-window\">Выберите тип окана:</div>
                <div class=\"window-menu\">";

		    $data = [];

		    foreach ($results as $key => $result) {
		        if ($result->type == 1) {
			        $image = wp_get_attachment_image_src( $result->image_id, 'full' );
			        if (!$image) {
			            $image[0] = '';
                    }
		            $types1Html .= "<div class=\"type-window\"><img draggable='false' src='" . $image[0]. "'></div>\r\n";

			        $index = 1;
                }else {
			        $image = wp_get_attachment_image_src( $result->image_id, 'full' );
			        if (!$image) {
				        $image[0] = '';
			        }
			        $types2Html .= "<div class=\"type-window\"><img draggable='false' src='" . $image[0] . "'></div>\r\n";

			        $index = 2;
                }

			    $data[$index][] = [
				    'value' => $result->option_value,
				    'monvalue' => $result->mon_value,
				    'podvalue' => $result->pod_value,
				    'mainimg' => $image[0],
			    ];
            }

		    $types1Html .= "</div></div>";
		    $types2Html .= "</div></div>";

		    $html .= $types1Html;
		    $html .= $types2Html;

		    $image = wp_get_attachment_image_src( ($results[0])->main_image_id );
		    if (!$image) {
			    $image[0] = '';
		    }
            $html .= "<div class=\"row form-container\">
            <div class=\"col-md-5 clearfix\" style=\"padding-left:0px; padding-right:0px;\">
                <div class=\"maket\">
                    <img draggable='false' src='" . $image[0] . "'>
                </div>
            </div>
            <div class=\"col-md-6\" style=\"padding-left:0px; padding-right:0px;\">
                <div class=\"r_block\">
                    <div class=\"oc_line\">
                        <span>Подоконник, отлив:</span>
                        <div class='checkbox'>
                            <input type=\"checkbox\" name=\"need_otliv\" id=\"need_otliv\" class=\"ios-toggle\"/>
                            <label for=\"need_otliv\" class=\"checkbox-label\" data-off=\"НЕТ\" data-on=\"ДА\"></label>
                        </div>
                    </div>
                    <div class=\"oc_line\">
                        <span>Монтажные работы:</span>
                         <div class='checkbox'>
                            <input type=\"checkbox\" name=\"need_montash\" id=\"need_montash\" class=\"ios-toggle\"/>
                            <label for=\"need_montash\" class=\"checkbox-label\" data-off=\"НЕТ\" data-on=\"ДА\"></label>
                        </div>
                    </div>
                    <div class=\"oc_pr_block clearfix\">
                        <div class=\"bl_left\">
                            <span>2907 Р.</span>
                        </div>
                    </div>
                    <div class=\"b_btn okno_send\">
                        Заказать
                    </div>
                </div>
            </div>
        </div>";

		    $html .= "</div></div></div>";
		    file_put_contents($file, $html);

		    var_dump( json_encode($data));
		    echo $html;
        }
    }

	public static function generateCSS() {
		$file = WINDOW_CLC__PLUGIN_DIR . 'inc/generated_css.css';
		$file_def = WINDOW_CLC__PLUGIN_DIR . 'inc/default_css.php';
		$content = '';
		try{
			$content = file_get_contents($file);
		}catch (Exception $e){
		}

		if ($content !== null || $content !== '') {
//			include ($file);
		}else {
//            include ($file_def);
		}
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
        $table_name = $wpdb->prefix . "window_clc";

        $_POST['options_obj'] = str_replace("\\", "", $_POST['options_obj']);

        $results = json_decode($_POST['options_obj'], true);

        var_dump($results);

        foreach ($results as $key => $result) {
            $r = $wpdb->query("UPDATE $table_name SET 
                 type = ". $result['type'] .", 
                 pod_value = '". $result['podvalue'] ."', 
                 mon_value = '". $result['monvalue'] ."', 
                 option_name = '". $result['name'] ."',
                 option_value = '". $result['value'] ."', 
                 main_image_id = '". $result['mainimg'] ."', 
                 image_id = '". $result['minimg'] ."' 
                 WHERE `id` =" . $result['id']);
        }
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
                            <?php if( $image = wp_get_attachment_image_src( $image_id, 'full' ) ) {

                                echo '<a href="#" data-id="option-mainimg' . $v->id . '" class="window-clc-upl"><img width="200px" height="200px" src="' . $image[0] . '" /></a>
                                              <a href="#" data-id="option-mainimg' . $v->id . '" class="window-clc-rmv">Remove image</a>
                                              <input data-hidden-image type="hidden" name="option-mainimg' . $v->id . '" value="' . $image_id . '">';
                            } else {
                                echo '<a href="#" data-id="option-mainimg' . $v->id . '" class="window-clc-upl">Upload image</a>
                                            <a href="#" data-id="option-mainimg' . $v->id . '" class="window-clc-rmv" style="display:none">Remove image</a>
                                            <input data-hidden-image type="hidden" name="option-mainimg' . $v->id . '" value="">';
                            }
                            ?>
                            <label for="">Мини изображение</label>
                            <?php if( $image1 = wp_get_attachment_image_src( $mimage_id, 'full' ) ) {
                                echo '<a href="#" data-id="option-minimg' . $v->id . '" class="window-clc-upl"><img width="200px" height="200px"  src="' . $image1[0] . '" /></a>
                                                  <a href="#" data-id="option-minimg' . $v->id . '" class="window-clc-rmv">Remove image</a>
                                                  <input data-hidden-image type="hidden" name="option-minimg' . $v->id . '" value="' . $mimage_id . '">';
                            } else {
                                echo '<a href="#" data-id="option-minimg' . $v->id . '" class="window-clc-upl">Upload image</a>
                                                <a href="#" data-id="option-minimg' . $v->id . '" class="window-clc-rmv" style="display:none">Remove image</a>
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