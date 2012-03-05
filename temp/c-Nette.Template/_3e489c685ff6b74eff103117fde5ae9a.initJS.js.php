<?php //netteCache[01]000269a:2:{s:4:"time";s:21:"0.60297600 1314728156";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:112:"/Users/martin/Web/library/root/libs/Nette.Extras/MultipleFileUpload/UserInterface/Interfaces/Swfupload/initJS.js";i:2;i:1295890998;}}}?><?php
// file /Users/martin/Web/library/root/libs/Nette.Extras/MultipleFileUpload/UserInterface/Interfaces/Swfupload/initJS.js
//

$_cb = NLatteMacros::initRuntime($template, NULL, 'e0c95a7105'); unset($_extends);

if (NSnippetHelper::$outputAllowed) {
?>
(function($){

    $("#<?php echo $swfuId ?>").swfupload({
            flash_url : <?php echo $template->escapeJS(NEnvironment::expand("%baseUri%swf/MultipleFileUpload/swfupload/swfupload.swf")) ?>,
            flash9_url : <?php echo $template->escapeJS(NEnvironment::expand("%baseUri%swf/MultipleFileUpload/swfupload/swfupload_fp9.swf")) ?>,
            upload_url: <?php echo $template->escapeJS($backLink) ?>,
            post_params: {
                token : <?php echo $template->escapeJS($token) ?>,
                sender: "MFU-Swfupload"
            },

            file_size_limit : <?php echo $template->escapeJS($sizeLimit) ?>,
            file_types : "*.*",
            file_types_description : "All Files",
            file_upload_limit : <?php echo $template->escapeJS($maxFiles) ?>,

            custom_settings : {
                    progressTarget : "<?php echo $swfuId ?>progress",
                    cancelButtonId : "<?php echo $swfuId ?>btnCancel"
            },
            debug: false,

            // Button settings
            button_image_url: <?php echo $template->escapeJS(NEnvironment::expand("%baseUri%images/MultipleFileUpload/swfupload/XPButtonUploadText_89x88.png")) ?>,
            button_width: "89",
            button_height: "22",
            button_placeholder_id : "<?php echo $swfuId ?>placeHolder",
    });

    return true;

})(jQuery);<?php
}
