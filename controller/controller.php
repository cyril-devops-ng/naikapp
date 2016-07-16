<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/* import libraries */
require_once "model/Model.mod.php";
require_once "model/Model.math.php";
require_once "includes/safemysql.class.php";
require_once 'libraries/Excel/reader.php';


$post = $_POST;
$get = $_GET;
$db = new MysqliDb($db_host, $db_user, $db_pass, $db_name);

class Controller {

    private $current_page = '';
    private $db;
    private $model;
    private $mySession;

    /* constructor */

    public function __construct($db, $post, $get) {
        $this->db = $db;
        $this->model = new Model($this->db);
//        if ($_SESSION['logged_in']){
        $page = $_GET['view'];

        //set the time zone
        date_default_timezone_set("Africa/Lagos");


//            print '<pre>';print_r($_SESSION);print'</PRE>';
        if (!$_GET['view'] && $_SESSION['logged_in']) {
            $this->current_page = 'view/home.php';
        } elseif (!$_GET['view'] && $_SESSION['logged_in_salesmanager']) {
            $this->current_page = 'view/salesmanagerhome.php';
        } elseif (!$_GET['view'] && $_SESSION['logged_in_factoryuser']) {
            $this->current_page = 'view/factoryuserhome.php';
        } elseif (!$_GET['view'] && $_SESSION['logged_in_itmanager']) {
            $this->current_page = 'view/factoryuserhome.php';
        } elseif (!$_SESSION['logged_in'] && !$_SESSION['logged_in_salesmanager'] && !$_SESSION['logged_in_receptionist'] && !$_SESSION['logged_in_itmanager'] && !$_SESSION['logged_in_factoryuser']) {

            $this->current_page = 'view/login.php';
        } else {

            //check the directory for the requested file
            $request_file = false;
            if ($handle = opendir('view')) {
                while (false !== ($file = readdir($handle))) {
                    if (($file != ".") && ($file != "..")) {
                        if ($file == $page . '.php'):
                            $request_file = true;
                        endif;
                    }
                }
                closedir($handle);
            }
            if (!$request_file) {
                session_destroy();
            }
            if ($request_file && $page == 'login') {

                if (isset($_SESSION['logged_in']))
                    $this->current_page = 'view/home.php';

                elseif (isset($_SESSION['logged_in_salesmanager']))
                    $this->current_page = 'view/salesmanagerhome.php';

                elseif (isset($_SESSION['logged_in_receptionist']))
                    $this->current_page = 'view/receptionisthome.php';

                elseif (isset($_SESSION['logged_in_factoryuser']))
                    $this->current_page = 'view/factoryuserhome.php';
                elseif (isset($_SESSION['logged_in_itmanager']))
                    $this->current_page = 'view/itmanagerhome.php';
            } else if ($request_file && $page == 'register') {
                $this->current_page = 'view/home.php';
            } else {
                $this->current_page = $request_file ? 'view/' . $page . '.php' : 'view/pageserror.php';
            }
        }

//        }else{
//            $this->current_page = 'view/home.php';
//        }

        $this->handleFormActions();



        require_once $this->current_page;

        if ($this->db) {
            $close = $this->model->close();
        }
    }

    function startsWith($haystack, $needle) {
        // search backwards starting from haystack length characters from the end
        return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
    }

    /* endswith string function */

    function endsWith($haystack, $needle) {
        // search forward starting from end minus needle length characters
        return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
    }

