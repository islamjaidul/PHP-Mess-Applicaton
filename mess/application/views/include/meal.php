<div class="panel panel-primary">
    <div class="panel-heading">
        <span><a style="color:#ffffff;" href="<?php echo base_url('dashboard/archive/meal')?>">Archive</a></span>
    </div>

    <div class="panel-body">
        <table class="table table-responsive">
            <tr>
                <td>
                    <label>Number of page: </label>
                    <select style="width: 70px; display:inline" name="page" id="page" class="form-control">

                    </select>
                </td>
                <td>
                    <label>Number of rows: </label>
                    <select style="width: 70px; display:inline" name="limit" id="limit" class="form-control">
                        <option selected="20" value="20">20</option>
                        <option value="40">40</option>
                        <option value="80">80</option>
                        <option value="150">150</option>
                        <option value="250">250</option>
                    </select>
                </td>
                <td>
                    <label>Filter rows: </label>
                    <input style="display: inline" type="search" id="search" class="form-control" placeholder="Search...">
                </td>
            </tr>
        </table>
    <span class="rows">

    </span>
        <input type="hidden" id="id" value="<?php echo $_SESSION['id'];?>">
    </div>
</div>


<script>
    $(document).ready(function() {
        var limit = $('#limit').val();
        var id = $('#id').val();
        var table = 'mess_meal';
        $.post('<?php echo base_url('ajax/Meal.php')?>', {id: id}, function (data) {
            $('.rows').html(data);
        });

        $.post('<?php echo base_url('ajax/Pagination.php')?>', {limit: limit, table: table, id: id}, function(data) {
            $("#page").html(data);
        })

        $('#limit').change(function() {
            var limit = $('#limit').val();
            var id = $('#id').val();
            var table = 'mess_meal';
            $.post('<?php echo base_url('ajax/Meal.php')?>', {limit: limit, id: id}, function(data) {
                $('.rows').html(data);
            })


            $.post('<?php echo base_url('ajax/Pagination.php')?>', {limit: limit, table: table, id: id}, function(data) {
                $("#page").html(data);
            })
        })

        $('#page').change(function() {
            var pageid = $('#page').val();
            var limit = $('#limit').val();
            var id = $('#id').val();
            $.post('<?php echo base_url('ajax/Pagination.php');?>', {pageid: pageid, limit: limit, id: id}, function(data) {
                //$('.rows').html(data);
                $('.rows').html(data);
            })
        })

    })
</script>