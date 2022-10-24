<?php
//error_reporting(0);

class Data_collection_progress extends CI_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('custom');
        $this->load->model('msettings');
        $this->load->model('mdata_collection');
        $this->load->model('mlinelisting');
        if (!isset($_SESSION['login']['idUser'])) {
            redirect(base_url());
        }
    }

    function index()
    {
        $data = array();
        $MSettings = new MSettings();
        $data['permission'] = $MSettings->getUserRights($this->encrypt->decode($_SESSION['login']['idGroup']), '', 'data_collection_progress');
        if (isset($data['permission'][0]->CanView) && $data['permission'][0]->CanView == 1) {
            $district = '';
            $sub_district = '';
            $level = 1;

            if (isset($data['permission'][0]->CanViewAllDetail) && $data['permission'][0]->CanViewAllDetail != 1
                && isset($_SESSION['login']['district']) && $this->encrypt->decode($_SESSION['login']['district']) != 0) {
                $sub_district = $this->encrypt->decode($_SESSION['login']['district']);
            }


            $MLinelisting = new MLinelisting();
            $MData_collection = new MData_collection();

            $getClustersProvince = $MLinelisting->getClustersProvince($district, $sub_district, $level);
            $dist_array = array();
            if (isset($district) && $district != '') {
                foreach ($getClustersProvince as $k => $v) {
                    $dist_id = substr($v->dist_id, 0, 3);
                    $dist_array[$dist_id] = $v->district;
                }
            } else {
                foreach ($getClustersProvince as $k => $v) {
                    $dist_id = substr($v->dist_id, 0, 1);
                    $dist_array[$dist_id] = $v->province;
                }
            }
            $data['dist_array'] = $dist_array;
            /*==============Total Clusters List==============*/
            $totalClusters_district = $MLinelisting->totalClusters_district($district, $sub_district, $level);
            $totalcluster = 0;
            foreach ($totalClusters_district as $k => $r) {
                $myTotalArray = array();
                $myTotalArray['clusters_by_district'] = $r->clusters_by_district;
                $totalcluster = $totalcluster + $r->clusters_by_district;
                $myTotalArray['id'] = $r->provinceId;
                foreach ($dist_array as $key => $dist_name) {
                    if ($key == $r->provinceId) {
                        $data['d' . $r->provinceId . '_total'] = $r->clusters_by_district;
                        $myTotalArray['district'] = $dist_name;
                    }
                }
                $clusters_by_district[] = $myTotalArray;
            }
            $data['totalcluster']['total'] = $totalcluster;
            $data['totalcluster']['list'] = $clusters_by_district;

            /*==============Randomization Clusters List==============*/
            $randomization = $MData_collection->total_rand_clusters($district, $sub_district, $level);
            $data['randomization']['total'] = 0;
            foreach ($randomization as $key => $val) {
                foreach ($dist_array as $k => $dist_name) {
                    if ($k == $val->dist_id) {
                        $data['randomization'][$dist_name] = $val->randomized_c;
                        $data['randomization']['total'] += $val->randomized_c;
                    }
                }
            }

            /*==============Completed & Pending Clusters List==============*/
            $completedClusters_district = $MData_collection->completed_rand_Clusters_district($district, $sub_district);
            if (isset($district) && $district != '') {
                $i = $district;
                foreach ($dist_array as $k => $dist_name) {
                    if ($k == $i) {
                        $data['completed'][$dist_name] = 0;
                        $data['r'][$dist_name] = 0;
                    }
                }
            } else {
                for ($i = 1; $i <= 9; $i++) {
                    foreach ($dist_array as $key => $dist_name) {
                        $data['completed'][$dist_name] = 0;
                        $data['r'][$dist_name] = 0;
                    }
                }
            }
            $data['completed']['total'] = 0;
            $data['r']['total'] = 0;
            foreach ($completedClusters_district as $row) {
                $ke = $row->provinceId;
                foreach ($dist_array as $key => $dist_name) {
                    if ($ke == $key) {
                        if ($row->hh_collected >= 18) {
                            $data['completed'][$dist_name]++;
                            $data['completed']['total']++;
                        } else {
                            $data['r'][$dist_name]++;
                            $data['r']['total']++;
                        }
                    }
                }
            }


            $this->load->view('include/header');
            $this->load->view('include/top_header');
            $this->load->view('include/sidebar');
            $this->load->view('data_collection/data_collection', $data);
            $this->load->view('include/customizer');
            $this->load->view('include/footer');
            $track_msg = 'Success';
        } else {
            $track_msg = 'errors/page-not-authorized';
            $this->load->view('errors/page-not-authorized', $data);
        }
        /*==========Log=============*/
        $Custom = new Custom();
        $trackarray = array(
            "activityName" => "DataCollection Main",
            "action" => "View DataCollection Province dashboard -> Function: Data_collection_progress/index()",
            "result" => $track_msg,
            "PostData" => "",
            "affectedKey" => "",
            "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
            "username" => $this->encrypt->decode($_SESSION['login']['username']),
        );
        $Custom->trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
    }

    function dc_index()
    {
        $data = array();
        $MSettings = new MSettings();
        $data['permission'] = $MSettings->getUserRights($this->encrypt->decode($_SESSION['login']['idGroup']), '', 'data_collection_progress');
        if (isset($data['permission'][0]->CanView) && $data['permission'][0]->CanView == 1) {

            $district = '';
            $sub_district = '';
            $level = 2;

            if (isset($data['permission'][0]->CanViewAllDetail) && $data['permission'][0]->CanViewAllDetail != 1 && isset($_SESSION['login']['district']) && $this->encrypt->decode($_SESSION['login']['district']) != 0) {
                $u_district = $this->encrypt->decode($_SESSION['login']['district']);
                $sub_district = $this->encrypt->decode($_SESSION['login']['district']);
            } else {
                $u_district = '';
            }

            $district_cluster_type = $this->uri->segment(3);
            if (!empty($district_cluster_type)) {
                if (!empty($u_district)) {
                    $sub_district = $u_district;
                }
                $district = substr($district_cluster_type, 1, 1);
            }


            $MLinelisting = new MLinelisting();
            $MData_collection = new MData_collection();

            $getClustersProvince = $MLinelisting->getClustersProvince($district, $sub_district, $level);
            $dist_array = array();
            if (isset($district) && $district != '') {
                foreach ($getClustersProvince as $k => $v) {
                    $dist_id = substr($v->dist_id, 0, 3);
                    $dist_array[$dist_id] = $v->district;
                }
            } else {
                foreach ($getClustersProvince as $k => $v) {
                    $dist_id = substr($v->dist_id, 0, 1);
                    $dist_array[$dist_id] = $v->province;
                }
            }
            $data['dist_array'] = $dist_array;

            /*==============Total Clusters List==============*/
            $totalClusters_district = $MLinelisting->totalClusters_district($district, $sub_district, $level);
            $totalcluster = 0;
            foreach ($totalClusters_district as $k => $r) {
                $dist = $r->provinceId;
                $distPro = $r->district;
                $totalcluster = $totalcluster + $r->clusters_by_district;
                if (isset($clusters_by_district[$distPro]) && $clusters_by_district[$distPro] != '') {
                    $clusters_by_district[$distPro]['clusters_by_district'] += $r->clusters_by_district;
                } else {
                    $clusters_by_district[$distPro]['clusters_by_district'] = $r->clusters_by_district;
                }
                $clusters_by_district[$distPro]['id'] = $dist;
            }

            $data['totalcluster']['total'] = $totalcluster;
            $data['totalcluster']['list'] = $clusters_by_district;

            /*==============Randomization Clusters List==============*/
            $randomization = $MData_collection->total_rand_clusters($district, $sub_district, $level);

            $data['randomization']['total'] = 0;
            foreach ($randomization as $key => $val) {
                foreach ($dist_array as $k => $dist_name) {
                    if ($k == $val->dist_id) {
                        $data['randomization'][$dist_name] = $val->randomized_c;
                        $data['randomization']['total'] += $val->randomized_c;
                    }
                }
            }

            /*==============Completed & Pending Clusters List==============*/
            $completedClusters_district = $MData_collection->completed_rand_Clusters_district($district, $sub_district, $level);
            if (isset($district) && $district != '') {
                foreach ($dist_array as $k => $dist_name) {
                    $data['completed'][$dist_name] = 0;
                    $data['r'][$dist_name] = 0;
                }
            } else {
                for ($i = 1; $i <= 9; $i++) {
                    foreach ($dist_array as $key => $dist_name) {
                        $data['completed'][$dist_name] = 0;
                        $data['r'][$dist_name] = 0;
                    }
                }
            }
            $data['completed']['total'] = 0;
            $data['r']['total'] = 0;
            foreach ($completedClusters_district as $row) {
                $ke = $row->provinceId;
                foreach ($dist_array as $key => $dist_name) {
                    if ($ke == $key) {
                        if ($row->hh_collected >= 18) {
                            $data['completed'][$dist_name]++;
                            $data['completed']['total']++;
                        } else {
                            $data['r'][$dist_name]++;
                            $data['r']['total']++;
                        }
                    }
                }
            }
            $this->load->view('include/header');
            $this->load->view('include/top_header');
            $this->load->view('include/sidebar');
            $this->load->view('data_collection/data_collection_districtLists', $data);
            $this->load->view('include/customizer');
            $this->load->view('include/footer');
            $track_msg = 'Success';
        } else {
            $track_msg = 'errors/page-not-authorized';
            $this->load->view('errors/page-not-authorized', $data);
        }
        /*==========Log=============*/
        $Custom = new Custom();
        $trackarray = array(
            "activityName" => "DataCollection Disrtict Dashboard",
            "action" => "View DataCollection Disrtict Dashboard page -> Function: Data_collection_progress/dc_index()",
            "result" => $track_msg,
            "PostData" => "",
            "affectedKey" => "",
            "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
            "username" => $this->encrypt->decode($_SESSION['login']['username']),
        );
        $Custom->trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
    }

    function dc_dt()
    {
        $data = array();
        $MSettings = new MSettings();
        $data['permission'] = $MSettings->getUserRights($this->encrypt->decode($_SESSION['login']['idGroup']), '', 'data_collection_progress');
        if (isset($data['permission'][0]->CanView) && $data['permission'][0]->CanView == 1) {

            $MData_collection = new MData_collection();

            $district_cluster_type = $this->uri->segment(3);
            $district = '';
            $sub_district = '';
            $cluster_type = '';
            if (!empty($district_cluster_type)) {
                $sub_district_cluster_type = $this->uri->segment(4);
                if (!empty($sub_district_cluster_type)) {
                    $sub_district = substr($sub_district_cluster_type, 1, 3);
                }
                $district = substr($district_cluster_type, 1, 1);
                $cluster_type = substr($district_cluster_type, 3, 1);
            }


            if ($cluster_type == 't' || $cluster_type == 'c' || $cluster_type == 'r' || $cluster_type == 'i') {

                $data['get_linelisting_table'] = $MData_collection->get_data_collection_rand_table($district, $cluster_type, $sub_district);
            } else {
                $data['get_linelisting_table'] = $MData_collection->get_data_collection_rand_table($district, 'r', $sub_district);
            }

            $this->load->view('include/header');
            $this->load->view('include/top_header');
            $this->load->view('include/sidebar');
            $this->load->view('data_collection/data_collection_dt', $data);
            $this->load->view('include/customizer');
            $this->load->view('include/footer');
            $track_msg = 'Success';
        } else {
            $track_msg = 'errors/page-not-authorized';
            $this->load->view('errors/page-not-authorized', $data);
        }
        /*==========Log=============*/
        $Custom = new Custom();
        $trackarray = array(
            "activityName" => "DataCollection Datatable Dashboard",
            "action" => "View DataCollection Datatable Dashboard page -> Function: Data_collection_progress/dc_dt()",
            "result" => $track_msg,
            "PostData" => "",
            "affectedKey" => "",
            "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
            "username" => $this->encrypt->decode($_SESSION['login']['username']),
        );
        $Custom->trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
    }

    function randomized_household()
    {
        $data = array();
        $data['cluster'] = $this->uri->segment(3);
        if (isset($data['cluster']) && $data['cluster'] != '') {
            $MData_collection = new MData_collection();
            $r_hh = $MData_collection->get_randomizedHH($data['cluster']);
            $data['data'] = $r_hh;
            foreach ($r_hh as $k => $v) {
                $sa = $MData_collection->get_HH_status($data['cluster'], $v->hhno);
                $data['data'][$k]->istatus = (isset($sa[0]->istatus) && $sa[0]->istatus != '' ? $sa[0]->istatus : 0);
                $data['data'][$k]->sample_collected = (isset($sa[0]->sample_collected) && $sa[0]->sample_collected != '' ? $sa[0]->sample_collected : 0);
                $data['data'][$k]->child_6_11months = (isset($sa[0]->child_6_11months) && $sa[0]->child_6_11months != '' ? $sa[0]->child_6_11months : 0);
                $data['data'][$k]->child_12_23months = (isset($sa[0]->child_12_23months) && $sa[0]->child_12_23months != '' ? $sa[0]->child_12_23months : 0);
            }
            $this->load->view('include/header');
            $this->load->view('include/top_header');
            $this->load->view('include/sidebar');
            $this->load->view('data_collection/randomized_hh', $data);
            $this->load->view('include/customizer');
            $this->load->view('include/footer');
            $track_msg = 'Success';
        } else {
            echo 'Invalid Cluster';
            $track_msg = 'Invalid Cluster';
        }
        /*==========Log=============*/
        $Custom = new Custom();
        $trackarray = array(
            "activityName" => "DataCollection randomized_household",
            "action" => "View DataCollection randomized_household -> Function: Data_collection_progress/randomized_household()",
            "result" => $track_msg,
            "PostData" => "",
            "affectedKey" => "",
            "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
            "username" => $this->encrypt->decode($_SESSION['login']['username']),
        );
        $Custom->trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
    }

    function collected_household()
    {
        $data = array();
        $data['cluster'] = $this->uri->segment(3);
        if (isset($data['cluster']) && $data['cluster'] != '') {
            $MData_collection = new MData_collection();
            $data['data'] = $MData_collection->get_collectedHH($data['cluster']);
            $this->load->view('include/header');
            $this->load->view('include/top_header');
            $this->load->view('include/sidebar');
            $this->load->view('data_collection/collected_hh', $data);
            $this->load->view('include/customizer');
            $this->load->view('include/footer');
            $track_msg = 'Success';
        } else {
            echo 'Invalid Cluster';
            $track_msg = 'Invalid Cluster';
        }
        /*==========Log=============*/
        $Custom = new Custom();
        $trackarray = array(
            "activityName" => "DataCollection collected_household",
            "action" => "View DataCollection collected_household -> Function: Data_collection_progress/collected_household()",
            "result" => $track_msg,
            "PostData" => "",
            "affectedKey" => "",
            "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
            "username" => $this->encrypt->decode($_SESSION['login']['username']),
        );
        $Custom->trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
    }

    function completed_household()
    {
        $data = array();
        $data['cluster'] = $this->uri->segment(3);
        if (isset($data['cluster']) && $data['cluster'] != '') {
            $MData_collection = new MData_collection();
            $data['data'] = $MData_collection->get_completedHH($data['cluster']);
            $this->load->view('include/header');
            $this->load->view('include/top_header');
            $this->load->view('include/sidebar');
            $this->load->view('data_collection/completed_hh', $data);
            $this->load->view('include/customizer');
            $this->load->view('include/footer');
            $track_msg = 'Success';
        } else {
            echo 'Invalid Cluster';
            $track_msg = 'Invalid Cluster';
        }
        /*==========Log=============*/
        $Custom = new Custom();
        $trackarray = array(
            "activityName" => "DataCollection completed_household",
            "action" => "View DataCollection completed_household -> Function: Data_collection_progress/completed_household()",
            "result" => $track_msg,
            "PostData" => "",
            "affectedKey" => "",
            "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
            "username" => $this->encrypt->decode($_SESSION['login']['username']),
        );
        $Custom->trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
    }

    function refused_household()
    {
        $data = array();
        $data['cluster'] = $this->uri->segment(3);
        if (isset($data['cluster']) && $data['cluster'] != '') {
            $MData_collection = new MData_collection();
            $data['data'] = $MData_collection->get_refusedHH($data['cluster']);
            $this->load->view('include/header');
            $this->load->view('include/top_header');
            $this->load->view('include/sidebar');
            $this->load->view('data_collection/refused_hh', $data);
            $this->load->view('include/customizer');
            $this->load->view('include/footer');
            $track_msg = 'Success';
        } else {
            echo 'Invalid Cluster';
            $track_msg = 'Invalid Cluster';
        }
        /*==========Log=============*/
        $Custom = new Custom();
        $trackarray = array(
            "activityName" => "DataCollection refused_household",
            "action" => "View DataCollection refused_household -> Function: Data_collection_progress/refused_household()",
            "result" => $track_msg,
            "PostData" => "",
            "affectedKey" => "",
            "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
            "username" => $this->encrypt->decode($_SESSION['login']['username']),
        );
        $Custom->trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
    }

}