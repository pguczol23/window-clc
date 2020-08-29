<?php
    if (isset($_POST['submit'])) {
        WindowClc_Admin::saveOptions();
    }
?>
<div class="wrap">
    <h1>Window Calculator Settings</h1>
    <form action="" method="post">
        <input type="hidden" name="options_obj" value="">
    <?php WindowClc_Admin::getOptions() ?>
    <h2>Content Settings</h2>
        <table class="form-table" role="presentation">
            <tbody>
            <tr>
                <th scope="row">HTML Content</th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text"><span>Html Content</span></legend>
                        <p class="submit"><form><input type="submit" name="submit" id="submit" class="button button-primary" value="Generate HTML"></form></p>
                        <p>
                            <textarea name="moderation_keys" rows="10" cols="50" id="moderation_keys"
                                      class="large-text code">
<?php
    $gfile = WINDOW_CLC__PLUGIN_DIR . "inc/generated_html.php";
    if (file_exists($gfile)) {
        include $gfile;
    }
?></textarea>
                        </p>
                    </fieldset>
                </td>
            </tr>
            <tr>
                <th scope="row">CSS Content</th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text"><span>Css Content</span></legend>
                        <p class="submit"><form><input type="submit" name="submit" id="submit" class="button button-primary" value="Generate CSS"></form></p>

                        <p>
                            <textarea name="moderation_keys" rows="10" cols="50" id="moderation_keys"
                                      class="large-text code">
<?php
    $gfile = WINDOW_CLC__PLUGIN_DIR . "inc/generated_css.php";
    $dfile = WINDOW_CLC__PLUGIN_DIR . "inc/default_css.php";
    if (file_exists($gfile) && file_get_contents($gfile) !== "") {
        include $gfile;
    }elseif (file_exists($dfile)) {
        include $dfile;
    }
?>
</textarea>
                        </p>
                    </fieldset>
                </td>
            </tr>
            </tbody>
        </table>
        <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary"
                                 value="Save Changes"></p>
    </form>
</div>