    public function handleFormActions() {


        if ($_GET['view'] == 'logout') {
            $lgt = $this->model->map_request(
                    'insert', 'logon_sessions', array(
                'username' => $_SESSION['user']['username'],
                'system' => gethostbyaddr($_SERVER['REMOTE_ADDR']),
                'date' => date("Y-m-d H:i:s"),
                'session_id' => session_id(),
                'action' => 'logout'
                    )
            );
            session_destroy();
            $this->current_page = 'view/login.php';
        }

        if ($_GET['view'] == 'receipt') {
            $salesdoc = $_SESSION['salesdocno'];
            $sales = $this->model->map_request('retrieve', 'sales_doc', $_POST, 'sales_doc_no', $salesdoc);
            $_SESSION['salesDoc'] = $sales;
        }

        if ($_GET['view'] == 'saleslist') {
            $sales = $this->model->map_request('retrieve', 'sales_doc', $_POST, 'sales_area', $_SESSION['user']['sales_area']);
            $_SESSION['receptionist_sales'] = $sales;
        }

        if ($_GET['view'] == 'login') {
            if ($_POST['username']) {
                $username = $_POST['username'];
                $password = $_POST['password'];

                //$usertype = $_POST['userType'];
                if ($username == 'admin') {
                    //forte staff
                    $res1 = $this->model->map_request_mulwhere('retrieve', 'users', $_POST, array('username', 'password'), array($_POST['username'], $_POST['password']));
                    if (!empty($res1)) {
                        $this->mySession = session_id();
                        $logonsession = $this->model->map_request(
                                'insert', 'logon_sessions', array(
                            'username' => $_POST['username'],
                            'system' => gethostbyaddr($_SERVER['REMOTE_ADDR']),
                            'date' => date("Y-m-d H:i:s"),
                            'session_id' => $this->mySession,
                            'action' => 'login'
                                )
                        );
//                        $_SESSION['user'] = array(
//                            'username' => 'admin',
//                            'password' => '*****',
//                            'fullname' => 'Managing Director'
//                        );

                        $_SESSION['user'] = $res1[0];
                        unset($_SESSION['login_failed']);
                        $_SESSION['logged_in'] = 'true';
                        $this->current_page = 'view/home.php';
                    } else {
                        $_SESSION['login_failed'] = true;
                        $this->current_page = 'view/login.php';
                    }
                } else {
                    $res = $this->model->map_request_mulwhere('retrieve', 'users', $_POST, array('username', 'password'), array($_POST['username'], $_POST['password']));
                    if (!empty($res)) {
                        $this->mySession = session_id();
                        $logonsession = $this->model->map_request(
                                'insert', 'logon_sessions', array(
                            'username' => $_POST['username'],
                            'system' => gethostbyaddr($_SERVER['REMOTE_ADDR']),
                            'date' => date("Y-m-d H:i:s"),
                            'session_id' => $this->mySession,
                            'action' => 'login'
                                )
                        );
                        unset($_SESSION['login_failed']);
                        $_SESSION['user'] = $res[0];
//                        print '<pre>'; print_r($_SESSION['user']); print '</pre>';
//                        exit();
                        if ($_SESSION['user']['usertype'] == 'Sales Manager') {
                            $_SESSION['logged_in_salesmanager'] = 'true';
                            $this->current_page = 'view/salesmanagerhome.php';
                        } else if ($_SESSION['user']['usertype'] == 'IT Manager') {
                            $_SESSION['logged_in_itmanager'] = 'true';
                            $this->current_page = 'view/itmanagerhome.php';
                        } elseif ($_SESSION['user']['usertype'] == 'Receptionist') {
                            //                    echo 'afgaf'; exit();
                            $_SESSION['logged_in_receptionist'] = 'true';
                            $this->current_page = 'view/receptionisthome.php';
                        } elseif ($_SESSION['user']['usertype'] == 'Factory User') {
                            $_SESSION['logged_in_factoryuser'] = 'true';
                            $this->current_page = 'view/factoryuserhome.php';

                            $approved = $this->model->map_request('retrieve', 'stock_request', $_POST, 'status', 'Approved');
                            $_SESSION['approved'] = $approved;
                        } else {
                            $_SESSION['logged_in'] = 'true';
                            $this->current_page = 'view/home.php';
                        }
                    } else {
                        $_SESSION['login_failed'] = true;
                        $this->current_page = 'view/login.php';
                    }
                }
            }
        }

        if ($_GET['view'] == 'createrm') {
            if ($_POST['stock']) {
                $_check = $this->model->map_request_mulwhere('retrieve', 'stocks_rm', $_POST, array('stock_name', 'sales_area')
                        , array($_POST['stock'], 'Factory ' . $_SESSION['user']['sales_area']));

                if (!empty($_check)) {
                    //update
                    $newqty = $_check[0]['quantity'] + $_POST['quantity']; //change and update
//                    $newqty = $_POST['quantity'];
                    $data = array(
                        'quantity' => $newqty,
                        'cost_price' => str_replace(',', '', $_POST['costprice']),
//                        'selling_price'=>$_POST['sellprice'],
                        'upload_date' => $_POST['upload_date']
                    );
                    $r = $this->model->map_request_mulwhere('update', 'stocks_rm', $data, array('stock_name', 'sales_area'), array($_POST['stock'], 'Factory ' . $_SESSION['user']['sales_area']));

//                    $date = date('d-m-Y H:i:s');
                    $date = $_POST['upload_date'];

                    $data_m = array(
                        'stock_name' => $_POST['stock'],
                        'quantity' => $_POST['quantity'],
                        'movement_type' => 'IN',
                        'movement_date' => $date,
                        'sales_area' => 'Factory ' . $_SESSION['user']['sales_area']
                    );
                    if ($_POST['stocktype'] == 'Raw Materials') {
                        $this->model->map_request('insert', 'rm_tracker', $data_m);
                    }

                    if ($r) {
                        $this->current_page = $_GET['view'] == 'creatrm' ? 'view/stockrmsuccess.php' : 'view/stockrmsuccess.php';
                    } else {
                        $this->current_page = 'view/stockrmfailure.php';
                    }
                } else {

                    $data = array(
                        'stock_name' => $_POST['stock'],
                        'stock_type' => $_POST['stocktype'],
                        'quantity' => $_POST['quantity'],
                        'cost_price' => str_replace(',', '', $_POST['costprice']),
//                        'selling_price' => str_replace( ',', '', $_POST['sellprice'] ),
//                        'upload_date' => date("Y-m-d H:i:s"),
                        'upload_date' => $_POST['upload_date'],
                        'sales_area' => 'Factory ' . $_SESSION['user']['sales_area']
                    );

                    $res = $this->model->map_request('insert', 'stocks_rm', $data);
//                    $date = date('Y-m-d H:i:s');
                    $date = $_POST['upload_date'];
                    $data_m = array(
                        'stock_name' => $_POST['stock'],
                        'quantity' => $_POST['quantity'],
                        'movement_type' => 'IN',
                        'movement_date' => $date,
                        'sales_area' => 'Factory ' . $_SESSION['user']['sales_area']
                    );

                    $insert = $this->model->map_request('insert', 'rm_tracker', $data_m);

                    if ($res) {
                        $this->current_page = $_GET['view'] == 'createrm' ? 'view/stockrmsuccess.php' : 'view/stockrmsuccess.php';
                    } else {
                        $this->current_page = 'view/stockrmfailure.php';
                    }
                }
            }
        }

        if ($_GET['view'] == 'usermanagement') {
            if ($_POST['fullname']) {
                //check if the user exist

                $fullname = $_POST['fullname'];
                $username = $_POST['username'];
                $password = $_POST['password'];
                $email = $_POST['email'];
                $phoneno = $_POST['phoneno'];
                $usertype = $_POST['usertype'];
                $salesarea = $_POST['salesarea'];
                $pay = $_POST['amount'];

                $data = array(
                    'username' => $username,
                    'fullname' => $fullname,
                    'password' => $password,
                    'email' => $email,
                    'phoneno' => $phoneno,
                    'usertype' => $usertype,
                    'sales_area' => $salesarea,
                    'pay' => $pay
                );

                $data2 = array(
                    'fullname' => $fullname,
                    'password' => $password,
                    'email' => $email,
                    'phoneno' => $phoneno,
                    'usertype' => $usertype,
                    'sales_area' => $salesarea,
                    'pay' => $pay
                );

                $res_check = $this->model->map_request('retrieve', 'users', $_POST, 'username', $username);

                if (empty($res_check)) {
                    $res = $this->model->map_request('insert', 'users', $data);
                    if ($res) {
                        $this->current_page = 'view/usercreatesuccess.php';
                    } else {
                        $this->current_page = 'view/usercreatefail.php';
                    }
                } else {

                    $res = $this->model->map_request('update', 'users', $data2, 'username', $username);
                    $this->current_page = 'view/userupdatesuccess.php';
                }
            }
        }

        if ($_GET['view'] == 'grossprofit') {
//            $allcashsales = $this->model->map_request('retrieve','sales_doc',$_POST
//                    ,'trans_type','CASH');
            $this->model->set_query('select sales_id,quantity,sales_date,trans_type,month,year,sum(total_price) as total_price from sales_doc where trans_type=? group by month,year');
            $allcashsales = $this->model->map_request('raw_query', '', '', '', '', array("Cash"));

            $allremittedsales = $this->model->map_request('retrieve', 'cash_returns', $_POST);

            $allexp = $this->model->map_request('retrieve', 'expenses', $_POST);
            $_SESSION['allexp'] = $allexp;
            $_SESSION['allcashsales'] = $allcashsales;
            $_SESSION['allremittedsales'] = $allremittedsales;
        }
        if ($_GET['view'] == 'addexpense') {
            if ($_POST['description']) {
                $description = $_POST['description'];
                if ($description == '--Others--') {
                    $description = $_POST['expense'];
                }
                $amount = str_replace(',', '', $_POST['amount']);
                $date = $_POST['date'];
                $expenseid = $_POST['expense_id'];

                $check = $this->model->map_request('retrieve', 'expenses', $_POST, 'id', $expenseid);
                if (empty($check)) {
                    $data = array(
                        'description' => $description,
                        'expense_amount' => $amount,
                        'date' => $date,
                        'sales_area' => $_POST['salesarea']
                    );

                    $result = $this->model->map_request('insert', 'expenses', $data);
                    if ($result) {
                        $this->current_page = 'view/expensesuccess.php';
                    }
                } else {
                    $data = array(
                        'description' => $description,
                        'expense_amount' => $amount,
                        'date' => $date,
                        'sales_area' => $_POST['salesarea']
                    );

                    $result = $this->model->map_request('update', 'expenses', $data, 'id', $_POST['expense_id']);
                    if ($result) {
                        $this->current_page = 'view/expenseupdate.php';
                    }
                }
            }
        }
        if ($_GET['view'] == 'addexpenseit') {
            if ($_POST['description']) {
                $description = $_POST['description'];
                if ($description == '--Others--') {
                    $description = $_POST['expense'];
                }
                $amount = str_replace(',', '', $_POST['amount']);
                $date = $_POST['date'];
                $expenseid = $_POST['expense_id'];

                $check = $this->model->map_request('retrieve', 'expenses', $_POST, 'id', $expenseid);
                if (empty($check)) {
                    $data = array(
                        'description' => $description,
                        'expense_amount' => $amount,
                        'date' => $date,
                        'sales_area' => $_SESSION['user']['sales_area']
                    );

                    $result = $this->model->map_request('insert', 'expenses', $data);
                    if ($result) {
                        $this->current_page = 'view/expensesuccessit.php';
                    }
                } else {
                    $data = array(
                        'description' => $description,
                        'expense_amount' => $amount,
                        'date' => $date,
                        'sales_area' => $_POST['salesarea']
                    );

                    $result = $this->model->map_request('update', 'expenses', $data, 'id', $_POST['expense_id']);
                    if ($result) {
                        $this->current_page = 'view/expenseupdateit.php';
                    }
                }
            }
        }
        if ($_GET['view'] == 'rawmaterial') {
            $rm = $this->model->map_request_mulwhere('retrieve', 'stocks_rm', $_POST, array('stock_type', 'sales_area'), array('Raw Materials', 'Factory ' . $_SESSION['user']['sales_area']));

            $_SESSION['rm'] = $rm;

            if ($_POST['check']) {
                $stockt = $_POST['stock'];
                $r = $this->model->map_request_mulwhere('retrieve', 'stocks_rm', $_POST, array('stock_name', 'sales_area'), array($stockt, 'Factory ' . $_SESSION['user']['sales_area']));

                echo json_encode($r[0]['quantity']);
                exit();
            }
            if ($_POST['stock_name']) {
                $stockname = $_POST['stock_name'];
                $quantity = $_POST['quantity'];
                $date = date("Y-m-d");

                $data = array(
                    'stock_name' => $stockname,
                    'quantity' => $quantity,
                    'movement_type' => 'OUT',
                    'movement_date' => $date,
                    'sales_area' => 'Factory ' . $_SESSION['user']['sales_area']
                );

                $res = $this->model->map_request('insert', 'rm_tracker', $data);
                if ($res) {
                    //deduct from raw material inventory
                    $chk = $this->model->map_request_mulwhere('retrieve', 'stocks_rm', $_POST, array('stock_name', 'sales_area'), array($stockname, 'Factory ' . $_SESSION['user']['sales_area']));
                    $qty = $chk[0]['quantity'];
                    $newq = $qty - $quantity;
                    $udata = array(
                        'quantity' => $newq
                    );
                    $this->model->map_request_mulwhere('update', 'stocks_rm', $udata, array('stock_name', 'sales_area'), array($stockname, 'Factory ' . $_SESSION['user']['sales_area']));
                    $this->current_page = 'view/rawmaterialsuccess.php';
                } else {
                    
                }
            }
        }

        if ($_GET['view'] == 'pricing') {
            if ($_POST['stock']) {
                $data = array(
                    'stock_name' => $_POST['stock'],
                    'stock_type' => $_POST['stocktype'],
                    'cost_price' => str_replace(',', '', $_POST['costprice']),
                    'selling_price' => str_replace(',', '', $_POST['sellprice']),
                    'year' => $_POST['year'],
                    'month' => $_POST['month']
                );

                $p = $this->model->map_request('insert', 'prices', $data);
                if ($p) {
                    $this->current_page = 'view/pricesuccess.php';
                }
            }
        }

        if ($_GET['view'] == 'pricelist') {
            $prices = $this->model->map_request('retrieve', 'prices', $_POST);
            $_SESSION['prices'] = $prices;

            if ($_POST['pleasedelete']) {
                $id = $_POST['id'];
                $this->model->map_request('delete', 'prices', $_POST, 'id', $id);
                return json_encode('success');
                exit();
            }
        }
        if ($_GET['view'] == 'rawmaterialreport') {
            $rm = $this->model->map_request('retrieve', 'rm_tracker', $_POST);
            $_SESSION['raw_materials'] = $rm;

            $rmm = $this->model->map_request('retrieve', 'stocks_rm', $_POST);
            $_SESSION['rm_value'] = $rmm;
        }
        if ($_GET['view'] == 'myrmconsumption') {
            $rm = $this->model->map_request('retrieve', 'rm_tracker', $_POST, 'sales_area', 'Factory ' . $_SESSION['user']['sales_area']);
            $_SESSION['myraw_materials'] = $rm;

            $rmm = $this->model->map_request('retrieve', 'stocks_rm', $_POST);
            $_SESSION['rm_value'] = $rmm;
        }
        if ($_GET['view'] == 'viewexpense') {
            $expenses = $this->model->map_request('retrieve', 'expenses', $_POST);
            $_SESSION['expenses_in'] = $expenses;

            if ($_POST['month']) {
                if (strlen($_POST['month']) == 1) {
                    $_POST['month'] = '0' . $_POST['month'];
                }
                $_SESSION['month_expense'] = $_POST['month'];
                $_SESSION['expenses_in'] = array();
                $expenses = $this->model->map_request('retrieve', 'expenses', $_POST);
                foreach ($expenses as $e => $v) {
                    if (strpos($v['date'], $_POST['year'] . '-' . $_POST['month']) !== false) {
                        array_push($_SESSION['expenses_in'], $v);
                    }
                }
            }

            if ($_POST['edit']) {
                $_SESSION['edit_expense'] = $_POST['id'];
                $_SESSION['editexp'] = true;
            }
            if ($_POST['delete']) {
                $id = $_POST['id'];
                $delete = $this->model->map_request('delete', 'expenses', $_POST, 'id', $id);
//                $this->current_page = 'view/expensedelete.php';
            }
        }
        if ($_GET['view'] == 'viewexpenseit') {
            $expenses = $this->model->map_request('retrieve', 'expenses', $_POST, 'sales_area', $_SESSION['user']['sales_area']);
            $_SESSION['expenses_in'] = $expenses;


            if ($_POST['month']) {
                if (strlen($_POST['month']) == 1) {
                    $_POST['month'] = '0' . $_POST['month'];
                }
                $_SESSION['month_expense'] = $_POST['month'];
                $_SESSION['expenses_in'] = array();
                $expenses = $this->model->map_request('retrieve', 'expenses', $_POST);
                foreach ($expenses as $e => $v) {
                    if (strpos($v['date'], $_POST['year'] . '-' . $_POST['month']) !== false) {
                        array_push($_SESSION['expenses_in'], $v);
                    }
                }
            }

            if ($_POST['edit']) {
                $_SESSION['edit_expense'] = $_POST['id'];
                $_SESSION['editexp'] = true;
            }
            if ($_POST['delete']) {
                $id = $_POST['id'];
                $delete = $this->model->map_request('delete', 'expenses', $_POST, 'id', $id);
//                $this->current_page = 'view/expensedelete.php';
            }
        }

        if ($_GET['view'] == 'requeststatus') {
            $request = $this->model->map_request('retrieve', 'stock_request', $_POST);
            $_SESSION['factoryrequest'] = $request;
            if (isset($_POST['_fetch'])) {
                $requestno = $_POST['_req'];
                foreach ($_SESSION['factoryrequest'] as $_kk => $_vv) {
                    if ($_vv['request_no'] == $requestno) {
                        echo json_encode($_vv);
                        exit();
                    }
                }
            }
        }

        if ($_GET['view'] == 'creditreturns') {
            $prev = $this->model->map_request('retrieve', 'cash_returns', $_POST, 'sales_id', $_SESSION['salesdocument'][0]['sales_doc_no']);
            $_SESSION['previous_balance'] = $prev;
            $pre = $this->model->map_request('retrieve', 'cash_returns', $_POST, 'sales_area', $_SESSION['user']['sales_area']);
            $_SESSION['previous'] = $pre;
            $customers = $this->model->map_request('retrieve', 'customers', $_POST, 'sales_area', $_SESSION['user']['sales_area']);
            $_SESSION['s_customers'] = $customers;
            $credits = $this->model->map_request_mulwhere('retrieve', 'sales_doc', $_POST, array('sales_area', 'trans_type'), array($_SESSION['user']['sales_area'], 'Credit'));

            $_SESSION['credits'] = $credits;

            $creditreturns = $this->model->map_request('retrieve', 'cash_returns', $_POST, 'sales_area', $_SESSION['user']['sales_area']);

            $_SESSION['creditreturns'] = $creditreturns;


            if ($_POST['sales_doc']) {
                $salesdoc = $_POST['sales_doc'];
                $salesdocument = $this->model->map_request('retrieve', 'sales_doc', $_POST, 'sales_doc_no', $salesdoc);
                $_SESSION['salesdocument'] = $salesdocument;
                echo json_encode('success');
                exit();
            }

            $thisSales = array();
            if ($_POST['returns']) {
                //$_SESSION['user']['sales_area']
                $salesd = $this->model->map_request('retrieve', 'sales_doc', $_POST, 'sales_area', $_SESSION['user']['sales_area']);
                $creditreturns = $this->model->map_request('retrieve', 'cash_returns', $_POST, 'sales_area', $_SESSION['user']['sales_area']);
                $salesdoc = $_POST['s_doc'];
//                echo json_encode($salesd); exit();
                foreach ($creditreturns as $k => $v) {

                    if ($v['sales_id'] == $salesdoc) {
                        foreach ($salesd as $s => $t) {
                            if ($v['sales_id'] == $t['sales_doc_no'] && $v['stock_name'] == $t['stock_name']) {
                                $v['shipped'] = $t['quantity'];
                            }
                        }
                        array_push($thisSales, $v);
                    }
                }
                $_SESSION['credit_sales_return'] = $thisSales;
                echo json_encode($thisSales);
                exit();
            }
        }

        if ($_GET['view'] == 'stockpositionmanager') {
            $stockraw = $this->model->map_request('retrieve', 'stocks', $_POST, 'sales_area', $_SESSION['user']['sales_area']);
            $_SESSION['stockpos'] = $stockraw;
        }

        if ($_GET['view'] == 'creditremit') {
            $prev = $this->model->map_request('retrieve', 'cash_returns', $_POST, 'sales_area', $_SESSION['user']['sales_area']);
            $_SESSION['previous_balance'] = $prev;
            if ($_POST['save']) {
                $salesdocument = $_SESSION['salesdocument'];
                if (strpos($_POST['row'], ',') !== false) {
                    $lines = explode(',', $_POST['row']);
                    $prev = explode(',', $_POST['prev']);
                    for ($i = 0; $i < count($lines); $i++) {
                        $aLine = explode(':', $lines[$i]);
                        $aPrev = explode(':', $prev[$i]);
                        $data = array(
                            'stock_name' => $aLine[0],
                            'sales_id' => $salesdocument[$i]['sales_doc_no'],
                            'cust_id' => $salesdocument[$i]['cust_id'],
                            'quantity' => $aLine[1],
                            'amount' => floatval($salesdocument[$i]['unit_price']),
                            'sales_area' => $salesdocument[$i]['sales_area'],
                            'remit_date' => $_POST['documentdate'],
                            'remit_date' => date('Y-m-d H:i:s'),
                            'current_balance' => $aPrev[1]
                        );

                        $result = $this->model->map_request('insert', 'cash_returns', $data);
                    }
                } else {
                    $aLine = explode(':', $_POST['row']);
                    $aPrev = explode(':', $_POST['prev']);
                    $data = array(
                        'stock_name' => $aLine[0],
                        'sales_id' => $salesdocument[0]['sales_doc_no'],
                        'cust_id' => $salesdocument[0]['cust_id'],
                        'quantity' => $aLine[1],
                        'amount' => floatval($salesdocument[0]['unit_price']),
                        'sales_area' => $salesdocument[0]['sales_area'],
//                            'remit_date'=>date('Y-m-d H:i:s'),
                        'remit_date' => $_POST['documentdate'],
                        'current_balance' => $aPrev[1]
                    );

                    $result = $this->model->map_request('insert', 'cash_returns', $data);
                }
                echo json_encode('success');
                exit();
//                echo json_encode($data);exit();
            }
        }
        if ($_GET['view'] == 'salesmanagerhome') {
            $customers = $this->model->map_request('retrieve', 'customers', $_POST, 'sales_area', $_SESSION['user']['sales_area']);
            $_SESSION['s_customers'] = $customers;
        }
        if ($_GET['view'] == 'processrequest') {
            $request = $this->model->map_request('retrieve', 'stock_request', $_POST, 'status', 'Approved');
            $_SESSION['approved_request'] = $request;

            if ($_POST['request']) {
                $selected_request = $_POST['request'];
                foreach ($request as $k => $v) {
                    if ($selected_request == $v['request_no']) {
                        //remove the stock from factory stock.
                        $current = $this->model->map_request_mulwhere('retrieve', 'stocks', $_POST, array('stock_name', 'sales_area')
                                , array($v['stock_name'], 'Factory ' . $_SESSION['user']['sales_area']));
                        $oldqty = $current[0]['quantity'];
                        $newqty = $oldqty - $v['quantity'];

                        $u = $this->model->map_request_mulwhere('update', 'stocks', array('quantity' => $newqty), array('stock_name', 'sales_area'), array($v['stock_name'], 'Factory ' . $_SESSION['user']['sales_area']));
                        if ($u) {

                            $u2 = $this->model->map_request('update', 'stock_request', array('status' => 'In Transit'), 'request_no', $selected_request);
                            if ($u2) {
                                echo json_encode('success');
                                exit();
                            }
                        }
                    }
                }
            }
        }

        if ($_GET['view'] == 'myrequestlist' || $_GET['view'] == 'pendingrequest' || $_GET['view'] == 'approvedrequest' || $_GET['view'] == 'intransitrequest' || $_GET['view'] == 'completedrequest') {
            $request = $this->model->map_request('retrieve', 'stock_request', $_POST);
            $_SESSION['requestlist'] = $request;
            if ($_POST['details']) {
                $requestno = $_POST['salesid'];
                foreach ($_SESSION['requestlist'] as $k => $v) {
                    if ($v['request_no'] == $requestno) {
                        echo json_encode($v);
                        exit();
                    }
                }
            }

            if (isset($_POST['requestno'])) {
                $requestno = $_POST['requestno'];
                $action = $_POST['action'];
                $comments = $_POST['comments'];
                if ($action == 'approve') {
                    $update = $this->model->map_request('update', 'stock_request', array('status' => 'Approved'), 'request_no', $requestno);
                } else {
                    $update = $this->model->map_request('update', 'stock_request', array('status' => 'Rejected', 'comments' => $comments), 'request_no', $requestno);
                }
                if ($update) {
                    echo json_encode('success');
                } else {
                    echo json_encode($update);
                }
                exit();
            }
        }

        if ($_GET['view'] == 'rejectrequest') {
            if ($_POST['details']) {
                $requestno = $_POST['salesid'];
                foreach ($_SESSION['requestlist'] as $k => $v) {
                    if ($v['request_no'] == $requestno) {
                        echo json_encode($v);
                        exit();
                    }
                }
            }
        }

        if ($_GET['view'] == 'userslist') {
            $res = $this->model->map_request('retrieve', 'users', $_POST);
            $_SESSION['userslist'] = $res;

            if ($_POST['delete']) {
                $username = $_POST['id'];
                $res = $this->model->map_request('delete', 'users', $_POST, 'username', $username);
                if ($res) {
                    echo json_encode('success');
                } else {
                    echo json_encode('failure');
                }
                exit();
            }

            if ($_POST['edit']) {
                $username = $_POST['id'];
                $res = $this->model->map_request('retrieve', 'users', $_POST, 'username', $username);
                $_SESSION['employee'] = $res[0];
            }
        }

        if ($_GET['view'] == 'changepassword') {
            if ($_POST['oldpass']) {
                $oldpass = $_POST['oldpass'];
                $newpass = $_POST['newpass'];
                $confpass = $_POST['confpass'];

                $this->model->map_request('update', 'users', array('password' => $newpass), 'username', $_SESSION['user']['username']);
                $this->current_page = 'view/passwordsuccess.php';
            }
        }

        if ($_GET['view'] == 'uploadstock') {
            if ($_POST['uploadFile']) {

                $companyProfile = 'Factory_' . date('Y-m-d') . '_';
                $target_dir = "uploads/";
                $target_file = $target_dir . $companyProfile . basename($_FILES["stockName"]["name"]);
                $uploadOk = 1;
                $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

                $f_name = $_FILES["stockName"]["name"];
//                    $check = getimagesize($_FILES["stockName"]["tmp_name"]);
                $errors = array();
                if ($this->endsWith($f_name, '.xls') || $this->endsWith($f_name, '.xlsx')) {
                    $uploadOk = 1;
                } else {
                    $uploadOk = 0;
                    array_push($errors, 2);
                }


                if (file_exists($target_file)) {
//                        echo "Sorry, file already exists.";
//                        $uploadOk = 0;
                    array_push($errors, 3);
                }

                if ($_FILES["stockName"]["size"] > 500000) {
//                        echo "Sorry, your file is too large.";
                    $uploadOk = 0;
                    $_SESSION['massuploaded'] = 3;
                    array_push($errors, 4);
                }
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
//                        echo "Sorry, your file was not uploaded.";
                    // if everything is ok, try to upload file
                } else {

                    if (move_uploaded_file($_FILES["stockName"]["tmp_name"], $target_file)) {
//                            echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";

                        if ($this->uploadFileToStockTable($target_file)) {
                            array_push($errors, 1);

                            $this->current_page = 'view/uploadsuccess.php';
                        } else {
                            array_push($errors, 6);
                        }
                    } else {
//                            echo "Sorry, there was an error uploading your file.";
                        array_push($errors, 5);
                    }
                }
                $_SESSION['massuploaded'] = $errors;
//                    print'<pre>';print_r($_SESSION['massuploaded']);print'</pre>';
            }
        }
        if ($_GET['view'] == 'transferstock') {
            $stocklist = $this->model->map_request('retrieve', 'stocks', $_POST, 'sales_area', 'Factory ' . $_SESSION['user']['sales_area']);
            $_SESSION['transferstock'] = $stocklist;


            if ($_POST['stockname']) {
//                print'<pre>';print_r($_POST);print'</pre>';
                $stockname = $_POST['stockname'];
                $qty = $_POST['quantity'];
                $salesarea = $_POST['salesarea'];



                foreach ($stocklist as $k => $_v) {
                    if ($_v['stock_name'] === $stockname) {
                        //check if stock exist in sales area
                        $r_check = $this->model->map_request_mulwhere('retrieve', 'stocks', $_POST, array('stock_name', 'sales_area'), array($stockname, $salesarea));
                        $newqty = $_v['quantity'] - $qty;
                        if ($newqty >= 0) {
                            if (empty($r_check)) {
                                //_record
                                $data = array(
                                    'stock_name' => $stockname,
                                    'stock_type' => $_v['stock_type'],
                                    'quantity' => $qty,
                                    'cost_price' => $_v['cost_price'],
                                    'selling_price' => $_v['selling_price'],
//                                    'upload_date' => date('Y-m-d H:i:s'),
                                    'upload_date' => $_POST['date'],
                                    'sales_area' => $salesarea
                                );
//                                $i = $this->model->map_request('insert', 'stocks', $data);
                                //create a request for it
                                $request_data = array(
                                    'request_no' => $this->generateRequestCode(),
                                    'stock_name' => $stockname,
                                    'quantity' => $qty,
                                    'sales_area' => $salesarea,
                                    'requester' => $_SESSION['user']['sales_area'],
//                                    'request_date'=>date('Y-m-d H:i:s'),
                                    'request_date' => $_POST['date'],
                                    'status' => 'In Transit'
                                );
                                $i = $this->model->map_request('insert', 'stock_request', $request_data);
                                $_u = $this->model->map_request_mulwhere('update', 'stocks', array('quantity' => $newqty), array('stock_name', 'sales_area')
                                        , array($stockname, 'Factory ' . $_SESSION['user']['sales_area']));
//                                print_r($_u);exit();
                                if ($i > 0 & $_u > 0) {
                                    $this->current_page = 'view/transfersuccess.php';
                                } else {
                                    $this->current_page = 'view/transferfailed.php';
                                }
                            } else {
                                $n_qty = $r_check[0]['quantity'] + $qty;
                                //_update
                                $_u1 = $this->model->map_request_mulwhere('update', 'stocks', array('quantity' => $newqty), array('stock_name', 'sales_area')
                                        , array($stockname, 'Factory ' . $_SESSION['user']['sales_area']));
//                                $_u2 = $this->model->map_request_mulwhere('update', 'stocks', array('quantity' => $n_qty), array('stock_name', 'sales_area')
//                                        , array($stockname, $salesarea));

                                $request_data = array(
                                    'request_no' => $this->generateRequestCode(),
                                    'stock_name' => $stockname,
                                    'quantity' => $qty,
                                    'sales_area' => $salesarea,
                                    'requester' => $_SESSION['user']['sales_area'],
                                    'request_date' => date('Y-m-d H:i:s'),
                                    'status' => 'In Transit'
                                );
                                $_u2 = $this->model->map_request('insert', 'stock_request', $request_data);


                                if ($_u1 > 0 && $_u2 > 0) {
                                    $this->current_page = 'view/transfersuccess.php';
                                } else {
                                    $this->current_page = 'view/transferfailed.php';
                                }
                            }
                        } else {
                            $this->current_page = 'view/transferunavailable.php';
                        }
                    }
                }
            }
        }

