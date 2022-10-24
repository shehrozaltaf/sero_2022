<link rel="stylesheet" type="text/css"
      href="<?php echo base_url() ?>assets/vendors/css/tables/datatable/datatables.min.css">


<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Pages</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?php base_url() ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="<?php base_url() ?>">Settings</a>
                                </li>
                                <li class="breadcrumb-item active">Page
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section id="column-selectors">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Page</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body card-dashboard">
                                    <div class="table-responsive">
                                        <table class="table table-striped dataex-html5-selectors">
                                            <thead>
                                            <tr>
                                                <th>SNo</th>
                                                <th>Name</th>
                                                <th>URL</th>
                                                <th>Parent</th>
                                                <th>Icon</th>
                                                <th>Class</th>
                                                <th>Menu</th>
                                                <th>Sort No</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $SNo = 0;
                                            if (isset($pages) && $pages != '') {
                                                foreach ($pages as $page) {
                                                    $SNo++; ?>
                                                    <tr>
                                                        <td><?php echo $SNo ?></td>
                                                        <td><?php echo $page->pageName ?></td>
                                                        <td><?php echo $page->pageUrl ?></td>
                                                        <td><?php echo $page->idParent ?></td>
                                                        <td><i class="feather <?php echo $page->menuIcon ?>"></i></td>
                                                        <td><?php echo $page->menuClass ?></td>
                                                        <td><?php echo $page->isMenu ?></td>
                                                        <td><?php echo $page->sort_no ?></td>
                                                        <td data-id="<?php echo $page->idPages ?>">
                                                            <?php if (isset($permission[0]->CanEdit) && $permission[0]->CanEdit == 1) { ?>
                                                                <a href="javascript:void(0)" onclick="getEdit(this)"><i
                                                                            class="feather icon-edit"></i> </a>
                                                            <?php } ?>
                                                            <?php if (isset($permission[0]->CanDelete) && $permission[0]->CanDelete == 1) { ?>
                                                                <a href="javascript:void(0)" onclick="getDelete(this)">
                                                                    <i class="feather icon-trash"></i>
                                                                </a>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php }
                                            } ?>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>SNo</th>
                                                <th>Name</th>
                                                <th>URL</th>
                                                <th>Parent</th>
                                                <th>Icon</th>
                                                <th>Class</th>
                                                <th>Menu</th>
                                                <th>Sort No</th>
                                                <th>Action</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if (isset($permission[0]->CanAdd) && $permission[0]->CanAdd == 1) { ?>
                            <div class="md-fab-wrapper">
                                <a class="md-fab md-fab-accent md-fab-wave-light waves-effect waves-button waves-light"
                                   href="javascript:void(0)" data-uk-modal="{target:'#addModal'}" id="add">
                                    <i class="feather icon-plus-circle"></i>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<!-- END: Content-->
<?php if (isset($permission[0]->CanAdd) && $permission[0]->CanAdd == 1) { ?>
    <div class="md-fab-wrapper addbtn">
        <a class="md-fab md-fab-accent md-fab-wave-light waves-effect waves-button waves-light"
           href="javascript:void(0)" data-uk-modal="{target:'#addModal'}" id="add">
            <i class="feather icon-plus-circle"></i>
        </a>
    </div>
    <div class="modal fade text-left" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_add"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h4 class="modal-title white" id="myModalLabel_add">Add Page</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="pageName">Page Name: </label>
                        <input type="text" class="form-control pageName" onkeyup="copyURL('pageName','pageUrl');"
                               id="pageName" required>
                    </div>
                    <div class="form-group">
                        <label for="pageUrl">Page URL: </label>
                        <input type="text" class="form-control pageUrl"
                               id="pageUrl" onkeyup="validateURL('Page_url')" required>
                    </div>
                    <div class="form-group">
                        <label for="menuParent">Parent: </label>
                        <input type="text" class="form-control pageName"
                               id="menuParent" required>
                    </div>
                    <div class="form-group">
                        <label for="menuIcon">Icon: </label>
                        <input type="text" class="form-control" id="menuIcon" required>
                    </div>
                    <div class="form-group">
                        <label for="menuClass">Class: </label>
                        <input type="text" class="form-control" id="menuClass" required>
                    </div>
                    <div class="form-group">
                        <label for="isMenu">Menu: </label>
                        <input type="text" class="form-control" id="isMenu" required>
                    </div>
                    <div class="form-group">
                        <label for="sort_no">Sort No: </label>
                        <input type="text" class="form-control" id="sort_no" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary mybtn" onclick="addData()">Add
                    </button>
                </div>
            </div>
        </div>
    </div>

<?php } ?>
<?php if (isset($permission[0]->CanEdit) && $permission[0]->CanEdit == 1) { ?>
    <div class="modal fade text-left" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_edit"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h4 class="modal-title white" id="myModalLabel_edit">Edit Page</h4>

                    <input type="hidden" id="edit_idPage" name="edit_idPage">
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="edit_pageName">Page: </label>
                        <input type="text" class="form-control edit_pageName" id="edit_pageName">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" onclick="editData()">Edit
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php if (isset($permission[0]->CanDelete) && $permission[0]->CanDelete == 1) { ?>
    <div class="modal fade text-left" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_delete"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h4 class="modal-title white" id="myModalLabel_delete">Delete Page</h4>
                    <input type="hidden" id="delete_idPage" name="delete_idPage">
                </div>
                <div class="modal-body">
                    <p>Are you sure, you want to delete this?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" onclick="deleteData()">Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<script>
    $(document).ready(function () {
        $('.addbtn').click(function () {
            $('#addModal').modal('show');
        });
    });

    function addData() {
        $('#pageName').css('border', '1px solid #babfc7');
        $('#pageUrl').css('border', '1px solid #babfc7');
        var flag = 0;
        var data = {};
        data['pageName'] = $('#pageName').val();
        data['pageUrl'] = $('#pageUrl').val();
        data['menuParent'] = $('#menuParent').val();
        data['menuIcon'] = $('#menuIcon').val();
        data['menuClass'] = $('#menuClass').val();
        data['isMenu'] = $('#isMenu').val();
        data['sort_no'] = $('#sort_no').val();
        if (data['pageName'] == '' || data['pageName'] == undefined) {
            $('#pageName').css('border', '1px solid red');
            flag = 1;
            toastMsg('Page Name', 'Invalid Page Name', 'error');
            return false;
        }
        if (data['pageUrl'] == '' || data['pageUrl'] == undefined) {
            $('#pageName').css('border', '1px solid red');
            flag = 1;
            toastMsg('Page URL', 'Invalid Page URL', 'error');
            return false;
        }
        if (flag == 1) {
            $('#pageName').css('border', '1px solid red');
            toastMsg('Page', 'Something went wrong', 'error');
        } else {
            showloader();
            $('.mybtn').attr('disabled', 'disabled');
            CallAjax('<?php echo base_url('index.php/Settings/addPageData'); ?>', data, 'POST', function (result) {
                hideloader();
                if (result == 1) {
                    toastMsg('Success', 'Successfully inserted', 'success');
                    $('#addModal').modal('hide');
                    setTimeout(function () {
                        window.location.reload();
                    }, 500);
                } else if (result == 4) {
                    toastMsg('Page', 'Duplicate Page URL', 'error');
                } else if (result == 3) {
                    toastMsg('Page', 'Invalid Page Name', 'error');
                } else {
                    toastMsg('Error', 'Something went wrong', 'error');
                }
            });
        }
    }

    function getDelete(obj) {
        var id = $(obj).parent('td').attr('data-id');
        $('#delete_idPage').val(id);
        $('#deleteModal').modal('show');
    }

    function deleteData() {
        var data = {};
        data['idPage'] = $('#delete_idPage').val();
        if (data['idPage'] == '' || data['idPage'] == undefined || data['idPage'] == 0) {
            toastMsg('Page', 'Something went wrong', 'error');
            return false;
        } else {
            CallAjax('<?php echo base_url('index.php/Settings/deletePageData')?>', data, 'POST', function (res) {

                if (res == 1) {
                    toastMsg('Page', 'Successfully Deleted', 'success');
                    $('#deleteModal').modal('hide');
                    setTimeout(function () {
                        window.location.reload();
                    }, 500);
                } else if (res == 2) {
                    toastMsg('Page', 'Something went wrong', 'error');
                } else if (res == 3) {
                    toastMsg('Page', 'Invalid Page', 'error');
                }

            });
        }
    }

    function getEdit(obj) {
        var data = {};
        data['id'] = $(obj).parent('td').attr('data-id');
        if (data['id'] != '' && data['id'] != undefined) {
            CallAjax('<?php echo base_url('index.php/Settings/getPageEdit')?>', data, 'POST', function (result) {
                if (result != '' && JSON.parse(result).length > 0) {
                    var a = JSON.parse(result);
                    try {
                        $('#edit_idPage').val(data['id']);
                        $('#edit_pageName').val(a[0]['pageName']);
                    } catch (e) {
                    }
                    $('#editModal').modal('show');
                } else {
                    alert(1);
                }
            });
        }
    }

    function editData() {
        $('#edit_pageName').css('border', '1px solid #babfc7');
        var flag = 0;
        var data = {};
        data['idPage'] = $('#edit_idPage').val();
        data['pageName'] = $('#edit_pageName').val();
        if (data['idPage'] == '' || data['idPage'] == undefined || data['idPage'].length < 1) {
            flag = 1;
            return false;
        }
        if (data['pageName'] == '' || data['pageName'] == undefined || data['pageName'].length < 1) {
            $('#edit_pageName').css('border', '1px solid red');
            toastMsg('Page', 'Invalid Page Name', 'error');
            flag = 1;
            return false;
        }
        if (flag === 0) {
            CallAjax('<?php echo base_url('index.php/Settings/editPageData')?>', data, 'POST', function (res) {
                if (res == 1) {
                    $('#editModal').modal('hide');
                    toastMsg('Page', 'Successfully Edited', 'success');
                    setTimeout(function () {
                        window.location.reload();
                    }, 500);
                } else if (res == 2) {
                    toastMsg('Page', 'Something went wrong', 'error');
                } else if (res == 3) {
                    toastMsg('Page', 'Invalid Page', 'error');
                }
            });
        }
    }

</script>
<!-- BEGIN: Page Vendor JS-->
<script src="<?php echo base_url() ?>assets/vendors/js/tables/datatable/pdfmake.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendors/js/tables/datatable/vfs_fonts.js"></script>
<script src="<?php echo base_url() ?>assets/vendors/js/tables/datatable/datatables.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendors/js/tables/datatable/datatables.buttons.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendors/js/tables/datatable/buttons.html5.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendors/js/tables/datatable/buttons.print.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendors/js/tables/datatable/buttons.bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js"></script>
<!-- END: Page Vendor JS-->
<!-- BEGIN: Page JS-->
<script src="<?php echo base_url() ?>assets/js/scripts/datatables/datatable.js"></script>
<!-- END: Page JS-->