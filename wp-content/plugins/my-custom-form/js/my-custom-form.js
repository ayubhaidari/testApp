jQuery(document).ready(function($) {
    $('#my-custom-form').on('submit', function(e) {
        e.preventDefault(); 

        $.ajax({
            url: my_custom_form_ajax.ajax_url,
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $('#form-response').html('<p>' + response.data + '</p>');
                }
            },
            error: function() {
                $('#form-response').html('<p>An error occurred.</p>');
            }
        });
    });
});
