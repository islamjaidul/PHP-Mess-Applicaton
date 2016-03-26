<?php
if (isset($_SESSION['msg'])) {
    ?>
    <div class="alert alert-success">
        <i class="fa fa-check-square-o"></i> <?php echo $_SESSION['msg']; ?>
    </div>
<?php } ?>

<?php
if (isset($_SESSION['alert-msg'])) {
    ?>
<div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <i class="fa fa-exclamation-triangle"></i>
    <?php echo $_SESSION['alert-msg']; ?>
</div>
<?php } ?>

<!--Delete Div Start-->
<div class="modal fade" id="confirm-delete">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
            </div>

            <div class="modal-body">
                <p>You are about to permanently delete member's total information, this procedure is irreversible.</p>
                <p>Do you want to proceed?</p>
                <p class="debug-url"></p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a href="#" class="btn btn-danger danger">Delete</a>
            </div>
        </div>
    </div>
</div>
<!--Delete Div End-->

<div class="box box-info">
    <div class="box-body">
        <div style="margin-bottom:10px;">
            <a href="<?php echo base_url('dashboard/member/new') ?>" class="label label-success"><i class="fa fa-plus"></i> Add New</a>
        </div>

        <?php
        $id = 0;
        foreach ($rows as $row) {
            $id = $row->usersid;
            break;
        }
        if ($_SESSION['id'] == $id) {
            ?>
            <table class="table table-bordered">
                <tr>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Occupation</th>
                    <th>Action</th>
                </tr>
                <?php
                foreach ($rows as $row) {
                    ?>
                    <tr>
                        <td><?php echo $row->name; ?></td>
                        <td><?php echo $row->mobile; ?></td>
                        <td><?php echo $row->occupation; ?></td>
                        <td>
                            <a href="<?php echo base_url('dashboard/member/edit/'.$row->id.'')?>" id="<?php echo $row->id?>" class="label label-info"><i class="fa fa-pencil-square-o"></i></a>
                            <a data-href="<?php echo base_url('dashboard/member/delete/'.$row->id.'')?>" data-toggle="modal" data-target="#confirm-delete" href="#" class="label label-danger"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        <?php } else {
            echo '<h4 style="color:red; text-align: left;">Please click (Add New) to add your mess member</h4>';
        }

        ?>
    </div>
</div>



<script>
   /* $(document).ready(function(){
        $(".label-info").click(function(){
            var id = $(this).attr('id');
            $.post("<?php echo base_url('ajax/EditMember.php')?>", {id: id}, function(data){

                $("#form").html(data);
            });
        });

        $('.btn-info').click(function() {
            var name = $('#name').val();
            var address = $("#address").val();
            var mobile = $("#mobile").val();
            var email = $("#email").val();
            var occupation = $("#occupation").val();
            var id = $("#update_id").val();
            $.post("<?php echo base_url('ajax/EditPostMember.php')?>", {id: id, name: name, address: address, mobile: mobile, email: email, occupation: occupation}, function(data){
                $("#msg").html(data);
            });
            $('#msg').html('<h3>Processing...</h3>')
        })
    })*/

   $(document).ready(function(){
       $('#confirm-delete').on('show.bs.modal', function(e) {
           $(this).find('.danger').attr('href', $(e.relatedTarget).data('href'));

       });
   });
</script>
