var deleteButtonEnable = function(parentTag) {
    if (!parentTag)
        var parentTag = 'tr';

    $(document).ready(function() {
        $('.button.delete').confirmation({
            singleton: true,
            popout: true,
            onConfirm: function() {
                link = $(this).parents('.popover').prev('a');
                deleteRow(link, function(){}, parentTag);
                return false;
            }
        });
    });
};