        if ($_GET['view'] == 'producedadmin') {
            $stockraw = $this->model->map_request('retrieve', 'stocks', $_POST);
            $_SESSION['producedadmin'] = $stockraw;
            foreach ($_SESSION['producedadmin'] as $k => $v) {
                $month = 'January,February,March,April,May,June,July,August,September,October,November,December';
                $m = explode(',', $month);
                $y = explode('-', $v['upload_date'])[0];
                $_m = explode('-', $v['upload_date'])[1];
                $_m = intval($_m);
                $_m -= 1;

//                echo  $v['upload_date'];
                $this->model->set_query('select * from prices where stock_name= ? and month = ? and year = ? order by year DESC, month DESC LIMIT 1');
                $th = $this->model->map_request('raw_query', '', '', '', '', array($v['stock_name'], $m[$_m], $y));
                $v['selling_price'] = $th[0]['selling_price'];
                $v['cost_price'] = $th[0]['cost_price'];
                $temp[$k] = $v;
            }
            $_SESSION['producedadmin'] = $temp;
        }
        if ($_GET['view'] == 'salesareaadmin') {
            $stockraw = $this->model->map_request('retrieve', 'stocks', $_POST);
            $_SESSION['salesareaadmin'] = $stockraw;
            foreach ($_SESSION['salesareaadmin'] as $k => $v) {
                $month = 'January,February,March,April,May,June,July,August,September,October,November,December';
                $m = explode(',', $month);
                $y = explode('-', $v['upload_date'])[0];
                $_m = explode('-', $v['upload_date'])[1];
                $_m = intval($_m);
                $_m -= 1;

//                echo  $v['upload_date'];
                $this->model->set_query('select * from prices where stock_name= ? and month = ? and year = ? order by year DESC, month DESC LIMIT 1');
                $th = $this->model->map_request('raw_query', '', '', '', '', array($v['stock_name'], $m[$_m], $y));
                $v['selling_price'] = $th[0]['selling_price'];
                $v['cost_price'] = $th[0]['cost_price'];
                $temp[$k] = $v;
            }
            $_SESSION['salesareaadmin'] = $temp;
        }

