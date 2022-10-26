<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Sample Information</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo base_url() ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Add - Sample Information</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <input type="hidden" id="slug_province" name="slug_province"
                   value="<?php echo(isset($slug_province) && $slug_province != '' ? $slug_province : 0) ?>">
            <input type="hidden" id="slug_district" name="slug_district"
                   value="<?php echo(isset($slug_district) && $slug_district != '' ? $slug_district : 0) ?>">
            <input type="hidden" id="slug_cluster" name="slug_cluster"
                   value="<?php echo(isset($slug_cluster) && $slug_cluster != '' ? $slug_cluster : 0) ?>">



        </div>
    </div>
</div>
<!-- END: Content-->


<script>



</script>