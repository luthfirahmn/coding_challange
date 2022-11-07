<!-- Main content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-6">

                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo @$deskripsi ?></h3>
                    </div>

                    <!-- Horizontal Form -->
                    <form class="form-horizontal" id="formAdd">
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Title</label>
                                <div class="col-sm-9">
                                    <?php
                                    $array_name = array(
                                        "type" => "text",
                                        "class" => "form-control",
                                        "name" => "title",
                                        "id" => "title",
                                        "placeholder" => "title"
                                    );
                                    echo form_input($array_name); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Total Amount</label>
                                <div class="col-sm-9">
                                    <?php
                                    $array_name = array(
                                        "type" => "text",
                                        "class" => "form-control",
                                        "name" => "totalAmount",
                                        "id" => "totalAmount",
                                        "placeholder" => "Total Payment"
                                    );
                                    echo form_input($array_name); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-11">Bonus Percentage</label>
                                <div class="col-sm-1 float-right">
                                    <button type="button" class="btn btn-primary btn-sm" id="addPayout"><i
                                            class="fa fa-plus"></i>
                                </div>
                            </div>
                            <div id="payout"></div>
                        </div>
                        <!-- /.card body -->

                        <div class="card-footer">
                            <button type="button" id="btnAdd" class="btn btn-primary"><i class="fa fa-check mr-1"></i>
                                Submit</button>
                            <a href="<?php echo site_url("payout") ?>" type="button"
                                class="btn btn-default float-right"><i class="fa fa-chevron-left mr-1"></i> Back</a>
                        </div>
                        <!-- /.card-footer -->
                    </form>

                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<script>
$(document).ready(function() {

    $('input#totalAmount').number(true);

    $('#payout').html(`<div class="form-group row emp">
                                <div class="col-sm-5">
                                    <input type="text" name="empName[]" class="form-control" placeholder="Employee Name">
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group mb-3">
                                        <input name="empPct[]" type="number" class="form-control empPct">
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <span class="input-group-text">Rp.</span>
                                        </div>
                                        <input type="text" name="empAmount[]" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>`)


    $(document).on("keyup", ".empPct", function() {
        totalAmount = $('#totalAmount').val()
        empName = $(this).closest('.emp').find('input[name="empName[]"]').val()
        empAmount = $(this).closest('.emp').find('input[name="empAmount[]"]')

        val = $(this).val()

        if (totalAmount === '') {
            $(this).val('');
            toastError('Please Fill The Total Amount')
        } else if (empName === '') {
            $(this).val('');
            toastError('Please Fill The Employee Name')
        } else if (val > 100) {
            $(this).val(100);
        } else if (val < 1 && val != '') {
            $(this).val(0);
        } else {
            empAmount.val($.number(totalAmount * val / 100))
        }
    });

    $(document).on("click", ".removeEmp", function() {
        empName = $(this).closest('.emp').remove()
    });
});

$('#addPayout').on('click', function() {
    $('#payout').append(`<div class="form-group row emp">
                                <div class="col-sm-4">
                                    <input type="text" name="empName[]" class="form-control" placeholder="Employee Name">
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group mb-3">
                                        <input name="empPct[]" type="number" class="form-control empPct">
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <span class="input-group-text">Rp.</span>
                                        </div>
                                        <input type="text" name="empAmount[]" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-1 float-right">
                                    <button type="button" class="btn btn-danger removeEmp"><i
                                            class="fa fa-minus"></i>
                                </div>
                            </div>`)
})

$('#btnAdd').on('click', function() {


    var total = 0;
    totalEmp = 0;
    $('.empPct').each(function(index, element) {
        total = total + parseFloat($(element).val());
        totalEmp = totalEmp + 1
    });

    if (totalEmp < 3) {
        toastError('Number of employees must be more than 3')
        return
    }

    if (total !== 100) {
        toastError('Percentage must be 100%')
        return
    }

    $.ajax({
        type: "post",
        url: "<?= site_url('payout/create_action') ?>",
        data: new FormData($('#formAdd')[0]),
        processData: false,
        contentType: false,
        cache: false,
        dataType: "json",
        success: function(data) {
            if (data.error == false) {
                toastSuccess(data.message)
                window.location.href = '<?= site_url('payout') ?>'
            } else {
                toastError(data.message)
            }
        },
        error: function(xhr, status, errorThrown) {
            console.log(xhr.status);
        }

    });

})

function toastError(msg) {
    $(document).Toasts('create', {
        icon: 'fas fa-exclamation-triangle',
        class: 'bg-danger m-1',
        autohide: true,
        delay: 5000,
        title: 'An error has occured',
        body: msg
    })
}

function toastSuccess(msg) {
    $(document).Toasts('create', {
        icon: 'fas fa-exclamation-triangle',
        class: 'bg-success m-1',
        autohide: true,
        delay: 5000,
        title: 'Success',
        body: msg
    })
}
</script>