        if ($_GET['view'] == 'stockraw') {
            $stockraw = $this->model->map_request('retrieve', 'stocks_rm', $_POST);
            $_SESSION['stockraw'] = $stockraw;
//             foreach($_SESSION['stockraw'] as $k=>$v){
//                $month = 'January,February,March,April,May,June,July,August,September,October,November,December';
//                $m = explode(',',$month);
//                $y = explode('-',$v['upload_date'])[0];
//                $_m = explode('-',$v['upload_date'])[1];
//                $_m = intval($_m);
//                $_m -= 1;
//                
////                echo  $v['upload_date'];
//                $this->model->set_query('select * from prices where stock_name= ? and month = ? and year = ? order by year DESC, month DESC LIMIT 1');
//                $th = $this->model->map_request('raw_query', '', '', '', '', array($v['stock_name'],$m[$_m],$y));
//                $v['selling_price'] = $th[0]['selling_price'];
//                $v['cost_price'] = $th[0]['cost_price'];
//                $temp[$k]= $v;
//            }
//            
//            $_SESSION['stockraw'] = $temp;
        }

        if ($_GET['view'] == 'stockfinished') {
            $finished = $this->model->map_request('retrieve', 'stocks', $_POST, 'stock_type', 'Complete Feed');
            $_SESSION['stockfinished'] = $finished;
            foreach ($_SESSION['stockfinished'] as $k => $v) {
                $month = 'January,February,March,April,May,June,July,August,September,October,November,December';
                $m = explode(',', $month);
                $y = explode('-', $v['upload_date'])[0];
                $_m = explode('-', $v['upload_date'])[1];
                $_m = intval($_m);
                $_m -= 1;

//                echo  $v['upload_date'];
                $this->model->set_query('select * from prices where stock_name= ? and month = ? and year = ? order by year DESC, month DESC LIMIT 1');
                $th = $this->model->map_request('raw_query', '', '', '', '', array($v['stock_name'], $m[$_m], $y));
                $v['selling_price'] = $th[0]['selling_price'];
                $v['cost_price'] = $th[0]['cost_price'];
                $temp[$k] = $v;
            }
            $_SESSION['stockfinished'] = $temp;
        }

