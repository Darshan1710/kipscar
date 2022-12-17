$(document).ready(function(){
	$(document).on('click','.delete',function(){

		if(confirm('Are you sure you want to delete ?')){
			id = $(this).attr('id');
			href = $(this).data('url');
		
            $.ajax({
                    type: 'post',
                    data: {id:id},
                    url: href,
                    success: function(data) {
                        var obj = $.parseJSON(data);
                        alert(obj.message);
                        window.location.reload();
                    }

                });
		}
		
	});

    $('.delete_address').on('click',function(){
            
            var base_url = $('#base_url').val();
            var id = $(this).attr('id');

            if(confirm('Are you sure you want to delete?')){
                $.ajax({
                    type: 'post',
                    data: {id:id},
                    url: base_url + 'Customer/delete',
                    success: function(data) {
                        var obj = $.parseJSON(data);
                        if (obj.errCode == -1) {
                            
                            alert(obj.message);
                            window.location.reload();
                        } else if (obj.errCode == 2) {
                            alert(obj.message);
                        } else if (obj.errCode == 3) {
                            $('.error').remove();
                            $.each(obj.message, function(key, value) {
                                var element = $('#' + key);
                                element.closest('.form-control').after(value);
                                
                                
                            });
                        }else if(obj.errCode == 5){
                          $('.error-div').empty();
                          $('.error-div').append(obj.message);
                        }

                    }

                });
            }

        });

        $('.delete_all').on('click',function(){
            
            var base_url = $('#base_url').val();
            var checkboxes = $('.check:checked').length;

            var ids = [];
            $('.check:checked').each(function(i){
              ids[i] = $(this).val();
            });
        
            if(checkboxes > 0){
            if(confirm('Are you sure you want to delete?')){
                $.ajax({
                    type: 'post',
                    data: {ids:ids},
                    url: base_url + 'Customer/multipleDelete',
                    success: function(data) {
                        var obj = $.parseJSON(data);
                        if (obj.errCode == -1) {
                            
                            alert(obj.message);
                            window.location.reload();
                        } else if (obj.errCode == 2) {
                            alert(obj.message);
                        } else if (obj.errCode == 3) {
                            $('.error').remove();
                            $.each(obj.message, function(key, value) {
                                var element = $('#' + key);
                                element.closest('.form-control').after(value);
                                
                                
                            });
                        }else if(obj.errCode == 5){
                          $('.error-div').empty();
                          $('.error-div').append(obj.message);
                        }

                    }

                });
            }
            }else{
                alert('Please Select Atleast one record');
            }

        });

        $("#select-all").click(function(){
            $('.check').not(this).prop('checked', this.checked);
        });

});