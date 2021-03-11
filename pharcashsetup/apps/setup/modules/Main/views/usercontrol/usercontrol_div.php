<!-- <div id="usercontrol_div" class="container-fluid table-responsive-md">
    <div class="row">
        <div class="col-3">
            <p><button type="button" class="btn btn_pmk btn-sm" add_usercontrol><i class="fa fa-plus"></i></button>User</p>
        </div>
        <div class="col-3">
            <p><button type="button" class="btn btn_pmk btn-sm" add_usercontrol><i class="fa fa-plus"></i></button>สถานที่ห้องยา</p>
        </div>
    </div>
    <div class="row">
        <div class="container-fluid">
        <?php foreach ($Data['CurrentAuth'] as $currentkey => $currentvalue) : ?>
            <form usercontrol class="form-horizontal" method="post" action="./update_usercontrol/<?=$currentvalue->uid;?>">
            <div class="row">
                <div class="col-3">
                    <div class="row">
                        <div class="col">
                            <select class="form-control" name="username">
                                <option value=""></option>
                                <?php foreach($Data['AllUser'] as $userkey => $uservalue) : ?>
                                    <option value="<?=$uservalue->username;?>" <?=$uservalue->username == $currentvalue->username?'selected':'';?>><?=$uservalue->username;?></option>
                                <?php endforeach;?>
                                <option value="pharmacy.root" <?='pharmacy.root' == $currentvalue->username?'selected':'';?>>fix:pharmacy.root</option>
                            </select>
                        </div>
                        <div style="width: fit-content;">
                            <button type="button" class="btn btn_pmk btn-sm" remove_usercontrol="<?=$currentvalue->uid;?>"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="row">
                        <div class="col">
                            <select class="form-control" name="queuelocationuid">
                                <option value=""></option>
                                <?php foreach($Data['Queuelocation'] as $locationkey => $locationvalue) : ?>
                                <option value="<?=$locationvalue->locationuid;?>" <?=$locationvalue->locationuid == $currentvalue->queuelocationuid ?'selected':'';?>><?=$locationvalue->locationname_th;?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div style="width: fit-content;">
                            <button type="button" class="btn btn_pmk btn-sm" remove_usercontrol="<?=$currentvalue->uid;?>"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        <?php endforeach; ?>
        </div>
    </div>

</div> -->

<!-- <table id="usercontrol_div" class="container-fluid table table-striped table-bordered table-sm" cellspacing="0"
    width="100%">

    <div id="usercontrol_div" class="container-fluid table-responsive-md">
        <thead>
            <tr>
                <p><button type="button" class="btn btn_pmk btn-sm" add_usercontrol><i
                            class="fa fa-plus"></i></button>User</p>
                <p><button type="button" class="btn btn_pmk btn-sm" add_usercontrol><i
                            class="fa fa-plus"></i></button>สถานที่ห้องยา</p>
            </tr>
        </thead>
        <tbody>
            <div class="row">
                <div class="container-fluid">
                    <?php foreach ($Data['CurrentAuth'] as $currentkey => $currentvalue) : ?>
                    <form usercontrol class="form-horizontal" method="post"
                        action="./update_usercontrol/<?=$currentvalue->uid;?>">
                        <div class="row">
                            <div class="col-3">
                                <div class="row">
                                    <div class="col">
                                        <select class="form-control" name="username">
                                            <option value=""></option>
                                            <?php foreach($Data['AllUser'] as $userkey => $uservalue) : ?>
                                            <option value="<?=$uservalue->username;?>"
                                                <?=$uservalue->username == $currentvalue->username?'selected':'';?>>
                                                <?=$uservalue->username;?></option>
                                            <?php endforeach;?>
                                            <option value="pharmacy.root"
                                                <?='pharmacy.root' == $currentvalue->username?'selected':'';?>>
                                                fix:pharmacy.root</option>
                                        </select>
                                    </div>
                                    <div style="width: fit-content;">
                                        <button type="button" class="btn btn_pmk btn-sm"
                                            remove_usercontrol="<?=$currentvalue->uid;?>"><i
                                                class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row">
                                    <div class="col">
                                        <select class="form-control" name="queuelocationuid">
                                            <option value=""></option>
                                            <?php foreach($Data['Queuelocation'] as $locationkey => $locationvalue) : ?>
                                            <option value="<?=$locationvalue->locationuid;?>"
                                                <?=$locationvalue->locationuid == $currentvalue->queuelocationuid ?'selected':'';?>>
                                                <?=$locationvalue->locationname_th;?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div style="width: fit-content;">
                                        <button type="button" class="btn btn_pmk btn-sm"
                                            remove_usercontrol="<?=$currentvalue->uid;?>"><i
                                                class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                            </div>
                    </form>
                </div>
                <?php endforeach; ?>
            </div>
    </div>
    </tbody>
    </div>
</table> -->

<div id="usercontrol_div" class="container-fluid table-responsive-md">

    <table id="example2" class="table table-bordered table-hover dataTable" role="grid"
        aria-describedby="example2_info">
        <thead>
            <tr role="row">
                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                    aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">
                    <p><button type="button" class="btn btn_pmk btn-sm" add_usercontrol><i
                                class="fa fa-plus"></i></button>User</p>
                </th>
                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                    aria-label="Browser: activate to sort column ascending">
                    <p><button type="button" class="btn btn_pmk btn-sm" add_usercontrol><i
                                class="fa fa-plus"></i></button>สถานที่ห้องยา</p>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($Data['CurrentAuth'] as $currentkey => $currentvalue) : ?>
            <form usercontrol class="form-horizontal" method="post"
                action="./update_usercontrol/<?=$currentvalue->uid;?>">
                <tr role="row" class="odd">
                    <td class="sorting_1">
                        <select class="form-control" name="username">
                            <option value=""></option>
                            <?php foreach($Data['AllUser'] as $userkey => $uservalue) : ?>
                            <option value="<?=$uservalue->username;?>"
                                <?=$uservalue->username == $currentvalue->username?'selected':'';?>>
                                <?=$uservalue->username;?></option>
                            <?php endforeach;?>
                            <option value="pharmacy.root"
                                <?='pharmacy.root' == $currentvalue->username?'selected':'';?>>fix:pharmacy.root
                            </option>
                        </select><button type="button" class="btn btn_pmk btn-sm"
                            remove_usercontrol="<?=$currentvalue->uid;?>"><i class="fa fa-minus"></i></button>
                    </td>
                    <td><select class="form-control" name="queuelocationuid">
                            <option value=""></option>
                            <?php foreach($Data['Queuelocation'] as $locationkey => $locationvalue) : ?>
                            <option value="<?=$locationvalue->locationuid;?>"
                                <?=$locationvalue->locationuid == $currentvalue->queuelocationuid ?'selected':'';?>>
                                <?=$locationvalue->locationname_th;?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="button" class="btn btn_pmk btn-sm" remove_usercontrol="<?=$currentvalue->uid;?>"><i class="fa fa-minus"></i></button>
                    </td>
                </tr>
            </form>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>