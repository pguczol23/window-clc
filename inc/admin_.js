jQuery(function($){

    let els = $('.option-container');
    let count = $('.option-container').length;

    const uploadBtnClick = function(e){

        e.preventDefault();

        let button = $(e.target),
            custom_uploader = wp.media({
                title: 'Insert image',
                library : {
                    // uploadedTo : wp.media.view.settings.post.id, // attach to the c``urrent post?
                    type : 'image'
                },
                button: {
                    text: 'Use this image' // button label text
                },
                multiple: false
            }).on('select', function() { // it also has "open" and "close" events
                let attachment = custom_uploader.state().get('selection').first().toJSON();
                button.parent().find('[name="' + button.attr('data-id') + '"][data-hidden-image]').val(attachment.id);
                button.html('<img width="200px" height="200px" src="' + attachment.url + '">').next().val(attachment.id).next().show();
            }).open();
    }

    const removeBtnClick = function(e){
        e.preventDefault();

        let button = $(e.target);
        button.next().val(''); // emptying the hidden field
        button.parent().find('[name="' + button.attr('data-id') + '"][data-hidden-image]').val('');
        button.hide().prev().html('Upload image');
    }

    const genOptionsObj = () => {
        let opt = {};

        let options = els.find('[name="option"]');

        for (let i = 1; i <= options.length; i++) {
            let el = $(options.get(i-1));
            opt[i] = {
                id: el.val(),
                type: els.find('[name="option-type'+el.val()+'"]').val(),
                name: els.find('[name="option-name'+el.val()+'"]').val(),
                value: els.find('[name="option-value'+el.val()+'"]').val(),
                podvalue: els.find('[name="option-podvalue'+el.val()+'"]').val(),
                monvalue: els.find('[name="option-monvalue'+el.val()+'"]').val(),
                mainimg: els.find('[name="option-mainimg'+el.val()+'"]').val(),
                minimg: els.find('[name="option-minimg'+el.val()+'"]').val(),
            };
        }
        return opt;
    }

    const reloadEvents = () => {
        $('.window-clc-upl').unbind('click');
        $('.window-clc-rmv').unbind('click');

        $('.window-clc-upl').on( 'click', (e) => {uploadBtnClick(e)});
        $('.window-clc-rmv').on('click', (e) => {removeBtnClick(e)});

        $('[name="options_obj"]').val(JSON.stringify(genOptionsObj()));
    }

    $('form').on('submit', function (e){
        $('[name="options_obj"]').val(JSON.stringify(genOptionsObj()));
    });

    reloadEvents();
});