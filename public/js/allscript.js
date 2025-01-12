$(document).on('click', '#send_request', function(){
    var request_to = $(this).data('userid');
    // console.log(request_to);
    $.ajax({
        url : '/send-request',
        method : 'POST',
        data : {request_to},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success : function (response) {
            if (response.success) {
                console.log('Friend request sent.')
            }
        }
    })
})


$(document).on('click', '#accept_request', function() {
    var requester_id = $(this).data('userid');
    $.ajax({
        url : '/accept-request',
        method : 'POST',
        data : {requester_id},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success : function (response) {
            if (response.success) {
                console.log('Friend request accepted.')
            }
        }
    })
})


