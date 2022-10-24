<!-- BEGIN: Header-->
<nav class="header-navbar navbar-expand-lg navbar navbar-with-menu floating-nav navbar-light navbar-shadow">
    <div class="navbar-wrapper">
        <div class="navbar-container content">
            <div class="navbar-collapse" id="navbar-mobile">
                <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                    <ul class="nav navbar-nav">
                        <li class="nav-item mobile-menu d-xl-none mr-auto"><a
                                    class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                                        class="ficon feather icon-menu"></i></a></li>
                    </ul>
                </div>
                <ul class="nav navbar-nav float-right">

                    <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand"><i
                                    class="ficon feather icon-maximize"></i></a></li>
                    <?php $notiCnt=0;
                    $notiList='';
                    if(isset($_SESSION['login']['pwdExpiry']) && $_SESSION['login']['pwdExpiry'] != ''
                        && date('Y-m-d', strtotime($this->encrypt->decode($_SESSION['login']['pwdExpiry']))) <= date('Y-m-d', strtotime('+10 days'))){
                        $notiCnt=1;
                        $notiList='<a class="d-flex" href="javascript:void(0)" data-toggle="modal" data-keyboard="false" data-target="#changePasswordModal">
                                    <div class="media d-flex align-items-start">
                                        <div class="media-left">
                                            <div class="avatar bg-light-danger">
                                                <div class="avatar-content">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="media-body">
                                            <p class="media-heading"><span class="font-weight-bolder">Password Expire</span>&nbsp;
                                            </p><small class="notification-text">Your password is expiring on '.date('d-M-Y',strtotime($this->encrypt->decode($_SESSION['login']['pwdExpiry']))).', Please change your password</small>
                                        </div>
                                    </div>
                                </a>';
                    }else{
                        $notiList='<a class="d-flex" href="javascript:void(0)" >
                                    <div class="media d-flex align-items-start"> 
                                        <div class="media-body">
                                             <small class="notification-text">No new notification</small>
                                        </div>
                                    </div>
                                </a>';
                    }
                    ?>
                    <li class="nav-item dropdown dropdown-notification mr-25">
                        <a class="nav-link"  href="javascript:void(0);" data-toggle="dropdown">
                            <i class="ficon feather icon-bell" data-feather="bell"></i>
                            <span class="badge badge-pill badge-danger badge-up"><?php echo $notiCnt;?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                            <li class="scrollable-container media-list">
                                <div class="media d-flex align-items-center">
                                    <h6 class="font-weight-bolder mr-auto mb-0">Notifications</h6>
                                </div>
                                <?php echo $notiList;?>

                            </li>
                        </ul>
                    </li>
                    <li class="dropdown dropdown-user nav-item">
                        <a class="dropdown-toggle nav-link" href="<?php echo base_url() ?>" data-toggle="dropdown">
                            <div class="user-nav d-sm-flex d-none">
                                <span class="user-name text-bold-600"><?php
                                    if (isset($_SESSION['login']['full_name']) && $_SESSION['login']['full_name'] != '') {
                                        echo 'Welcome ' . ucwords($this->encrypt->decode($_SESSION['login']['full_name']));
                                    } else {
                                        echo 'Welcome';
                                    }
                                    ?></span>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="<?php echo base_url() ?>">
                                <i class="feather icon-user"></i> Edit Profile
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="javascript:void(0)" id="change_password"
                               data-toggle="modal" data-keyboard="false" data-target="#changePasswordModal">
                                <i class="feather icon-user"></i>
                                Change Password
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="javascript:void(0)" onclick="logout()">
                                <i class="feather icon-power"></i>
                                Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<!-- END: Header-->
<div class="modal fade text-left" id="changePasswordModal" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel_changePwd" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary white">
                <h4 class="modal-title white" id="myModalLabel_changePwd">Change Password</h4>

                <input type="hidden" id="edit_idUser" name="edit_idUser" autocomplete="edit_idUser_off">
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label for="edit_newPassword">New Password: </label>
                    <div class="position-relative  ">
                        <input type="password" class="form-control edit_newPassword myPwdInput"
                               autocomplete="edit_newPassword_off" id="edit_newPassword">
                        <div class="form-control-position toggle-password">
                            <i class="ft-eye-off pwdIcon"></i>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="edit_newPasswordConfirm">Confrim Password: </label>
                    <div class="position-relative  ">
                        <input type="password" class="form-control edit_newPasswordConfirm myPwdInput"
                               autocomplete="edit_newPasswordConfirm_off" id="edit_newPasswordConfirm">
                        <div class="form-control-position toggle-password">
                            <i class="ft-eye-off pwdIcon"></i>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="changePassword()">Change Password
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade text-left" id="changeFirstPasswordModal" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel_changeFirstPwd" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary white">
                <p class="modal-title white" id="myModalLabel_changeFirstPwd"></p>
                <input type="hidden" id="isNewUser" name="isNewUser"
                       value="<?php echo(isset($_SESSION['login']['isNewUser']) && $this->encrypt->decode($_SESSION['login']['isNewUser']) == '1' ? '1' : '0') ?>"
                       autocomplete="isNewUser">
                <input type="hidden" id="pwdExpiry" name="pwdExpiry"
                       value="<?php echo(isset($_SESSION['login']['pwdExpiry']) && $_SESSION['login']['pwdExpiry'] != ''
                       && date('Y-m-d', strtotime($this->encrypt->decode($_SESSION['login']['pwdExpiry']))) <= date('Y-m-d') ? date('Y-m-d', strtotime($this->encrypt->decode($_SESSION['login']['pwdExpiry']))) : '0') ?>"
                       autocomplete="isNewUser">
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="first_newPassword">New Password: </label>
                    <div class="position-relative  ">
                        <input type="password" class="form-control first_newPassword myPwdInput"
                               autocomplete="first_newPassword_off" id="first_newPassword">
                        <div class="form-control-position toggle-password">
                            <i class="ft-eye-off pwdIcon"></i>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="first_newPasswordConfirm">Confrim Password: </label>
                    <div class="position-relative  ">
                        <input type="password" class="form-control first_newPasswordConfirm myPwdInput"
                               autocomplete="first_newPasswordConfirm_off" id="first_newPasswordConfirm">
                        <div class="form-control-position toggle-password">
                            <i class="ft-eye-off pwdIcon"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="changeFirstPassword()">Change Password
                </button>
            </div>
        </div>
    </div>
</div>

