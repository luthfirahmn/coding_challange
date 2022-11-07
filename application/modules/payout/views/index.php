<!-- Main content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col">

                <div class="card">
                    <div class="card-header">
                        <?php echo anchor('payout/create', '<i class="fa fa-plus mr-1"></i> Create', array('class' => 'btn btn-success')); ?>
                    </div>

                    <div class="card-body">

                        <table class="table table-bordered table-striped" id="mytable">
                            <thead>
                                <tr>
                                    <th width="4%">No</th>
                                    <th class="text-center">Title</th>
                                    <th class="text-center">Total Payout</th>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $start = 0;
                                foreach ($all_data as $row) : ?>
                                <tr>
                                    <td><?php echo ++$start ?></td>
                                    <td><?php echo $row->title ?></td>
                                    <td>Rp. <?php echo number_format($row->total_payout) ?></td>
                                    <td><?php
                                            $date = new DateTime($row->created_date);
                                            echo $date->format('l jS \o\f F Y h:i:s A')  ?></td>
                                    <td class="text-center" width="140px">
                                        <?php echo anchor(site_url('payout/view/' . $row->id), '<i class="fa fa-eye"></i>', array('title' => 'detail', 'class' => 'btn btn-info btn-sm')) ?>
                                        <?php echo anchor(site_url('payout/update/' . $row->id), '<i class="fa fa-pencil-square-o"></i>', array('title' => 'edit', 'class' => 'btn btn-warning btn-sm')) ?>
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                            data-target="#row-<?php echo $row->id ?>"><i
                                                class="fas fa-trash"></i></button>
                                    </td>
                                    <?php echo confirm(base_url('payout/delete/' . $row->id), "row-" . $row->id, "Confirmation !", "Are you sure ? data will be deleted, and can't be recover !") ?>
                                </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>


                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->