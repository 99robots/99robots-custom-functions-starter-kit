jQuery.noConflict();
jQuery(document).ready(function ($) {
    
    jQuery('#wpss_upload_image_button').click(function() {
        formfield = jQuery('#wpss_upload_image').attr('name');
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        return false;
    });
 
    window.send_to_editor = function(html) {
     imgurl = jQuery('img',html).attr('src');
     jQuery('#wpss_upload_image').val(imgurl);
     tb_remove();
    // alert(imgurl);
     jQuery('#wpss_upload_image_thumb').html("<img height='65' src='"+imgurl+"'/>");
    }
   
});