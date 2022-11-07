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
                                        "placeholder" => "title",
                                        "value" => $all_data->title,
                                        "readonly" => true
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
                                        "placeholder" => "Total Payment",
                                        "value" => $all_data->total_payout,
                                        "readonly" => true
                                    );
                                    echo form_input($array_name); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-11">Bonus Percentage</label>
                            </div>
                            <div id="payout"></div>
                        </div>
                        <!-- /.card body -->

                        <div class="card-footer">
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

    $.ajax({
        type: 'GET',
        url: '<?= site_url('payout/get_detail_by_id/') . $all_data->id ?>',
        contentType: 'application/json', // this
        datatype: 'json',
        success: function(data) {
            json_data = JSON.parse(data)
            parse_data = json_data.data
            for (var x = 0; x < parse_data.length; x++) {
                console.log(parse_data[x]['id'])

                $('#payout').append(
                    `<div class="form-group row emp">
                                <div class="col-sm-5">
                                    <input type="text" name="empName[]" class="form-control" placeholder="Employee Name" value="` +
                    parse_data[x]['employee_name'] + `" readonly>
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group mb-3">
                                        <input name="empPct[]" type="number" class="form-control empPct" value="` +
                    parse_data[x]['payout_pct'] + `" readonly>
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
                                        <input type="text" name="empAmount[]" class="form-control" value="` +
                    parse_data[x]['payout_amount'] + `" readonly>
                                    </div>
                                </div>
                            </div>`)
            }
        }
    });


    $('input#totalAmount').number(true);

});
</script>