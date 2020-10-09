$(document).ready(function () {
    $('#edit-modal').on('show.bs.modal', function (e) {
        let btn = $(e.relatedTarget);
        let category = btn.data('category');
        $("#modal-edit-category").val(category);

    })
});
