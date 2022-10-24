<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit', '512M'); // This also needs to be increased in some cases. Can be changed to a higher value as per need)
ini_set('sqlsrv.ClientBufferMaxKBSize', '524288'); // Setting to 512M
ini_set('pdo_sqlsrv.client_buffer_max_kb_size', '524288');

class ProgressReportEmail extends CI_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('custom');
        $this->load->model('msettings');
        $this->load->model('mlinelisting');
        $this->load->model('mdata_collection');
    }

    function index()
    {
        $data = array();
        /*==========Log=============*/
        $Custom = new Custom();
        $trackarray = array("action" => "View ProgressReportEmail",
            "result" => "View ProgressReportEmail page. Fucntion: ProgressReportEmail/index()");
        $Custom->trackLogs($trackarray, "user_logs");
        /*==========Log=============*/
        $MSettings = new MSettings();
        $data['permission'] = $MSettings->getUserRights($this->encrypt->decode($_SESSION['login']['idGroup']), '', 'ProgressReportEmail');


        $data['province'] = $Custom->getProvinces();

        $this->load->view('include/header');
        $this->load->view('include/top_header');
        $this->load->view('include/sidebar');
        $this->load->view('progressReportEmail', $data);
        $this->load->view('include/customizer');
        $this->load->view('include/footer');
    }

    function getUsers()
    {
        $this->load->model('muser');
        $MUser = new MUser();
        $orderindex = (isset($_REQUEST['order'][0]['column']) ? $_REQUEST['order'][0]['column'] : '');
        $orderby = (isset($_REQUEST['columns'][$orderindex]['name']) ? $_REQUEST['columns'][$orderindex]['name'] : '');
        $searchData = array();
        $searchData['province'] = (isset($_REQUEST['province']) && $_REQUEST['province'] != '' && $_REQUEST['province'] != 0 ? $_REQUEST['province'] : 0);
        $searchData['district'] = (isset($_REQUEST['district']) && $_REQUEST['district'] != '' && $_REQUEST['district'] != 0 ? $_REQUEST['district'] : 0);
        $searchData['start'] = (isset($_REQUEST['start']) && $_REQUEST['start'] != '' && $_REQUEST['start'] != 0 ? $_REQUEST['start'] : 0);
        $searchData['length'] = (isset($_REQUEST['length']) && $_REQUEST['length'] != '' ? $_REQUEST['length'] : 50);
        $searchData['search'] = (isset($_REQUEST['search']['value']) && $_REQUEST['search']['value'] != '' ? $_REQUEST['search']['value'] : '');
        $searchData['orderby'] = (isset($orderby) && $orderby != '' ? $orderby : 'username');
        $searchData['ordersort'] = (isset($_REQUEST['order'][0]['dir']) && $_REQUEST['order'][0]['dir'] != '' ? $_REQUEST['order'][0]['dir'] : 'desc');
        $searchData['idGroup'] = 3;
        $data = $MUser->getAllUserByGroup($searchData);
        $table_data = array();
        $result_table_data = array();

        foreach ($data as $key => $value) {
            $table_data[$value->username]['full_name'] = $value->full_name;
            $table_data[$value->username]['username'] = $value->username;
            $table_data[$value->username]['email'] = $value->email;
            $table_data[$value->username]['designation'] = $value->designation;
            $table_data[$value->username]['contact'] = $value->contact;
            $table_data[$value->username]['district'] = $value->district;
            $table_data[$value->username]['action'] = '<input type="checkbox"  name="CanViewAllDetail" value="' . $value->email . '" id="CanViewAllDetail' . $key . '"  />';
        }
        foreach ($table_data as $k => $v) {
            $result_table_data[] = $v;
        }

        $result["draw"] = (isset($_REQUEST['draw']) && $_REQUEST['draw'] != '' ? $_REQUEST['draw'] : 0);
        $totalsearchData = array();
        $totalsearchData['start'] = 0;
        $totalsearchData['length'] = 100000;
        $totalsearchData['province'] = (isset($_REQUEST['province']) && $_REQUEST['province'] != '' && $_REQUEST['province'] != 0 ? $_REQUEST['province'] : 0);
        $totalsearchData['district'] = (isset($_REQUEST['district']) && $_REQUEST['district'] != '' && $_REQUEST['district'] != 0 ? $_REQUEST['district'] : 0);
        $totalsearchData['search'] = (isset($_REQUEST['search']['value']) && $_REQUEST['search']['value'] != '' ? $_REQUEST['search']['value'] : '');
        $totalsearchData['idGroup'] = 3;
        $totalrecords = $MUser->getAllUserByGroup($totalsearchData);

        $result["recordsTotal"] = count($totalrecords);
        $result["recordsFiltered"] = count($totalrecords);
        $result["data"] = $result_table_data;

        echo json_encode($data, true);
    }

    function sendEmail()
    {
        $this->load->model('muser');
        $MUser = new MUser();

        if (isset($_POST['report_date']) && $_POST['report_date'] != '' && $_POST['report_date'] != 'undefined') {
            $todaydate = date('d-m-y', strtotime($_POST['report_date']));
        } else {
            $todaydate = date('d-m-y');
            $todaydate = '31-08-20';
        }
        if (isset($_POST['users']) && $_POST['users'] != '' && $_POST['users'] != 'undefined') {
            foreach ($_POST['users'] as $users) {
                $getUserByUsername = $MUser->getUserByUsername($users['username']);
                $full_name = $getUserByUsername[0]->full_name;
                $email = $getUserByUsername[0]->email;
                $district = $getUserByUsername[0]->district;
                $sub_district = $getUserByUsername[0]->district;
            }
        } else {
            $users = $MUser->getEmailUsers();
            foreach ($users as $getUserByUsername) {
                $full_name = $getUserByUsername->full_name;
                $email = $getUserByUsername->email;
                $district = $getUserByUsername->district;
                $sub_district = $getUserByUsername->district;
            }
        }
 
        $district = '3';
        $sub_district = '315';
        $MLinelisting = new MLinelisting();
        $listing = $MLinelisting->get_linelisting_table($district, '', $sub_district, $todaydate);

        $this->load->library('tcpdf');

        /*====================== Linelistins Start ======================*/
        $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('TPVICS - Daily Listing Progress');
        $pdf->SetTitle('Daily Listing Progress: ' . $todaydate);
        $pdf->SetSubject('TPVICS - Daily Listing Progress');
        $pdf->SetKeywords('TPVICS - Daily Listing Progress');
        $geoarea = explode('|', $listing[0]->geoarea);
        $pdf->SetHeaderData('', '', 'TPVICS - Daily Listing Progress: ', 'Province: ' . $geoarea[0]
            . "\n" . 'District: ' . $geoarea[1], PDF_HEADER_STRING);
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP + 5, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetDefaultMonospacedFont('helvetica');
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->AddPage();
        $pdf->Write(0, 'Report Date: ' . $todaydate, '', 0, 'R', true, 0, false, false, 0);
        $pdf->SetFont('helvetica', '', 9);
        $tbl = '<table border="1" cellpadding="0" cellspacing="0" >
                 <tr>
                  <th style="text-align:center"><b>Cluster No</b></th> 
                  <th style="text-align:center"><b>Tehsil</b></th> 
                  <th style="text-align:center"><b>Area</b></th> 
                  <th style="text-align:center"><b>Structures</b></th> 
                  <th style="text-align:center"><b>Residential Structures</b></th> 
                  <th style="text-align:center"><b>Target Children</b></th> 
                  <th style="text-align:center"><b>No of Children</b></th> 
                  <th style="text-align:center"><b>Collecting Tabs</b></th> 
                  <th style="text-align:center"><b>Completed Tabs</b></th> 
                  <th style="text-align:center"><b>Status</b></th>  
                 </tr>';
        foreach ($listing as $k => $row) {
            if ($row->structures == 0 || $row->structures == '') {
                $stat = 'Remaining';
            } else if ($row->collecting_tabs != $row->completed_tabs) {
                $stat = 'In Progress';
            } else if ($row->status != '1') {
                $stat = 'Ready to Randomize';
            } else {
                $stat = 'Randomized';
            }
            $geoareas = explode('|', $row->geoarea);

            $tbl .= '<tr  border="0">
<td  border="0" style="text-align:center">' . $row->cluster_no . '</td>  
<td   style="text-align:center">' . $geoareas[2] . '</td>  
<td   style="text-align:center">' . $geoareas[3] . '</td>  
<td   style="text-align:center">' . $row->structures . '</td>  
<td   style="text-align:center">' . $row->residential_structures . '</td>  
<td   style="text-align:center">' . $row->target_children . '</td>  
<td   style="text-align:center">' . $row->no_of_children . '</td>  
<td   style="text-align:center">' . $row->collecting_tabs . '</td>  
<td   style="text-align:center">' . $row->completed_tabs . '</td>  
<td   style="text-align:center">' . $stat . '</td>   
</tr>';
        }
        $tbl .= '</table>';
        $pdf->writeHTML($tbl, true, false, true, false, '');
        $pdff = $pdf->Output('linelisting.pdf', 'S');
        /*====================== Linelistins End ======================*/

        /*====================== Data Collection Start ======================*/
        $MData_collection = new MData_collection();
        $dc_data = $MData_collection->get_data_collection_rand_table($district, '', $sub_district);
        $dc_pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $dc_pdf->SetCreator(PDF_CREATOR);
        $dc_pdf->SetCreator(PDF_CREATOR);
        $dc_pdf->SetAuthor('TPVICS - Daily Data Collection Progress');
        $dc_pdf->SetTitle('Daily Data Collection Progress: ' . $todaydate);
        $dc_pdf->SetSubject('TPVICS - Daily Data Collection Progress');
        $dc_pdf->SetKeywords('TPVICS - Daily Data Collection Progress');
        $geoarea = explode('|', $dc_data[0]->geoarea);
        $dc_pdf->SetHeaderData('', '', 'TPVICS - Daily Data Collection Progress: ', 'Province: ' . $geoarea[0]
            . "\n" . 'District: ' . $geoarea[1], PDF_HEADER_STRING);
        $dc_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $dc_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $dc_pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $dc_pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP + 5, PDF_MARGIN_RIGHT);
        $dc_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $dc_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $dc_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $dc_pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $dc_pdf->SetDefaultMonospacedFont('helvetica');
        $dc_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $dc_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $dc_pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $dc_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $dc_pdf->SetFont('helvetica', 'B', 8);
        $dc_pdf->AddPage();
        $dc_pdf->Write(0, 'Report Date: ' . $todaydate, '', 0, 'R', true, 0, false, false, 0);
        $dc_pdf->SetFont('helvetica', '', 9);

        $dc_tbl = '<table border="1" cellpadding="0" cellspacing="0" >
                 <tr>
                  <th style="text-align:center"><b>Cluster No</b></th> 
                  <th style="text-align:center"><b>Tehsil</b></th> 
                  <th style="text-align:center"><b>Area</b></th> 
                  <th style="text-align:center"><b>Households Randomized</b></th> 
                  <th style="text-align:center"><b>Households Visited</b></th> 
                  <th style="text-align:center"><b>Completed</b></th> 
                  <th style="text-align:center"><b>Refused</b></th> 
                  <th style="text-align:center"><b>Households with No Elig Child</b></th> 
                  <th style="text-align:center"><b>Others</b></th> 
                  <th style="text-align:center"><b>HH with atleast 1 child</b></th>  
                  <th style="text-align:center"><b>Status</b></th>  
                 </tr>';
        foreach ($dc_data as $dc_k => $dc_row) {
            if ($dc_row->randomized_households > 0) {
                if ($dc_row->one_child == 0) {
                    $dc_status = 'Pending';
                } else if ($dc_row->one_child > 0 and $dc_row->one_child < 13) {
                    $dc_status = 'In Progress';
                } else {
                    $dc_status = 'Completed';
                }
            } else {
                $dc_status = 'Not Randomized';
            }
            $dc_geoareas = explode('|', $dc_row->geoarea);

            $dc_tbl .= '<tr  border="0">
<td  border="0" style="text-align:center">' . $dc_row->hh02 . '</td>  
<td   style="text-align:center">' . $dc_geoareas[2] . '</td>  
<td   style="text-align:center">' . $dc_geoareas[3] . '</td>  
<td   style="text-align:center">' . $dc_row->randomized_households . '</td>  
<td   style="text-align:center">' . $dc_row->collected_forms . '</td>  
<td   style="text-align:center">' . $dc_row->completed_forms . '</td>  
<td   style="text-align:center">' . $dc_row->refused_forms . '</td>  
<td   style="text-align:center">' . $dc_row->not_elig . '</td>  
<td   style="text-align:center">' . $dc_row->remaining_forms . '</td>  
<td   style="text-align:center">' . (isset($dc_row->one_child) && $dc_row->one_child != '' ? $dc_row->one_child : 0) . '</td>   
<td   style="text-align:center">' . $dc_status . '</td>   
</tr>';
        }
        $dc_tbl .= '</table>';
        $dc_pdf->writeHTML($dc_tbl, true, false, true, false, '');
        $dc_pdff = $dc_pdf->Output('dc.pdf', 'S');
        /*====================== Data Collection End ======================*/

        /*====================== Email ======================*/
        $sendMessage = '<html>
                    <body bgcolor="#EDEDEE">
                    <p><strong>Dear Khalid Feroz,</strong></p>
                    <p>Please check the daily progress report of line listing and data collection activity.</p>
                    <p style=\'  background-color: yellow; font-weight: 600;\'>Note: This is an automated message.</p> <br><br>
                    <p>Thank you</p> 
                    <p>Regards,</p>
                    <p>TPVICS</p>
                  </body>
                  </html>';

        /* $this->load->library('phpmailer_lib');
         $mail = $this->phpmailer_lib->load();
         $mail->AddAddress("khalid.feroz@aku.edu");
         $mail->IsMail();
         $mail->AddStringAttachment($pdff, 'linelisting' . $todaydate . '.pdf');
         $mail->AddStringAttachment($dc_pdff, 'data_collection' . $todaydate . '.pdf');
         $mail->From = 'sk_khan911@hotmail.com';
         $mail->FromName = 'TPVICS';
         $mail->IsHTML(true);
         $mail->Subject = "TPVICS - Daily Progress Report";
         $mail->Body = $sendMessage;
         $mail->Send();
         $mail->ClearAddresses();
         if ($mail) {
             echo 1;
         } else {
             echo 2;
         }*/
    }
}

?>