/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$('a#i-am-attending').click(function(){
    parent_div = $(this).parents(".row").eq(0);
    attending_button = $(this);
    attendance_text = parent_div.find('#attendance-text');
    $.ajax({
        beforeSend: function(){
            attending_button.html('Please wait ....');
        },
        complete: function(){
            attending_button.remove();
        },
        success: function(data){
            attendance_text.html(data);
        },
        data: {
            event_id : parent_div.attr('id')
            },
        type: "post",
        url: attendance_url

    });
    return false;
});