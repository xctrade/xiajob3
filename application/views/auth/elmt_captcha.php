<table>

    <?php if ($show_captcha) {
        if ($use_recaptcha) { ?>
    <tr>
        <td colspan="2">
            <div id="recaptcha_image"></div>
        </td>
        <td>
            <a href="javascript:Recaptcha.reload()">Get another CAPTCHA</a>
            <div class="recaptcha_only_if_image"><a href="javascript:Recaptcha.switch_type('audio')">Get an audio CAPTCHA</a></div>
            <div class="recaptcha_only_if_audio"><a href="javascript:Recaptcha.switch_type('image')">Get an image CAPTCHA</a></div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="recaptcha_only_if_image">Enter the words above</div>
            <div class="recaptcha_only_if_audio">Enter the numbers you hear</div>
        </td>
        <td><input type="text" id="recaptcha_response_field" name="recaptcha_response_field" /></td>
        <td style="color: red;"><?php echo form_error('recaptcha_response_field'); ?></td>
        <?php echo $recaptcha_html; ?>
    </tr>
    <?php } else { ?>
    <tr>
        <td colspan="3">
            <p>Enter the code exactly as it appears:</p>
            <?php echo $captcha_html; ?>
        </td>
    </tr>
    <tr>
        <td><?php echo form_label('Confirmation Code', $captcha['id']); ?></td>
        <td><?php echo form_input($captcha); ?></td>
        <td style="color: red;"><?php echo form_error($captcha['name']); ?></td>
    </tr>
    <?php }
    } ?>

</table>