function confirmDelete(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}


// for status change 
function swalConfirmAjax(title, url, data, onSuccess, onError) {
    Swal.fire({
        title: title,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, proceed',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                success: function(response) {
                    if (onSuccess) onSuccess(response);
                },
                error: function(xhr) {
                    if (onError) {
                        onError(xhr);
                    } else {
                        Swal.fire('Error', 'Something went wrong', 'error');
                    }
                }
            });
        }
    });
}
