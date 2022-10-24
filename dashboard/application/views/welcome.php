<!-- BEGIN: Content-->
<div class="app-content content" style="height: 90%;">
    <div class="content-overlay"></div>
    <div class="content-wrapper" style="height: 90%;">
        <div class="content-body " style="    background: linear-gradient(118deg, #7367f0, rgba(115, 103, 240, 0.7));
    background-size: cover; height: 100%;     padding: 15%;  ">
            <section class="row flexbox-container">
                <div class="col-xl-12 col-md-12 col-12 d-flex justify-content-center">
                    <div class="card auth-card bg-transparent shadow-none rounded-0 mb-0 w-100">
                        <div class="card-content ">
                            <div class="card-body text-center white">
                                <h1 class="font-large-2 my-2 white">
                                    Welcome <?php echo(isset($_SESSION['login']['full_name']) && $_SESSION['login']['full_name'] != '' ? $this->encrypt->decode($_SESSION['login']['full_name']): '') ?></h1>
                                <p class="p-2">
                                    Dashboard - SERO_2022
								</p>
                                <p>(Polio Seroprevalence Survey-2022)</p>


                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<!-- END: Content-->
