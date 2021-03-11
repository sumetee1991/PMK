<style>
    .select2-results {
        display: grid !important;
    }
</style>

<table id="usercreate_div" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline collapsed" cellspacing="0" style="display:none;">
    <thead>
        <tr>
            <th nowrap valign="bottom">ลำดับ</th>
            <th>User</th>
            <th>สถานที่ห้องยา</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($Data['CurrentAuth'] as $currentkey => $currentvalue) : ?>
            <!-- <input type="hidden" name="add_user" id="add_user" value="<?php echo $currentvalue->uid; ?>"> -->
            <tr>
                <td>
                    <button type="button" class="btn btn_pmk btn-sm" remove_usercreate="<?= $currentvalue->uid; ?>"><i class="fa fa-minus"></i></button>
                    <?= $currentkey + 1; ?>
                </td>
                <td>
                    <!-- <?= $currentvalue->uid; ?> -->
                    <form usercreate class="form-horizontal" method="post" action="./update_usercreate/<?= $currentvalue->uid; ?>">
                        <!-- <input list="browsers" class="form-createl" id="browser" value="<?= $currentvalue->username; ?>"> -->
                        <!-- <datalist id="browsers" class="form-createl" name="username" style="display:none"> -->
                        <select class="form-control option_select2" name="username" style="width:500px;">
                            <option value=""></option>
                            <?php foreach ($Data['CurrentAuth'] as $userkey => $uservalue) : ?>
                                <option value="<?= $uservalue->username; ?>" <?= $uservalue->username == $currentvalue->username ? 'selected' : ''; ?>>
                                    <?= $uservalue->username; ?></option>
                                <!-- <option value="pharmacy.root"
                                <?= 'pharmacy.root' == $currentvalue->username ? 'selected' : ''; ?>>fix:pharmacy.root
                            </option> -->
                            <?php endforeach; ?>
                        </select>
                        </input>
                    </form>
                </td>
                <td>
                    <form usercreate class="form-horizontal " method="post" action="./update_usercreate/<?= $currentvalue->uid; ?>">
                        <select class="form-control option_select2" name="queuelocationuid" style="width:400px">
                            <option value=""></option>
                            <?php foreach ($Data['Queuelocation'] as $locationkey => $locationvalue) : ?>
                                <option value="<?= $locationvalue->locationuid; ?>" <?= $locationvalue->locationuid == $currentvalue->queuelocationuid ? 'selected' : ''; ?>>
                                    <?= $locationvalue->locationname_th; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>