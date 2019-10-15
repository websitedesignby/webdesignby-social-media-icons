 function webdesignby_add_social_media_icon(id, id_base, number){
    
    
    var add_icon = jQuery("#" + id + " .webdesignby-social-media-icons-add-icon");
    var url_instruction = "Enter the full URL of the social media site above.";
    var p_container = jQuery("<div />");
    var p = jQuery('<p />');
    var select_label = jQuery('<label />'), url_label = jQuery('<label />');
    var select = jQuery('<select />');
    var selects = jQuery(add_icon).find('select');
    var select_num =  selects.length;
    var select_id = id + '_select' + select_num;
    var select_name = 'widget-' + id_base + '[' + number + '][sites][]';
    var options = webdesignby_add_social_media_icon_options();
    var url_container = jQuery("<div />");
    var url_container_id = id + "_url_container" + select_num;
    var url_field = jQuery("<input />");
    var input_id = id + '_url' + select_num;
    var input_name = 'widget-' + id_base + '[' + number + '][urls][]';
    var remove_link = jQuery("<a />");
    var idx;
    var site_containers;
    
    site_containers = jQuery("#" + id + " .social-media-icon");
    // console.log("count = " + jQuery(site_containers).length);
    idx = jQuery(site_containers).length + 1;
    p_container_id = "site-container-" + idx;
    jQuery(p_container).attr("id", p_container_id);
    jQuery(p_container).addClass("social-media-icon");
    
    jQuery(select).attr('id', select_id);
    jQuery(select).attr('name', select_name);
    for(i=0; i<options.length; i++){
        option = jQuery('<option />');
        jQuery(option).attr('value', options[i].id);
        jQuery(option).html( options[i].name );
        jQuery(select).append(option);
    }
    
    jQuery(select_label).attr('for', select_name);
    jQuery(select_label).html("Site: ");
    jQuery(p).append(select_label);
    jQuery(p).append(select);
    
    jQuery(p).append('<br />');
    
    jQuery(url_label).attr('for', input_name);
    jQuery(url_label).html("URL: ");
    jQuery(url_container).attr("id", url_container_id);
    jQuery(url_container).css('display', 'none');
    jQuery(url_container).append(url_label);
    jQuery(url_container).append('<br />');
    jQuery(url_field).addClass('widefat');
    jQuery(url_field).attr('id', input_id);
    jQuery(url_field).attr('type', 'text');
    jQuery(url_field).attr('name', input_name);
    jQuery(url_container).append(url_field);
    jQuery(url_container).append('<br />');
    jQuery(url_container).append(url_instruction);
    jQuery(p).append(url_container);
    jQuery(p).append('<br />');
    jQuery(remove_link).attr("href", "javascript:;");
    jQuery(remove_link).html("Remove");
    jQuery(remove_link).click(function(){
            // console.log("remove " + p_container);
            jQuery(p_container).remove();
        });
    jQuery(p).append(remove_link);
    jQuery(p_container).append(p);
    
    jQuery(add_icon).append(p_container);
    
    jQuery("#" + select_id).change(
            function(){
                var val = jQuery(this).val();
                for(i=0; i<options.length; i++){
                    if( options[i].id === val){
                      jQuery('#' + input_id).val(options[i].url);  
                      jQuery("#" + url_container_id).css('display', 'block');
                    }
                }
            }
        );
}

 function webdesignby_remove_social_media_icon(id){
    // console.log("remove " + id);
    jQuery("#" + id).remove();
 }

function webdesignby_populate_social_media_icon_options(id, selected){
    select = jQuery("#" + id);
    options = webdesignby_add_social_media_icon_options();
     for(i=0; i<options.length; i++){
        option = jQuery('<option />');
        jQuery(option).attr('value', options[i].id);
        jQuery(option).html( options[i].name );
        // console.log(selected + " === " + options[i].id);
        if(selected === options[i].id){
            jQuery(option).prop('selected', true);
        }
        jQuery(select).append(option);
    }
}

function webdesignby_add_social_media_icon_options(){
    
    var prefix = 'webdesignby_smi_';
    
    var options = [
        {
            id: '',
            name: 'Select an option...',
            url: ''
        },
        {
            id: prefix + 'fb',
            name: 'Facebook',
            url: 'https://www.facebook.com/'
        },
        {
            id: prefix + 'twitter',
            name: 'Twitter',
            url: 'https://twitter.com/'
        },
        {
            id: prefix + 'g_plus',
            name: 'Google Plus',
            url: 'https://plus.google.com/'
        },
        {
            id: prefix + 'linked_in',
            name: 'LinkedIN',
            url: 'https://www.linkedin.com/'
        },
        {
            id: prefix + 'ytube',
            name: 'YouTube',
            url: 'https://www.youtube.com/'
        },
        {
            id: prefix + 'instagram',
            name: 'Instagram',
            url: 'https://instagram.com/'
        },
        {
            id: prefix + 'pinterest',
            name: 'Pinterest',
            url: 'https://www.pinterest.com/'
        }
        
    ];
    
    return options;
    
 }
