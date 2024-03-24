<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card rounded-0">
    <div class="card-header">
        <div class="card-title h4 mb-0 fw-bolder">List of Users</div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <table class="table table-stripped table-bordered">
                <thead>
                    <th class="p-1 text-center">#</th>
                    <th class="p-1 text-center">Name</th>
                    <th class="p-1 text-center">Email</th>
                    <th class="p-1 text-center">Mobile</th>
                    <th class="p-1 text-center">Gender</th>
                    <th class="p-1 text-center">Action</th>
                </thead>
                <tbody>
                    <?php foreach($users as $row): ?>
                        <tr>
                            <th class="p-1 text-center align-middle"><?= $row['id'] ?></th>
                            <td class="px-2 py-1 align-middle"><?= $row['name'] ?> </td>
                            <td class="px-2 py-1 align-middle"><?= $row['email'] ?></td>
                            <td class="px-2 py-1 align-middle"><?= ($row['mobile'] != '') ? '+' .$row['country_code'].' ' . $row['mobile'] : '' ?></td>
                            <td class="px-2 py-1 align-middle text-center">
                                <?php 
                                switch($row['gender']){
                                    case 'Male':
                                        echo '<span class="badge bg-primary bg-gradient rounded-pill border px-3 text-dark">Male</span>';
                                        break;
                                    case 'Female':
                                        echo '<span class="badge bg-warning bg-gradient rounded-pill px-3">Female</span>';
                                        break;
                                    default:
                                        echo '<span class="badge bg-secondary bg-danger px-3">N.A.</span>';
                                        break;
                                }
                                ?>
                            </td>
                            <td class="px-2 py-1 align-middle text-center">
                                <a href="<?= base_url('Main/user_edit/'.$row['id']) ?>" class="mx-2 text-decoration-none text-primary"><i class="fa fa-edit"></i></a>
								<?php  if($row['type'] == 0){ ?>
                                <a href="<?= base_url('Main/user_delete/'.$row['id']) ?>" class="mx-2 text-decoration-none text-danger" onclick="if(confirm('Are you sure to delete <?= $row['email'] ?> from list?') !== true) event.preventDefault()"><i class="fa fa-trash"></i></a>
								<?php } ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if(count($users) <= 0): ?>
                        <tr>
                            <td class="p-1 text-center" colspan="6">No result found</td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
            <div>
                <?= $pager->makeLinks($page, $perPage, $total, 'custom_view') ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>