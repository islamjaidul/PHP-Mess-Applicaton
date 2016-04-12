<?php
if (isset($_SESSION['msg'])) {
?>
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <i class="fa fa-check-square-o"></i>
    <?php echo $_SESSION['msg']; ?>
</div>
<?php } ?>

<div class="box box-info">
    <div class="box-body">
        <span><a class="label label-success" style="color:#ffffff; text-decoration:none" href="<?php echo base_url('dashboard/archive/meal')?>"><i class="fa fa-archive"></i>  Archive</a></span>
        <span><a class="label label-danger" style="color:#ffffff; text-decoration:none" href="<?php echo base_url('dashboard/meal/dailymeal')?>"><i class="fa fa-cutlery"></i>  Daily Meal</a></span>


            <table class="table table-responsive">
                <tr>
                    <td width="200px">
                        <label>Page: </label>
                        <select style="width: 70px; display:inline" name="page" id="page" class="form-control">

                        </select>
                    </td>
                    <td>
                        <label>Rows: </label>
                        <select style="width: 70px; display:inline" name="limit" id="limit" class="form-control">
                            <option selected="20" value="20">20</option>
                            <option value="40">40</option>
                            <option value="80">80</option>
                            <option value="150">150</option>
                            <option value="250">250</option>
                        </select>
                    </td>
                </tr>
            </table>
    <span class="rows">

    </span>
            <input type="hidden" id="id" value="<?php echo $_SESSION['id'];?>">
        </div>
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