        if ($_GET['view'] == 'stockconcentrate') {
            $concentrate = $this->model->map_request('retrieve', 'stocks', $_POST, 'stock_type', 'Concentrates');
            $_SESSION['stockconcentrate'] = $concentrate;
            foreach ($_SESSION['stockconcentrate'] as $k => $v) {
                $month = 'January,February,March,April,May,June,July,August,September,October,November,December';
                $m = explode(',', $month);
                $y = explode('-', $v['upload_date'])[0];
                $_m = explode('-', $v['upload_date'])[1];
                $_m = intval($_m);
                $_m -= 1;

//                echo  $v['upload_date'];
                $this->model->set_query('select * from prices where stock_name= ? and month = ? and year = ? order by year DESC, month DESC LIMIT 1');
                $th = $this->model->map_request('raw_query', '', '', '', '', array($v['stock_name'], $m[$_m], $y));
                $v['selling_price'] = $th[0]['selling_price'];
                $v['cost_price'] = $th[0]['cost_price'];
                $temp[$k] = $v;
            }

            $_SESSION['stockconcentrate'] = $temp;
        }

        if ($_GET['view'] == 'customersdirect') {
            $c = $this->model->map_request('retrieve', 'customers', $_POST);
            $_SESSION['customers'] = $c;

            if ($_POST['delete']) {
                $cust_id = $_POST['cust_id'];
                $delete = $this->model->map_request('delete', 'customers', $_POST, 'cust_id', $cust_id);
            }
        }
        if ($_GET['view'] == 'reversal') {
            if ($_POST['reversal_type']) {
                $stock = $_POST['stock'];
                $stocktype = $_POST['stock_type'];
                $quantity = $_POST['quantity'];
                $reversal_type = $_POST['reversal_type'];
                $salesarea = $_POST['sales_area'];

                if ($_POST['reversal_type'] == '2') {
                    $customer = $_POST['customer'];
                    //customer return
                    $query = 'select a.sales_id, a.stock_name, a.cust_id,a.sales_doc_no,a.sales_area ,'
                            . ' b.quantity,b.remit_date,b.current_balance,b.amount,c.cust_name'
                            . ' from sales_doc as a inner join cash_returns as b on'
                            . ' a.sales_doc_no = b.sales_id  inner join customers as '
                            . 'c on b.cust_id = c.cust_id'
                            . ' where a.sales_area = ? and a.cust_id = ? and a.stock_name = ? order by a.sales_id, '
                            . 'a.cust_id desc , a.sales_doc_no desc , b.remit_date DESC';
                    $this->model->set_query($query);
                    $th = $this->model->map_request('raw_query', '', '', '', '', array($salesarea, $customer, $stock));
                    $salesids = array();
                    $salesids_remit = array();
                    $total_qty_for_stock = 0;
                    $refunded = false;
                    if (!empty($th)) {
                        foreach ($th as $e => $f) {
                            if (!in_array($f['sales_doc_no'], $salesids)) {
                                $total_qty_for_stock += $f['quantity'];
                                array_push($salesids, $f['sales_doc_no']);
                            }
                        }

                        if (intval($quantity) > intval($total_qty_for_stock)) {
                            $this->current_page = 'view/reversalfailedqty.php';
                        } else {
                            foreach ($th as $e => $f) {
                                if (!in_array($f['sales_doc_no'], $salesids_remit) && !$refunded) {
                                    $qty_toRemit = $f['quantity'] - $quantity;
                                    if ($qty_toRemit >= 0) {
                                        //refund everything
                                        //insert record with $qty_toRemit
                                        $data = array(
                                            'cust_id' => $f['cust_id'],
                                            'sales_id' => $f['sales_doc_no'],
                                            'stock_name' => $f['stock_name'],
                                            'quantity' => $qty_toRemit,
                                            'amount' => $f['amount'],
                                            'sales_area' => $f['sales_area'],
                                            'remit_date' => date('Y-m-d'),
                                            'current_balance' => intval($f['quantity']),
                                            'action' => 'Refund'
                                        );
                                        $this->model->map_request('insert', 'cash_returns', $data);
                                        $factory = $this->model->map_request_mulwhere('retrieve', 'stocks', $_POST, array('stock_name', 'sales_area'), array($stock, 'Factory ' . $salesarea));
                                        $factoryStock = $factory[0]['quantity'];
                                        $newfactorystock = $factoryStock + $quantity;

                                        $u_data1 = array(
                                            'quantity' => $newfactorystock
                                        );
                                        $this->model->map_request_mulwhere('update', 'stocks', $u_data1, array('stock_name', 'sales_area'), array($stock, 'Factory ' . $salesarea));

                                        //insert/
                                        $refunded = true;
                                    } else {
                                        if ($f['quantity'] > 0) {
                                            //I have some
                                            $data = array(
                                                'cust_id' => $f['cust_id'],
                                                'sales_id' => $f['sales_doc_no'],
                                                'stock_name' => $f['stock_name'],
                                                'quantity' => 0,
                                                'amount' => $f['amount'],
                                                'sales_area' => $f['sales_area'],
                                                'remit_date' => date('Y-m-d'),
                                                'current_balance' => intval($f['quantity']),
                                                'action' => 'Refund'
                                            );
                                            $this->model->map_request('insert', 'cash_returns', $data);

                                            $factory = $this->model->map_request_mulwhere('retrieve', 'stocks', $_POST, array('stock_name', 'sales_area'), array($stock, 'Factory ' . $salesarea));
                                            $factoryStock = $factory[0]['quantity'];
                                            $newfactorystock = $factoryStock + $quantity;

                                            $u_data1 = array(
                                                'quantity' => $newfactorystock
                                            );
                                            $this->model->map_request_mulwhere('update', 'stocks', $u_data1, array('stock_name', 'sales_area'), array($stock, 'Factory ' . $salesarea));

                                            $quantity -= $f['quantity'];
                                        }
                                    }
//                                    print '<pre>';
//                                    print_r($data);
//                                    print'</pre>';
                                    array_push($salesids_remit, $f['sales_doc_no']);
                                }
                            }
                        }
                    } else {
                        $this->current_page = 'view/reversalfailedavail.php';
                    }
                } else {
                    $factory = $this->model->map_request_mulwhere('retrieve', 'stocks', $_POST, array('stock_name', 'sales_area'), array($stock, 'Factory ' . $salesarea));

                    $area = $this->model->map_request_mulwhere('retrieve', 'stocks', $_POST, array('stock_name', 'sales_area'), array($stock, $salesarea));

                    $factoryStock = $factory[0]['quantity'];
                    $areaStock = $area[0]['quantity'];
//                echo json_encode($factoryStock.','.$areaStock);exit();

                    $newfactorystock = $factoryStock + $quantity;
                    $newsalesareastock = $areaStock - $quantity;

                    $u_data1 = array(
                        'quantity' => $newfactorystock
                    );
                    $u_data2 = array(
                        'quantity' => $newsalesareastock
                    );

                    $this->model->map_request_mulwhere('update', 'stocks', $u_data1, array('stock_name', 'sales_area'), array($stock, 'Factory ' . $salesarea));
                    $this->model->map_request_mulwhere('update', 'stocks', $u_data2, array('stock_name', 'sales_area'), array($stock, $salesarea));
//                echo json_encode($areaStock.',');
//                echo json_encode();exit();
                    $this->current_page = 'view/reversalsuccess.php';
                }
            }

            if ($_POST['cust_check']) {
                $sales_area = $_POST['sales_area'];
                $query = 'select a.sales_id, a.stock_name, a.cust_id,a.sales_doc_no,a.sales_area ,'
                        . ' b.quantity,b.remit_date,b.current_balance,c.cust_name'
                        . ' from sales_doc as a inner join cash_returns as b on'
                        . ' a.sales_doc_no = b.sales_id  inner join customers as '
                        . 'c on b.cust_id = c.cust_id'
                        . ' where a.sales_area = ? order by a.sales_id, '
                        . 'a.cust_id desc , a.sales_doc_no desc , b.remit_date DESC ';
                $this->model->set_query($query);
                $th = $this->model->map_request('raw_query', '', '', '', '', array($sales_area));
                echo json_encode($th);
                exit();
            }
        }
        if ($_GET['view'] == 'maintaincustomers') {
            if ($_POST['customername']) {
                $data = array(
                    'cust_name' => $_POST['customername'],
                    'contact_no' => $_POST['phoneno'],
                    'address' => $_POST['address'],
                    'sales_area' => $_POST['salesarea'],
                    'customer_category' => $_POST['customercategory']
                );
                $check = $this->model->map_request('retrieve', 'customers', $_POST, 'cust_name', $_POST['customername']);
                if (!empty($check)) {
                    $update = $this->model->map_request('update', 'customers', $data, 'cust_name', $_POST['customername']);
                    if ($update) {
                        $this->current_page = 'view/customerupdated.php';
                    } else {
                        $this->current_page = 'view/customerfailure.php';
                    }
                } else {
                    $res = $this->model->map_request('insert', 'customers', $data);
                    if ($res) {
                        $this->current_page = 'view/customersuccess.php';
                    } else {
                        $this->current_page = 'view/customerfailure.php';
                    }
                }
            }
        }
        if ($_GET['view'] == 'viewstock') {
            $stock = $this->model->map_request('retrieve', 'stocks', $_POST, 'sales_area', 'Factory ' . $_SESSION['user']['sales_area']);
            $_SESSION['factory_stock'] = $stock;
            $temp = array();
            foreach ($_SESSION['factory_stock'] as $k => $v) {
                $month = 'January,February,March,April,May,June,July,August,September,October,November,December';
                $m = explode(',', $month);
                $y = explode('-', $v['upload_date'])[0];
                $_m = explode('-', $v['upload_date'])[1];
                $_m = intval($_m);
                $_m -= 1;

//                echo  $v['upload_date'];
                $this->model->set_query('select * from prices where stock_name= ? and month = ? and year = ? order by year DESC, month DESC LIMIT 1');
                $th = $this->model->map_request('raw_query', '', '', '', '', array($v['stock_name'], $m[$_m], $y));
//                echo json_encode(array($v['upload_date'],$m[$_m],$y));exit();
//                echo json_encode($th);exit();
                $v['selling_price'] = $th[0]['selling_price'];

                $temp[$k] = $v;
            }

            $_SESSION['factory_stock'] = $temp;
        }
        if ($_GET['view'] == 'itadminstock') {
            $f_stock = $this->model->map_request('retrieve', 'stocks', $_POST, 'sales_area', 'Factory ' . $_SESSION['user']['sales_area']);
            $sa_stock = $this->model->map_request('retrieve', 'stocks', $_POST, 'sales_area', $_SESSION['user']['sales_area']);

            $this->model->set_query('select * from stocks where sales_area like ?');
            $th = $this->model->map_request('raw_query', '', '', '', '', array('%' . $_SESSION['user']['sales_area'] . '%'));


            $_SESSION['my_stocks'] = $th;
            $temp = array();
            foreach ($_SESSION['my_stocks'] as $k => $v) {
                $month = 'January,February,March,April,May,June,July,August,September,October,November,December';
                $m = explode(',', $month);
                $y = explode('-', $v['upload_date'])[0];
                $_m = explode('-', $v['upload_date'])[1];
                $_m = intval($_m);
                $_m -= 1;

//                echo  $v['upload_date'];
                $this->model->set_query('select * from prices where stock_name= ? and month = ? and year = ? order by year DESC, month DESC LIMIT 1');
                $th = $this->model->map_request('raw_query', '', '', '', '', array($v['stock_name'], $m[$_m], $y));
//                echo json_encode(array($v['upload_date'],$m[$_m],$y));exit();
//                echo json_encode($th);exit();
                $v['selling_price'] = $th[0]['selling_price'];

                $temp[$k] = $v;
            }

            $_SESSION['my_stocks'] = $temp;
            if ($_POST['pleasedelete']) {
                $thisstock = $_POST['stock'];
//                $delete = $this->model->map_request_mulwhere('delete','stocks',$_POST,
//                        array('stock_name','sales_area'),array($thisstock,'Factory '.$_SESSION['user']['sales_area']));
//                        array('stock_name','sales_area'),array($thisstock,$_POST['salesarea']));
                $delete = $this->model->map_request('delete', 'stocks', $_POST, 'stock_id', $thisstock);
                echo json_encode('success');
                exit();
            }

            if ($_POST['editstock']) {
                $thisstock = $_POST['editstock'];
//                $stockdetail = $this->model->map_request_mulwhere('retrieve','stocks',$_POST,
//                        array('stock_name','sales_area'),
//                        array($_POST['editstock'],'Factory '.$_SESSION['user']['sales_area']));
//                        array($_POST['editstock'],'Factory '.$_POST['salesarea']));
                $stockdetail = $this->model->map_request('retrieve', 'stocks', $_POST, 'stock_id', $thisstock);
                $_SESSION['edit_stock'] = $stockdetail;
                $_SESSION['edit'] = true;
            } else {
                unset($_SESSION['edit']);
                unset($_SESSION['edit_stock']);
            }
        }
        if ($_GET['view'] == 'customerlist') {
            $customers = $this->model->map_request('retrieve', 'customers', $_POST, 'sales_area', $_SESSION['user']['sales_area']);
            $_SESSION['customerlist'] = $customers;

            if ($_POST['edit']) {
                $cust_name = $_POST['id'];
                $customer = $this->model->map_request('retrieve', 'customers', $_POST, 'cust_id', $cust_name);
                $_SESSION['thiscustomer'] = $customer[0];
            }

            if ($_POST['delete']) {
                $cust_id = $_POST['id'];
                $customer = $this->model->map_request('delete', 'customers', $_POST, 'cust_id', $cust_id);
            }
        }
        if ($_GET['view'] == 'createstock' || $_GET['view'] == 'createstockmd') {
            if ($_POST['stock']) {
                $_check = $this->model->map_request_mulwhere('retrieve', 'stocks', $_POST, array('stock_name', 'sales_area')
                        , array($_POST['stock'], 'Factory ' . $_SESSION['user']['sales_area']));

                if (!empty($_check)) {
                    //update
                    $newqty = $_check[0]['quantity'] + $_POST['quantity']; //change and update
//                    $newqty = $_POST['quantity'];
                    $data = array(
                        'quantity' => $newqty,
//                        'cost_price'=>$_POST['costprice'],
//                        'selling_price'=>$_POST['sellprice'],
                        'upload_date' => $_POST['upload_date']
                    );
                    $r = $this->model->map_request_mulwhere('update', 'stocks', $data, array('stock_name', 'sales_area'), array($_POST['stock'], 'Factory ' . $_SESSION['user']['sales_area']));

//                    $date = date('d-m-Y H:i:s');
                    $date = $_POST['upload_date'];

                    $data_m = array(
                        'stock_name' => $_POST['stock'],
                        'quantity' => $_POST['quantity'],
                        'movement_type' => 'IN',
                        'movement_date' => $date
                    );
                    if ($_POST['stocktype'] == 'Raw Materials') {
                        $this->model->map_request('insert', 'rm_tracker', $data_m);
                    }

                    if ($r) {
                        $this->current_page = $_GET['view'] == 'createstockmd' ? 'view/stocksuccessmd.php' : 'view/stocksuccess.php';
                    } else {
                        $this->current_page = 'view/stockfailure.php';
                    }
                } else {

                    $data = array(
                        'stock_name' => $_POST['stock'],
                        'stock_type' => $_POST['stocktype'],
                        'quantity' => $_POST['quantity'],
//                        'cost_price' => str_replace( ',', '', $_POST['costprice'] ),
//                        'selling_price' => str_replace( ',', '', $_POST['sellprice'] ),
//                        'upload_date' => date("Y-m-d H:i:s"),
                        'upload_date' => $_POST['upload_date'],
                        'sales_area' => 'Factory ' . $_SESSION['user']['sales_area']
                    );

                    $res = $this->model->map_request('insert', 'stocks', $data);
//                    $date = date('Y-m-d H:i:s');
                    $date = $_POST['upload_date'];
                    $data_m = array(
                        'stock_name' => $_POST['stock'],
                        'quantity' => $_POST['quantity'],
                        'movement_type' => 'IN',
                        'movement_date' => $date
                    );

                    if ($_POST['stocktype'] == 'Raw Materials') {
                        $insert = $this->model->map_request('insert', 'rm_tracker', $data_m);
//                        print 'Insert: '.$insert.'<br/>';
//                        print '<pre>'; print_r($data_m); print '</pre>';exit();
                    }
                    if ($res) {
                        $this->current_page = $_GET['view'] == 'createstockmd' ? 'view/stocksuccessmd.php' : 'view/stocksuccess.php';
                    } else {
                        $this->current_page = 'view/stockfailure.php';
                    }
                }
            }
        }
        if ($_GET['view'] == 'stocklist') {
            $stock = $this->model->map_request('retrieve', 'stocks', $_POST, 'sales_area', $_SESSION['user']['sales_area']);
//            print '<pre>'; print_r($_SESSION['stocklist']); print '</pre>';
            $_SESSION['stocklist'] = $stock;
            $temp = array();
            foreach ($_SESSION['stocklist'] as $k => $v) {
                $month = 'January,February,March,April,May,June,July,August,September,October,November,December';
                $m = explode(',', $month);
                $y = explode('-', $v['upload_date'])[0];
                $_m = explode('-', $v['upload_date'])[1];
                $_m = intval($_m);
                $_m -= 1;

//                echo  $v['upload_date'];
                $this->model->set_query('select * from prices where stock_name= ? and month = ? and year = ? order by year DESC, month DESC LIMIT 1');
                $th = $this->model->map_request('raw_query', '', '', '', '', array($v['stock_name'], $m[$_m], $y));

//                $this->model->set_query('select * from prices where stock_name= ? order by year DESC, month DESC LIMIT 1');
//                $th = $this->model->map_request('raw_query', '', '', '', '', array($v['stock_name']));
//                echo json_encode($_SESSION['stocklist']);
//                echo json_encode(array($_m,$y));exit();
                $v['selling_price'] = $th[0]['selling_price'];

                $temp[$k] = $v;
            }

            $_SESSION['stocklist'] = $temp;
//            print_r($_SESSION['transferstock']);exit();
        }

