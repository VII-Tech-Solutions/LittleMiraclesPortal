import Sortable from 'sortablejs';
jQuery(document).ready(function ($) {
    //this function displays the media grid items that are in the viewable area
    // function LoadGridItems(modalId) {
    //     var mediaGridSelector = modalId + ' .media-grid';
    //     var gridHeight = $(mediaGridSelector).height();
    //     $(mediaGridSelector + ' .preview-container').each(function (index, el) {
    //         if ($(this).offset().top < (gridHeight + 200)) {
    //             var url = $(this).attr('data-url');
    //             $(this).css('backgroundImage', 'url('+url+')');
    //         }
    //     });
    // }

    $(document).on('show.bs.modal','#images-modal', function () {
        $('input[name="media_ids[]"]:checked').prop('checked', false);

        // LoadGridItems('#images-modal');

        //lazy load media grid items based on user's scrolling
        $('.modal-body').scroll(function (e) {
            if ($('.media-grid').attr('data-has-more-image') === 'false' || $('.media-grid').hasClass('is-loading')) {
                return;
            }
            var ele = $(this)[0];
            // LoadGridItems('#images-modal')
            if(ele.scrollHeight - ele.scrollTop === ele.clientHeight){
                var lastMediaGridItem = $('.media-grid label:last-child');
                var lastFetchedMediaId = $(lastMediaGridItem).find('input').val();

                $('.media-grid').addClass('is-loading');
                $.ajax({
                    url: '/admin/fetch-more-media',
                    type: 'GET',
                    data: {
                        last_fetched_media_id: lastFetchedMediaId
                    }
                }).then(function (response) {
                    console.log('response', response);
                    $('.media-grid').attr('data-has-more-image', response.has_more_media);
                    for(var i=0; i < response.media.length; i++) {
                        var currentMediaItem = response.media[i];
                        var newGridItem = lastMediaGridItem.clone();
                        newGridItem.find('input').val(currentMediaItem.id);
                        newGridItem.find('.preview-container').attr('data-media-id', currentMediaItem.id)
                            .attr('data-url', currentMediaItem.url)
                            .css('backgroundImage', 'url('+currentMediaItem.url+')');
                        $('.media-grid').append(newGridItem);
                    }
                }).always(function () {
                    $('.media-grid').removeClass('is-loading');
                });
            }
        });
    });

    var el = document.getElementById('media-items');
    var sortable = Sortable.create(el);

    $("#form").show();

    $('#form').submit(function() {
        $('#content').waitMe({
            effect:"bounce"
        });
        return true;
    });

    $(document).on('click', '.btn-confirm-media-selection', function () {
        $('#content').waitMe({
            effect:"bounce"
        });
        var related_table_id = $('.image-grid');
        $('input[name="media_ids[]"]:checked').each(function () {
            var media_id = $(this).val();

            var all_media = $(".image-grid input[name='media_ids[]']") .map(function(){return $(this).val();}).get();
            if($.inArray(String(media_id), all_media) !== -1){
                return;
            }

            var url  = $(this).next().data('url');
            var row_template = "<div class=\"col-sm-2 col-md-2 image-item\">" +
                "<div class=\"panel panel-default\">" +
                    "<div class=\"panel-body image-area\">" +
                        "<div class=\"preview-container\" data-media-id=\""+media_id+"\" data-url=\""+url+"\" style=\"background-image: url("+url+");\n" +
                            " background-size: cover; width: 100% !important; background-position: center;\"></div>" +
                            "<a class=\"remove-image\" href=\"#\" style=\"display: inline;\">&#215;</a>" +
                            "<input type='hidden' name='media_ids[]' value='"+media_id+"'>" +
                    "</div>" +
                "</div>" +
            "</div>";
            $(related_table_id).append(row_template);
        });
        $('.modal').modal('hide');
        $('button[type=submit]').click();
    });

    $(document).on('click', '.btn-remove-media', function () {
       $(this).closest('tr').remove();
    });

    $(document).on('click', '.remove-image', function (e) {
        e.preventDefault();
        $(this).closest('.image-item').remove();
    });

    $('#btn-select-image').click(function (e) {
        e.preventDefault();
        $('#images-modal').modal();
    });

    $('#btn-upload-image').click(function (e) {
        e.preventDefault();
        $('#upload-modal').modal();
    });
});
