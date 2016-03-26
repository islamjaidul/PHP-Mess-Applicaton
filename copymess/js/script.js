/**
 * Created by sohag on 3/24/16.
 */
$(".label-info").click(function() {
    var id = $(this).prop('id');
    $.post('http://localhost/mess/dashboard/accounts/edit', {id: id}, function(data) {
        alert(data);
    })
})
