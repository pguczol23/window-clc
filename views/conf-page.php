<?php
    if (isset($_POST['submit'])) {
        WindowClc_Admin::saveOptions();
    }
    if (isset($_POST['generateHTML'])) {
        WindowClc_Admin::generateHTML(true);
    }
    if (isset($_POST['generateCSS'])) {
        WindowClc_Admin::generateCSS();
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
                        <p class="submit"><form><input type="submit" name="generateHTML" id="submit" class="button button-primary" value="Generate HTML"></form></p>
                        <p>
                            <textarea name="html_value" rows="10" cols="50" id="html_value"
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
                        <p class="submit"><input type="submit" name="generateCSS" id="submit" class="button button-primary" value="Generate CSS"></p>

                        <p>
                            <textarea name="css_value" rows="10" cols="50" id="css_value"
                                      class="large-text code">
<?php
    $gfile = WINDOW_CLC__PLUGIN_DIR . "inc/generated_css.css";
    if (file_exists($gfile)) {
        include $gfile;
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