        if ($_GET['view'] == 'createsales') {
            $r = $this->model->map_request('retrieve', 'stocks', $_POST, 'sales_area', $_SESSION['user']['sales_area']);
            $_SESSION['sales_stock'] = $r;

            $cust = $this->model->map_request('retrieve', 'customers', $_POST, 'sales_area', $_SESSION['user']['sales_area']);
            $_SESSION['customers'] = $cust;

            if ($_POST['retrieve']) {
                $stock = $_POST['stock'];
                $year = explode('-', $_POST['date'])[0];
                $month = explode('-', $_POST['date'])[1];
                $months = 'January,February,March,April,May,June,July,August,September,October,November,December';
                $m = explode(',', $months);
                $_m = intval($month);
                $_m -= 1;
                foreach ($_SESSION['sales_stock'] as $k => $v) {
                    if ($v['stock_name'] == $stock) {
                        $this->model->set_query('select * from prices where stock_name= ? and year = ? and month = ?');
                        $th = $this->model->map_request('raw_query', '', '', '', '', array($stock, $year, $m[$_m]));
//                          echo json_encode($th);exit();
//                          echo json_encode($th);exit();
                        $costprice = $v['cost_price'];
                        $sellprice = $v['selling_price'];
                        $stocktype = $v['stock_type'];
                        $qty = $v['quantity'];
//                           echo json_encode(array($costprice,$sellprice,$qty,$stocktype));
//                           echo json_encode($th[0]);exit();
//                           echo json_encode($m);exit();
                        echo json_encode(array($th[0]['cost_price'], $th[0]['selling_price'], $qty, $stocktype));
                        exit();
                    }
                }
            }

            if ($_POST['makesale']) {
                $customer = $_POST['customer'];
                $date = $_POST['docdate'];
                $lines = $_POST['lines'];
                $salesarea = $_POST['sales_area'];
                $salesdocno = $this->generateRequestCode();

                if (strpos($lines, ',') !== false) {
                    $all_lines = explode(',', $lines);
                    for ($c = 0; $c < count($all_lines); $c++) {
                        $thisLine = explode(':', $all_lines[$c]);
                        $total = floatval($thisLine[3]) * floatval($thisLine[1]);
                        $data = array(
                            'stock_name' => $thisLine[0],
                            'cust_id' => $customer,
                            'quantity' => $thisLine[1],
                            'cost_price' => $thisLine[2],
                            'unit_price' => $thisLine[3],
                            'total_price' => $total,
                            'sales_date' => $date,
                            'sales_doc_no' => $salesdocno,
                            'sales_area' => $salesarea,
                            'trans_type' => $_POST['trans_type'],
                            'month' => explode('-', $date)[1],
                            'year' => explode('-', $date)[0]
                        );

                        $result = $this->model->map_request('insert', 'sales_doc', $data);
                        $r_1 = $this->model->map_request_mulwhere('retrieve', 'stocks', $_POST, array('stock_name', 'sales_area'), array($thisLine[0], $salesarea));

                        $_qty = $r_1[0]['quantity'];
                        $_nqty = floatval($_qty) - floatval($thisLine[1]);

                        $U = $this->model->map_request_mulwhere('update', 'stocks', array('quantity' => $_nqty), array('stock_name', 'sales_area')
                                , array($thisLine[0], $salesarea));
                    }
                } else {
                    $thisLine = explode(':', $lines);
                    $total = floatval($thisLine[3]) * floatval($thisLine[1]);
                    $data = array(
                        'stock_name' => $thisLine[0],
                        'cust_id' => $customer,
                        'quantity' => $thisLine[1],
                        'cost_price' => $thisLine[2],
                        'unit_price' => $thisLine[3],
                        'total_price' => $total,
                        'sales_date' => $date,
                        'sales_doc_no' => $salesdocno,
                        'sales_area' => $salesarea,
                        'trans_type' => $_POST['trans_type'],
                        'month' => explode('-', $date)[1],
                        'year' => explode('-', $date)[0]
                    );
                    $result = $this->model->map_request('insert', 'sales_doc', $data);

                    $r_1 = $this->model->map_request_mulwhere('retrieve', 'stocks', $_POST, array('stock_name', 'sales_area'), array($thisLine[0], $salesarea));

                    $_qty = $r_1[0]['quantity'];
                    $_nqty = floatval($_qty) - floatval($thisLine[1]);

                    $U = $this->model->map_request_mulwhere('update', 'stocks', array('quantity' => $_nqty), array('stock_name', 'sales_area')
                            , array($thisLine[0], $salesarea));
                }

                $_SESSION['salesdocno'] = $salesdocno;
//                $this->current_page = 'view/salessuccess.php';
                if ($result) {
                    echo json_encode('success');
                    exit();
                } else {
                    echo json_encode('failure');
                    exit();
                }
            }

            if ($_POST['check']) {
                $customer = $_POST['customer'];
                $cust = $this->model->map_request('retrieve', 'customers', $_POST, 'cust_id', $customer);
                echo json_encode($cust[0]);
                exit();
            }
        }
        if ($_GET['view'] == 'rawmateriallist') {
            $rmlist = $this->model->map_request('retrieve', 'stocks_rm', $_POST, 'sales_area', 'Factory ' . $_SESSION['user']['sales_area']);
            $_SESSION['raw_material_list'] = $rmlist;
        }
        if ($_GET['view'] == 'home' || $_GET['view'] == 'login') {
            $sales = $this->model->map_request('retrieve', 'sales_doc', $_POST);
            $_SESSION['admin_sales'] = $sales;
            rsort($_SESSION['admin_sales']);

            $request = $this->model->map_request('retrieve', 'stock_request', $_POST);
            $_SESSION['requestlist'] = $request;

            $stocks = $this->model->map_request('retrieve', 'stocks', $_POST);
            $_SESSION['stock_value'] = $stocks;


            $stocks_rm = $this->model->map_request('retrieve', 'stocks_rm', $_POST);
            $_SESSION['stockrm_value'] = $stocks_rm;

            $sales = $this->model->map_request('retrieve', 'sales_doc', $_POST);
            $_SESSION['sales_details'] = $sales;

            $expenses = $this->model->map_request('retrieve', 'expenses', $_POST);
            $_SESSION['expense_details'] = $expenses;

            $customers = $this->model->map_request('retrieve', 'customers', $_POST);
            $_SESSION['all_naik_customers'] = $customers;
        }
        if ($_GET['view'] == 'stockrequest') {
            $res = $this->model->map_request('retrieve', 'stocks', $_POST, 'sales_area', 'Factory ' . $_SESSION['user']['sales_area']);
            $_SESSION['request_stock'] = $res;
            if ($_POST['stock']) {

                $stock = explode(',', $_POST['stock']);
                if (count($stock) > 0) {
                    $qty = explode(',', $_POST['quantity']);
                    $salesarea = $_POST['sales_area'];
                    $requester = $_POST['requester'];



//                    exit();
                    $r_no = $this->generateRequestCode();
                    $insertData = array();
                    for ($i = 0; $i < count($stock); $i++) {
                        $data = array(
                            'request_no' => $r_no,
                            'stock_name' => $stock[$i],
                            'quantity' => $qty[$i],
                            'sales_area' => $salesarea,
                            'requester' => $requester,
                            'request_date' => date('Y-m-d H:i:s'),
                            'status' => 'Pending'
                        );

                        $insert = $this->model->map_request('insert', 'stock_request', $data);
                    }
                    if ($insert) {
                        echo json_encode('success');
                    } else {
                        echo json_encode('failure');
                    }
                    exit();
                } else {
                    $qty = $_POST['quantity'];
                    $salesarea = $_POST['sales_area'];
                    $requester = $_POST['requester'];
                    $stock = $_POST['stock'];
//                    $r_no = $this->generateRequestCode();
                    $data = array(
                        'request_no' => $r_no,
                        'stock_name' => $stock,
                        'quantity' => $qty,
                        'sales_area' => $salesarea,
                        'requester' => $requester,
                        'request_date' => date('Y-m-d H:i:s'),
                        'status' => 'Pending'
                    );
                    $insert = $this->model->map_request('insert', 'stock_request', $data);
                    if ($insert) {
                        echo json_encode('success');
                    } else {
                        echo json_encode('failure');
                    }
                    exit();
                }
            }
        }

