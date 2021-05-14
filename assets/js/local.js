var json_data;

$(function () {
    Local.init();
});
$(document).on("loaded", function () {
    Local.listen();
});
$(document).on("edit.local", function (ev) {
    Local.edit(ev.element);
});
$(document).on("local.saved", function (ev) {
    json_data = ev.response.data;
    Local.populate();
    Local.close();
});


var MainFunction, BootAdmin;

var Local = function () {
    "use strict";
    return {
        init: function () {
            Local.populate();
        },
        listen: function () {
            $('.btn-local').off('click').bind('click', function (ev) {
                
            });
            
        },
        populate: function () {
            $('#list-data').html('');
            $.each(json_data, function (i, line){
                console.log(line);
                var item = $('#list-sampler').find('li').clone();
                
                
                $('#list-data').append(item);
            });
            Local.listen();
        },
        edit: function (form) {
            
            var item = form.closest('.list-item').attr('data-id');
            var action = form.closest('.list-item').find('.btn-edit-item').attr('data-post-route') + item;
            form.attr('action', action);
            $.each(json_data, function (s, line) {
                if (parseInt(line.id) === parseInt(item)) {
                    form.find('[name="name"]').val(line.name);
                }

            });
            BootAdmin.scan();
        },
        close: function (){
            $('#section-local').find('.btn-close-item').hide();
            $('#section-local').find('.btn-add-item').show();
        }
    };
}();


