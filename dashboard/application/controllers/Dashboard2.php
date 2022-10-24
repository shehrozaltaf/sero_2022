<?php error_reporting(0);
ini_set('memory_limit', '256M'); // This also needs to be increased in some cases. Can be changed to a higher value as per need)
ini_set('sqlsrv.ClientBufferMaxKBSize', '524288'); // Setting to 512M
ini_set('pdo_sqlsrv.client_buffer_max_kb_size', '524288');

class Dashboard extends CI_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('custom');
        $this->load->model('msettings');
        $this->load->model('mlinelisting');
        if (!isset($_SESSION['login']['idUser'])) {
            redirect(base_url());
        }
    }

    function index()
    {
        $data = array();
        /*==========Log=============*/
        $Custom = new Custom();
        $trackarray = array("action" => "View LineListing Dashboard",
            "result" => "View LineListing Dashboard page. Fucntion: dashboard/index()");
//        $Custom->trackLogs($trackarray, "user_logs");
        /*==========Log=============*/
        $MSettings = new MSettings();
        $data['permission'] = $MSettings->getUserRights($_SESSION['login']['idGroup'], '', 'Dashboard');

        if (isset($data['permission'][0]->CanViewAllDetail) && $data['permission'][0]->CanViewAllDetail != 1) {
            $district = $_SESSION['login']['district'];
        } else {
            $district = '';
        }

        $MLinelisting = new MLinelisting();

        $district_cluster_type = $this->uri->segment(3);
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
        $getClustersProvince = $MLinelisting->getClustersProvince($district, $sub_district);
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
        /*
                echo '<pre>';
                print_r($dist_array);
                echo '</pre>';
                exit();

                $dist_array = array(
                    '1' => 'Khyber Pakhtunkhwa',
                    '2' => 'Punjab',
                    '3' => 'Sindh',
                    '4' => 'Balochistan',
                    '7' => 'Giligit Balististan',
                    '8' => 'Azad Jammu & Kashmir'
                );*/
        $data['dist_array'] = $dist_array;
        /*==============Total Clusters List==============*/
        $totalClusters_district = $MLinelisting->totalClusters_district($district, $sub_district);
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

        /*==============Completed Clusters List==============*/
        $completedClusters_district = $MLinelisting->completedClusters_district($district, $sub_district);
        if (isset($district) && $district != '') {
            $i = $district;
            foreach ($dist_array as $k => $dist_name) {
                $data['total'][$dist_name] = 0;
                $data['completed'][$dist_name] = 0;
                $data['ip'][$dist_name] = 0;
                $data['r'][$dist_name] = 0;
            }
        } else {
            for ($i = 1; $i <= 9; $i++) {
                foreach ($dist_array as $key => $dist_name) {
                    $data['total'][$dist_name] = 0;
                    $data['completed'][$dist_name] = 0;
                    $data['ip'][$dist_name] = 0;
                    $data['r'][$dist_name] = 0;

                }
            }
        }

        $data['total']['total'] = 0;
        $data['completed']['total'] = 0;
        $data['ip']['total'] = 0;
        foreach ($completedClusters_district as $row) {
            $ke = $row->provinceId;
            foreach ($dist_array as $key => $dist_name) {
                if ($ke == $key) {
                    $data['total']['total']++;
                    $data['total'][$dist_name]++;
                    if ($row->collecting_tabs == $row->completed_tabs) {
                        $data['completed'][$dist_name]++;
                        $data['completed']['total']++;
                    } else {
                        $data['ip'][$dist_name]++;
                        $data['ip']['total']++;
                    }
                }
            }
        }

        /*==============Remaining Clusters List==============*/
        $data['r']['total'] = 0;

        foreach ($totalClusters_district as $row2) {
            $ke = $row2->provinceId;
            foreach ($dist_array as $key => $dist_name) {
                if ($ke == $key) {
                    $data['r'][$dist_name] = $row2->clusters_by_district - $data['total'][$dist_name];
                    $data['r']['total'] += $data['r'][$dist_name];
                }
            }
        }

        /*============== Linelisting Data table ==============*/
        /* $data['cluster_type'] = $cluster_type;
         if ($cluster_type == 'c' || $cluster_type == 'i' || $cluster_type == 'r') {
             $data['get_linelisting_table'] = $MLinelisting->get_linelisting_table($district, $cluster_type, $sub_district);
         } else {
 //            $data['get_linelisting_table'] = $MLinelisting->get_linelisting_table($district, '', $sub_district);
             $data['get_linelisting_table'] = '';
         }*/

        $this->load->view('include/header');
        $this->load->view('include/top_header');
        $this->load->view('include/sidebar');
        $this->load->view('linelisting', $data);
        $this->load->view('include/customizer');
        $this->load->view('include/footer');
    }

    function dashboard_index()
    {
        $data = array();
        /*==========Log=============*/
        $Custom = new Custom();
        $trackarray = array("action" => "View LineListing Dashboard",
            "result" => "View LineListing Dashboard page. Fucntion: dashboard/index()");
//        $Custom->trackLogs($trackarray, "user_logs");
        /*==========Log=============*/
        $MSettings = new MSettings();
        $data['permission'] = $MSettings->getUserRights($_SESSION['login']['idGroup'], '', 'Dashboard');

        if (isset($data['permission'][0]->CanViewAllDetail) && $data['permission'][0]->CanViewAllDetail != 1) {
            $district = $_SESSION['login']['district'];
        } else {
            $district = '';
        }

        $MLinelisting = new MLinelisting();

        $district_cluster_type = $this->uri->segment(3);
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

        $getClustersProvince = $MLinelisting->getClustersProvince($district, $sub_district);
        $dist_array = array();
        foreach ($getClustersProvince as $k => $v) {
            $dist_id = substr($v->dist_id, 0, 3);
            $dist_array[$dist_id] = $v->district;
        }
        /*
        $dist_array = array(
            '1' => 'Khyber Pakhtunkhwa',
            '2' => 'Punjab',
            '3' => 'Sindh',
            '4' => 'Balochistan',
            '7' => 'Giligit Balististan',
            '8' => 'Azad Jammu & Kashmir'
        );*/
        $data['dist_array'] = $dist_array;
        /*==============Total Clusters List==============*/
        $totalClusters_district = $MLinelisting->totalClusters_districtOthers($district, $sub_district);
        $totalcluster = 0;

        /*  echo '<pre>';
          print_r();
          echo '</pre>';
          exit();*/
        foreach ($totalClusters_district as $k => $r) {
            /*  $exp = explode('|', $r->geoarea);
              $dist = trim($exp[1]);*/
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

        /*==============Completed Clusters List==============*/
        $completedClusters_district = $MLinelisting->completedClusters_district_other($district, $sub_district);

        if (isset($district) && $district != '') {
            $i = $district;
            foreach ($dist_array as $k => $dist_name) {
                $data['total'][$dist_name] = 0;
                $data['completed'][$dist_name] = 0;
                $data['ip'][$dist_name] = 0;
                $data['r'][$dist_name] = 0;
            }
        } else {
            for ($i = 1; $i <= 9; $i++) {
                foreach ($dist_array as $key => $dist_name) {
                    $data['total'][$dist_name] = 0;
                    $data['completed'][$dist_name] = 0;
                    $data['ip'][$dist_name] = 0;
                    $data['r'][$dist_name] = 0;

                }
            }
        }

        $data['total']['total'] = 0;
        $data['completed']['total'] = 0;
        $data['ip']['total'] = 0;
        foreach ($completedClusters_district as $row) {
            $ke = $row->provinceId;
            foreach ($dist_array as $key => $dist_name) {
                if ($ke == $key) {
                    $data['total']['total']++;
                    $data['total'][$dist_name]++;
                    if ($row->collecting_tabs == $row->completed_tabs) {
                        $data['completed'][$dist_name]++;
                        $data['completed']['total']++;
                    } else {
                        $data['ip'][$dist_name]++;
                        $data['ip']['total']++;
                    }
                }
            }
        }


        /*==============Remaining Clusters List==============*/
        $data['r']['total'] = 0;

        foreach ($totalClusters_district as $row2) {
            $ke = $row2->provinceId;
            foreach ($dist_array as $key => $dist_name) {
                if ($ke == $key) {
                    $data['r'][$dist_name] = $row2->clusters_by_district - $data['total'][$dist_name];
                    $data['r']['total'] += $data['r'][$dist_name];
                }
            }
        }

        /*============== Linelisting Data table ==============*/
        $data['cluster_type'] = $cluster_type;
        if ($cluster_type == 'c' || $cluster_type == 'i' || $cluster_type == 'r') {
            $data['get_linelisting_table'] = $MLinelisting->get_linelisting_table($district, $cluster_type, $sub_district);
        } else {
            $data['get_linelisting_table'] = $MLinelisting->get_linelisting_table($district, '', $sub_district);
        }

        $this->load->view('include/header');
        $this->load->view('include/top_header');
        $this->load->view('include/sidebar');
        $this->load->view('linelisting_districtLists', $data);
        $this->load->view('include/customizer');
        $this->load->view('include/footer');
    }

    function dashboard_dt()
    {
        $data = array();
        /*==========Log=============*/
        $Custom = new Custom();
        $trackarray = array("action" => "View LineListing Dashboard",
            "result" => "View LineListing Dashboard page. Fucntion: dashboard/index()");
//        $Custom->trackLogs($trackarray, "user_logs");
        /*==========Log=============*/
        $MSettings = new MSettings();
        $data['permission'] = $MSettings->getUserRights($_SESSION['login']['idGroup'], '', 'Dashboard');

        if (isset($data['permission'][0]->CanViewAllDetail) && $data['permission'][0]->CanViewAllDetail != 1) {
            $district = $_SESSION['login']['district'];
        } else {
            $district = '';
        }

        $MLinelisting = new MLinelisting();

        $district_cluster_type = $this->uri->segment(3);
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


        /*============== Linelisting Data table ==============*/
        $data['cluster_type'] = $cluster_type;
        if ($cluster_type == 'c' || $cluster_type == 'i' || $cluster_type == 'r') {
            $data['get_linelisting_table'] = $MLinelisting->get_linelisting_table($district, $cluster_type, $sub_district);
        } else {
            $data['get_linelisting_table'] = '';
            $data['get_linelisting_table'] = $MLinelisting->get_linelisting_table($district, '', $sub_district);
        }

        $this->load->view('include/header');
        $this->load->view('include/top_header');
        $this->load->view('include/sidebar');
        $this->load->view('linelisting_datatable', $data);
        $this->load->view('include/customizer');
        $this->load->view('include/footer');
    }

    function systematic_randomizer()
    {
        $sample = 13;
//        $cluster = $this->uri->segment(3);
        if (isset($_POST['cluster_no']) && $_POST['cluster_no'] != '') {
            $cluster = $_POST['cluster_no'];
            $MLinelisting = new MLinelisting();
            $get_rand_cluster = $MLinelisting->get_rand_cluster($cluster);
            $randomization_status = $get_rand_cluster[0]->randomized;
            if ($randomization_status == 1) {
                echo 2;
            } else {
                $get_systematic_rand = $MLinelisting->get_systematic_rand($cluster);
                $cnt = count($get_systematic_rand);
                if ($cnt >= 1) {
                    $get_residential_structures = $MLinelisting->get_residential_structures($cluster);
                    $residential_structures = count($get_residential_structures);
                    $updateCluster = array();
                    $updateCluster['randomized'] = 1;
                    $editData = $MLinelisting->update_cluster($updateCluster, 'cluster_no', $cluster, 'clusters');
                    if ($editData) {
                        if ($cnt > $sample) {
                            $quotient = $cnt / $sample;
                            $counter = $sample;
                        } else {
                            $quotient = $cnt / $cnt;
                            $counter = $cnt;
                        }
                        $random_start = rand(1, $quotient);
                        for ($i = 0; $i < $counter; $i++) {
                            $data = array(
                                'randDT' => date('Y-m-d h:i:s'),
                                'uid' => $get_systematic_rand[$i]->uid,
                                'sno' => $i + 1,
                                'hh02' => $get_systematic_rand[$i]->hh02,
                                'hh03' => $get_systematic_rand[$i]->hh03,
                                'hh07' => $get_systematic_rand[$i]->hh07,
                                'hh08' => $get_systematic_rand[$i]->hh08,
                                'hh09' => $get_systematic_rand[$i]->hh09,
                                'total' => $residential_structures,
                                'randno' => $random_start,
                                'quot' => $quotient,
                                'hhdt' => $get_systematic_rand[$i]->hhdt,
                                'dist_id' => $get_systematic_rand[$i]->enumcode,
                                'compid' => $get_systematic_rand[$i]->hh02 . '-' . $get_systematic_rand[$i]->tabNo . "-" . str_pad($get_systematic_rand[$i]->hh03, 4, "0", STR_PAD_LEFT) . "-" . str_pad($get_systematic_rand[$i]->hh07, 3, "0", STR_PAD_LEFT),
                                'tabNo' => $get_systematic_rand[$i]->tabNo,
                                'user_id' => $_SESSION['login']['UserName']
                            );
                            $insert_blrandomize = $MLinelisting->insert_blrandomize($data, 'bl_randomised');
                        }
                        echo 1;
                    } else {
                        echo 5;
                    }
                } else {
                    echo 3;
                }
            }
        } else {
            echo 4;
        }
    }

    function make_pdf()
    {
        $data = array();
        $data['cluster'] = $this->uri->segment(3);
        if (isset($data['cluster']) && $data['cluster'] != '') {
            $this->load->library('tcpdf');
            $MLinelisting = new MLinelisting();
            $data['cluster_data'] = $MLinelisting->get_bl_randomized($data['cluster']);
            $data['randomization_date'] = substr($data['cluster_data'][0]->randDT, 0, 10);
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('TPVICS');
            $pdf->SetTitle('Cluster No: ' . $data['cluster']);
            $pdf->SetSubject('TPVICS');
            $pdf->SetKeywords('TPVICS');
            $geoarea = explode('|', $data['cluster_data'][0]->geoarea);
            $pdf->SetHeaderData('', '', 'TPVICS - Cluster No: ' . $data['cluster'], 'Province: ' . $geoarea[0]
                . "\n" . 'District: ' . $geoarea[1] . "\n" . 'Tehsil: ' . $geoarea[2] . "\n" . 'Area: ' . $geoarea[3]
                . "\n" . 'Planned Collection Date: ' . $data['cluster_data'][0]->collection_date  . ' --- Collector Name: ' . $data['cluster_data'][0]->collector_name . ' --- Tablet ID: ' . $data['cluster_data'][0]->tablet_id
                , PDF_HEADER_STRING);
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP + 5, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
            if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
                require_once(dirname(__FILE__) . '/lang/eng.php');
                $pdf->setLanguageArray($l);
            }
            $pdf->SetFont('helvetica', 'B', 8);
            $pdf->AddPage();
            $pdf->Write(0, 'Randomization Date: ' . $data['randomization_date'], '', 0, 'R', true, 0, false, false, 0);
            $pdf->SetFont('helvetica', '', 9);
            $tbl = '<table border="1" cellpadding="0" cellspacing="0" >
                 <tr>
                  <th width="10%" style="text-align:center"><b>Serial No</b></th> 
                  <th width="20%" style="text-align:center"><b>Household No</b></th>
                  <th width="20%" style="text-align:center"><b>Head of Household</b></th>
                  <th width="50%" style="text-align:center; "><b>Remarks</b></th>
                 </tr>';
            foreach ($data['cluster_data'] as $row) {
                $tbl .= '<tr  border="0"><td  border="0" style="text-align:center">' . $row->sno . '</td> 
<td style="text-align:center">' . $row->tabNo . '-' . substr($row->compid, 10, 8) . '</td>
<td style="text-align:center">' . ucfirst($row->hh08) . '</td>
<td style="text-align:center; height: 27px"  border="0"> </td>
</tr>';
            }
            $tbl .= '</table>';
            $pdf->writeHTML($tbl, true, false, true, false, '');
            $pdf->Output('randmozied.pdf', 'I');
            ob_end_flush();
            ob_end_clean();
        } else {
            echo 'Invalid Cluster';
        }
    }

    function get_excel()
    {
        $data = array();
        $data['cluster'] = $this->uri->segment(3);
        if (isset($data['cluster']) && $data['cluster'] != '') {
            $MLinelisting = new MLinelisting();
            $data['cluster_data'] = $MLinelisting->get_bl_randomized($data['cluster']);
            $this->load->view('include/header');
            $this->load->view('include/top_header');
            $this->load->view('include/sidebar');
            $this->load->view('get_excel', $data);
            $this->load->view('include/customizer');
            $this->load->view('include/footer');

        } else {
            echo 'Invalid Cluster';
        }
    }

    function addPlanning()
    {
        ob_end_clean();
        $flag = 0;
        if (!isset($_POST['planning_cluster']) || $_POST['planning_cluster'] == '') {
            $flag = 1;
            $result = 2;
            echo $result;
            die();
        }

        if (!isset($_POST['planning_dist']) || $_POST['planning_dist'] == '') {
            $flag = 1;
            $result = 3;
            echo $result;
            die();
        }

        if (!isset($_POST['listing_date']) || $_POST['listing_date'] == '') {
            $flag = 1;
            $result = 4;
            echo $result;
            die();
        }
        if (!isset($_POST['dc1']) || $_POST['dc1'] == '') {
            $flag = 1;
            $result = 5;
            echo $result;
            die();
        }
        if ($flag == 0) {
            $cluster = $_POST['planning_cluster'];
            $Custom = new Custom();
            $formArray = array();

            $formArray['listing_date'] = date('Y-m-d', strtotime($_POST['listing_date']));
            $formArray['tablets'] = $_POST['tablet_using'];
            $formArray['dc1'] = $_POST['dc1'];
            $formArray['dc2'] = $_POST['dc2'];
            $formArray['status'] = 1;
            $formArray['createdBy'] = $_SESSION['login']['idUser'];
            $formArray['createdDateTime'] = date('Y-m-d H:i:s');

            $M = new MLinelisting();
            $data = $M->get_planning($cluster);
            if (isset($data) && $data[0]->cluster_no != '') {
                $InsertData = $Custom->Edit($formArray, 'cluster_no', $cluster, 'planning');
            } else {
                $formArray['cluster_no'] = $cluster;
                $formArray['province'] = substr($_POST['planning_cluster'], 0, 1);
                $formArray['dist'] = $_POST['planning_dist'];
                $InsertData = $Custom->Insert($formArray, 'id', 'planning', 'N');
            }


            if ($InsertData) {
                $result = 1;
            } else {
                $result = 6;
            }
            $trackarray = array("action" => "Dashboard/ Add Planning before randomization -> Function: addPlanning() Add Planning before linelisting randomization ",
                "result" => $InsertData, "PostData" => $formArray);
            $Custom->trackLogs($trackarray, "user_logs");
        } else {
            $result = 4;
        }
        echo $result;
    }

    function add_dc_Planning()
    {
        ob_end_clean();
        $flag = 0;
        if (!isset($_POST['planning_cluster']) || $_POST['planning_cluster'] == '') {
            $flag = 1;
            $result = 2;
            echo $result;
            die();
        }

        if (!isset($_POST['collection_date']) || $_POST['collection_date'] == '') {
            $flag = 1;
            $result = 4;
            echo $result;
            die();
        }
        if (!isset($_POST['collector_name']) || $_POST['collector_name'] == '') {
            $flag = 1;
            $result = 5;
            echo $result;
            die();
        }
        if (!isset($_POST['tablet_id']) || $_POST['tablet_id'] == '') {
            $flag = 1;
            $result = 7;
            echo $result;
            die();
        }
        if ($flag == 0) {
            $cluster = $_POST['planning_cluster'];
            $Custom = new Custom();
            $formArray = array();

            $formArray['collector_name'] = $_POST['collector_name'];
            $formArray['collection_date'] = date('Y-m-d', strtotime($_POST['collection_date']));
            $formArray['tablet_id'] = $_POST['tablet_id'];
            $formArray['status'] = 2;
            $formArray['updateBy'] = $_SESSION['login']['idUser'];
            $formArray['updatedDateTime'] = date('Y-m-d H:i:s');

            $M = new MLinelisting();
            $data = $M->get_planning($cluster);

            if (isset($data) && $data[0]->cluster_no != '') {
                $InsertData = $Custom->Edit($formArray, 'cluster_no', $cluster, 'planning');
            } else {
                $formArray['cluster_no'] = $cluster;
                $formArray['province'] = substr($_POST['planning_cluster'], 0, 1);
                $formArray['dist'] = (isset($_POST['planning_dist']) && $_POST['planning_dist'] != '' ? $_POST['planning_dist'] : substr($_POST['planning_cluster'], 0, 3));
                $InsertData = $Custom->Insert($formArray, 'id', 'planning', 'N');
            }


            if ($InsertData) {
                $result = 1;
            } else {
                $result = 6;
            }
            $trackarray = array("action" => "Dashboard/ Add Planning after randomization -> Function: addPlanning() Add Planning after dc randomization ",
                "result" => $InsertData, "PostData" => $formArray);
            $Custom->trackLogs($trackarray, "user_logs");
        } else {
            $result = 4;
        }
        echo $result;
    }

    function viewPlanning()
    {
        $M = new MLinelisting();
        $data = $M->get_planning($_POST['cluster']);
        echo json_encode($data, true);
    }


    /*Setting Page, User Rights*/
    function getMenuData()
    {
        $this->load->model('msettings');
        $idGroup = $_SESSION['login']['idGroup'];
        $Menu = '';
        $Msetting = new MSettings();
        $getDataRights = $Msetting->getUserRights($idGroup, '1', '');
        if (isset($getDataRights) && count($getDataRights) >= 1) {

            $myresult = array();
            foreach ($getDataRights as $key => $value) {
                if (isset($value->idParent) && $value->idParent != '' && array_key_exists(strtolower($value->idParent), $myresult)) {
                    $mykey = strtolower($value->idParent);
                    $myresult[strtolower($mykey)]->myrow_options[] = $value;
                } else {
                    $mykey = strtolower($value->idPages);
                    $myresult[strtolower($mykey)] = $value;
                }
            }
            foreach ($myresult as $pages) {
                if ($pages->isParent == 1) {
                    $Menu .= '<li class=" nav-item   ' . $pages->menuClass . ' has-sub">
                                      <a href="javascript:void(0)"> 
                                         <i class="feather ' . $pages->menuIcon . '"></i>
                                          <span class="menu-title" data-i18n="' . $pages->pageName . '">' . $pages->pageName . '</span>
                                       </a>
                                       <ul class="menu-content"> ';
                    if (isset($pages->myrow_options) && $pages->myrow_options != '') {
                        foreach ($pages->myrow_options as $options) {
                            $Menu .= ' <li class="' . $options->menuClass . '">
                                        <a href="' . base_url('index.php/' . $options->pageUrl) . '">
                                            <i class="feather ' . $options->menuIcon . '"></i>
                                            <span class="menu-item" data-i18n="' . $options->pageName . '">' . $options->pageName . '</span> 
                                        </a>
                                      </li>';
                        }
                    }
                    $Menu .= ' </ul></li>';
                } else {
                    $Menu .= '<li class=" nav-item ' . $pages->menuClass . '">
                                    <a href="' . base_url('index.php/' . $pages->pageUrl) . '" class="">
                                        <i class="feather ' . $pages->menuIcon . '"></i>
                                        <span class="menu-title" data-i18n="' . $pages->pageName . '">' . $pages->pageName . '</span>
                                    </a>
                              </li>';
                }
            }
        } else {
            $Menu = '';
        }
        $Menu .= ' <li class=" nav-item">
                <a href="javascript:void(0)" onclick="logout()">
                    <i class="feather icon-power"></i>
                    <span class="menu-title" data-i18n="Logout">Logout</span>
                </a>
            </li>';
        echo $Menu;
    }

}

?>