        if ($_GET['view'] == 'salessalesarea') {
            $sales = $this->model->map_request('retrieve', 'sales_doc', $_POST);
            $_SESSION['admin_sales'] = $sales;

            if ($_POST['to']) {
                $_SESSION['to'] = $_POST['to'];
                $_SESSION['from'] = $_POST['from'];
            }
        }
        if ($_GET['view'] == 'stockmovement') {
            $myrequest = $this->model->map_request_mulwhere('retrieve', 'stock_request', $_POST, array('sales_area')
                    , array($_SESSION['user']['sales_area']));

            $_SESSION['requestlist'] = $myrequest;
            if ($_POST['request']) {
                $selected_request = $_POST['request'];
//                print_r($_SESSION);exit();
                foreach ($myrequest as $k => $v) {
                    if ($selected_request == $v['request_no']) {

                        //remove the stock from factory stock.
                        $current = $this->model->map_request_mulwhere('retrieve', 'stocks', $_POST, array('stock_name', 'sales_area')
                                , array($v['stock_name'], $v['sales_area']));



                        if (!empty($current)) {

                            $oldqty = $current[0]['quantity'];
                            $newqty = $oldqty + $v['quantity'];


                            $u = $this->model->map_request_mulwhere('update', 'stocks', array('quantity' => $newqty), array('stock_name', 'sales_area'), array($v['stock_name'], $v['sales_area']));
                            if ($u) {

                                $u2 = $this->model->map_request('update', 'stock_request', array('status' => 'Completed',
//                                    'request_date'=>date('Y-m-d H:i:s')
                                        ), 'request_no', $selected_request);
                                if ($u2) {
                                    echo json_encode('success');
                                    exit();
                                }
                            }
                        } else {

                            $factory = $this->model->map_request_mulwhere('retrieve', 'stocks', $_POST, array('stock_name', 'sales_area'), array($v['stock_name'], 'Factory ' . $v['requester']));


                            $factory[0]['quantity'] = $v['quantity'];
                            $factory[0]['sales_area'] = $v['sales_area'];

                            $data = array(
                                'stock_name' => $v['stock_name'],
                                'stock_type' => $factory[0]['stock_type'],
                                'quantity' => $v['quantity'],
                                'cost_price' => $factory[0]['cost_price'],
                                'selling_price' => $factory[0]['selling_price'],
//                                'upload_date'=>date("Y-m-d H:i:s"),
                                'upload_date' => $v['request_date'],
                                'sales_area' => $v['sales_area']
                            );
//                            echo json_encode($data); exit();
                            $r = $this->model->map_request('insert', 'stocks', $data);
                            $u2 = $this->model->map_request('update', 'stock_request', array('status' => 'Completed',
//                                    'request_date'=>date('Y-m-d H:i:s')),
                                'request_date' => $v['request_date']), 'request_no', $selected_request);
                            if ($r) {
                                echo json_encode('success');
                                exit();
                            } else {
                                
                            }
                        }
                    }
                }
            }

            if ($_POST['rejectrequest']) {
                $selected_request = $_POST['rejectrequest'];
                foreach ($myrequest as $k => $v) {
                    if ($selected_request == $v['request_no']) {
//                        echo json_encode($v);exit();
                        $factory = $this->model->map_request_mulwhere('retrieve', 'stocks', $_POST, array('stock_name', 'sales_area'), array($v['stock_name'], 'Factory ' . $v['requester']));

                        $newqty = floatval($factory[0]['quantity']) + floatval($v['quantity']);

                        $factory[0]['sales_area'] = $v['sales_area'];


                        $u = $this->model->map_request_mulwhere('update', 'stocks', array('quantity' => $newqty), array('stock_name', 'sales_area'), array($v['stock_name'], 'Factory ' . $v['requester']));
                        $u2 = $this->model->map_request('update', 'stock_request', array('status' => 'Rejected',
                            'request_date' => date('Y-m-d H:i:s')), 'request_no', $selected_request);
                    }
                }
            }
            if ($_POST['modal']) {
                $requestno = $_POST['requestno'];
                foreach ($_SESSION['requestlist'] as $k => $v) {
                    if ($v['request_no'] == $requestno) {
                        echo json_encode($v);
                        exit();
                    }
                }
            }
        }
    }

    function generateRequestCode() {
        $codeExist = true;

        while ($codeExist != false) {
            $code = rand(100000, 999999);
            $res = $this->model->map_request('retrieve', 'stock_request', $_GET, 'request_no', $code);

            if (!empty($res)) {
                
            } else {
                $codeExist = false;
                return $code;
            }
        }
    }

    function generateRequestCode2() {
        $codeExist = true;

        while ($codeExist != false) {
            $code = rand(1000000, 9999999);
            $res = $this->model->map_request('retrieve', 'sales_doc', $_GET, 'sales_doc_no', $code);

            if (!empty($res)) {
                
            } else {
                $codeExist = false;
                return $code;
            }
        }
    }

    function sendSMS($phoneno, $msg) {
        $owneremail = 'cyrilsayeh@gmail.com';
        $subacct = 'PPMS';
        $subacctpwd = 'passw0rd%%';
        $sender = 'PPMS';
        $url = "http://www.smslive247.com/http/index.aspx?"
                . "cmd=sendquickmsg"
                . "&owneremail=" . UrlEncode($owneremail)
                . "&subacct=" . UrlEncode($subacct)
                . "&subacctpwd=" . UrlEncode($subacctpwd)
                . "&message=" . UrlEncode($msg)
                . "&sender=" . UrlEncode($sender)
                . "&sendto=" . UrlEncode($phoneno)
                . "&msgtype=" . UrlEncode(0)
        ;
        if ($f = @fopen($url, "r")) {
            $answer = fgets($f, 255);
            if (substr($answer, 0, 2) == "OK") {
                return 1;
            } else {
                return 2;
            }
        } else {
            return 3;
        }
    }

    public function getPrice($stock, $date) {
        
    }

    public function uploadFileToStockTable($filename) {
        $companyid = 'Factory';
        $excel = new Spreadsheet_Excel_Reader();      // creates object instance of the class
        $excel->setOutputEncoding('CP1251');
        $excel->read($filename);   // reads and stores the excel file data
        $safesql = new SafeMySQL();
        //

        foreach ($excel->sheets as $k => $record) {
            $cells = $record['cells'];
            $update = 0;
            $i_count = 0;
            for ($i = 1; $i <= $record['numRows']; $i++) {
                if ($i > 1) {
                    $date = date("Y-m-d H:i:s");
                    //prepare insert for every record / update
                    $check = $this->model->map_request_mulwhere("retrieve", "stocks", $_POST, array('stock_name', 'sales_area'), array($cells[$i][1], $companyid));

                    if (!empty($check)) {
                        //update
                        $u_data = array(
                            'quantity' => ( $check[0]['quantity'] + $cells[$i][2] ),
                            'cost_price' => $cells[$i][3],
                            'upload_date' => $date,
                            'selling_price' => $cells[$i][4]
                        );
                        $upd = $this->model->map_request_mulwhere('update', 'stocks', $u_data, array('stock_name', 'sales_area'), array($cells[$i][1], $companyid));

                        $update = $upd ? $update + 1 : $update;
                    } else {
                        //insert
                        $i_data = array(
                            'stock_name' => $cells[$i][1],
                            'quantity' => $cells[$i][2],
                            'cost_price' => $cells[$i][3],
                            'upload_date' => $date,
                            'selling_price' => $cells[$i][4],
                            'sales_area' => $companyid,
                            'stock_type' => $cells[$i][5]
                        );
                        //print '<pre>'; print_r($i_data); print '</pre>';  exit();
                        $insert = $this->model->map_request('insert', 'stocks', $i_data);
                        if ($insert) {
                            $i_count += 1;
                        }
                    }
                }
            }

            return ( $i_count > 0 || $update > 0 );
        }
    }

}

/* Controller class instantiation */
$controller = new controller($db, $post, $get);
?>