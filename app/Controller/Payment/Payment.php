<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Payment
 *
 * @author sfandrianah
 */

namespace app\Controller\Payment;

use app\Util\Form;
use app\Util\DataTable;
use app\Util\Veritrans\Config;
use app\Util\Veritrans\Snap;
use app\Util\TCPDF\TCPDF;
use app\Util\TCPDF\TCPDF2DBarcode;
use app\Util\PHPMail\PHPMailer;

class Payment {

    //put your code here

    public function confirm() {
        $Form = new Form();
        include FILE_PATH('view/page/payment/confirm.html.php');
    }

    public function cekuser() {
        $Form = new Form();
        include FILE_PATH('view/page/payment/layout/cekuser.html.php');
    }

    public function veriPayment() {


//        echo 'masuk';

        Config::$serverKey = "VT-server-8Fho3noYyX7bD4yOiwCVrDFi";

//        $adult = explode('-', $_POST['adult']);
//        $child = explode('-', $_POST['child']);
//        $infant = explode('-', $_POST['infant']);
// Optional
//        $total = ($adult[1] * $adult[0]) + ($child[1] * $child[0]) + ($infant[1] * $infant[0]);
        $total = 0;
        $item_details = '';
        for ($n = 0; $n < $_POST['count']; $n++) {
            $no = $n + 1;
            $visitor = explode('-', $_POST['visitor' . $no]);
            $total += $visitor[1] * $visitor[2];
            if (intval($visitor[1]) != 0) {
                $item1_details[] = array(
                    'id' => 'a1',
                    'price' => $visitor[2],
                    'quantity' => $visitor[1],
                    'name' => $visitor[0]
                );
            }
//            $item_details =  array_push($item_details, $item1_details);
        }
//        $item_details =  array_push($item_details, $item1_details);

        $transaction_details = array(
            'order_id' => rand(),
            'gross_amount' => $total, // no decimal allowed for creditcard
        );

// Optional
        $item_details = $item1_details;
//print_r($item_details);
// Optional
        $billing_address = array(
            'first_name' => $_POST['firstname'],
            'last_name' => $_POST['lastname'],
            'address' => $_POST['address'],
            'city' => $_POST['city'],
            'postal_code' => "16602",
            'phone' => $_POST['handphone'],
            'country_code' => 'IDN'
        );

// Optional
        $shipping_address = array(
            'first_name' => "Obet",
            'last_name' => "Supriadi",
            'address' => $_POST['address'],
            'city' => $_POST['city'],
            'postal_code' => "16601",
            'phone' => $_POST['handphone'],
            'country_code' => 'IDN'
        );

// Optional
        $customer_details = array(
            'first_name' => $_POST['firstname'],
            'last_name' => $_POST['lastname'],
            'email' => $_POST['email'],
            'phone' => $_POST['handphone'],
            'billing_address' => $billing_address,
            'shipping_address' => $shipping_address
        );

        $enable_payments = array('credit_card', 'cimb_clicks', 'mandiri_clickpay', 'echannel');

// Fill transaction details
        $transaction = array(
            'enabled_payments' => $enable_payments,
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
            'item_details' => $item_details,
        );

        $snapToken = Snap::getSnapToken($transaction);
        echo $snapToken;
    }

    public function updatePayment() {
        $type = $_POST['type'];
        $result = $_POST['result'];
        $str = '';
        if ($type == 'success') {
            $str .= $this->notifPay('success', 'Pembayaran Payment Anda Success');
        } else if ($type == 'pending') {
            $str .= $this->notifPay('warning', 'Pembayaran Payment Anda Pending');
        } else if ($type == 'error') {
            $str .= $this->notifPay('error', 'Pembayaran Payment Anda Error');
        }
        if ($this->testPDF() == "SUKSES") {
            $str .='<div class="text-center">Pengiriman email ke <span class="text-success">' . $_POST['email'] . '</span> Berhasil</div>';
//            $dif = changeElementWithValue($_SESSION['bucket'], "bucket_id", $_POST['bucket_id'], 'payment_status', 1);
//            $_SESSION['bucket'] = $dif;
        } else {
            $str .='<div class="text-center">Pengiriman email ke <span class="text-error">' . $_POST['email'] . '</span> Gagal <br/> Email Yang anda masukkan salah</div>';
        }

        $str .= $this->reloadPay();
        echo $str;
    }

    public function notifPay($type, $msg) {
        $str = '<div class="text-center"><h3 class="text-' . $type . ' text-center">' . $msg . '</h3></div>';
        return $str;
    }

    public function reloadPay() {
        $str = '<div class="text-center"><a href="javascript:void(0)" onclick="location.reload();" class="btn btn-danger btn-sm">Close</a></div>';
        return $str;
    }

    public function testPDF() {
        $date = date('Ymd');
        $years_month = date('ym');
        $transaction_code= 'OL-TWC-BRD-' . $years_month . createRandomBooking();
        $booking_code = createRandomBooking();
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $handphone = $_POST['handphone'];
        $city = $_POST['city'];
        $address = $_POST['address'];
        $category_type = $_POST['category_type'];
        $category = $_POST['category'];
        $bucket_id = $_POST['bucket_id'];
        $r_mt = json_decode($_POST['result']);
//        $lastname = $_POST['lastname'];


        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// set document information
        $pdf->SetCreator('Arium E-Commerce');
        $pdf->SetAuthor('Syahrial Fandrianah');
        $pdf->SetTitle('Arium E-Commerce - Reservation Ticket ' . $date . '-' . $booking_code);
        $pdf->SetSubject('Arium E-Commerce Ticketing');
        $pdf->SetKeywords('Reservation Ticket E-Commerce');
        $pdf->SetHeaderData(URL('/assets/img/logo3.png'), 60, '', '', array(0, 64, 255), array(0, 64, 128));
        $pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('dejavusans', '', 14, '', true);
        $pdf->AddPage();
        $html = <<<EOD
EOD;
        /*
          $style = array(
          'border' => 1,
          'vpadding' => 'auto',
          'hpadding' => 'auto',
          'fgcolor' => array(0, 0, 0),
          'bgcolor' => false, //array(255,255,255)
          'module_width' => 100,
          'module_height' => 64,
          );
         * */


        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 5, 'Booking Details', 0, 1, 'C');
        $pdf->Ln(5);

        $pdf->SetFont('helvetica', '', 10);

//        $pdf->Cell(50, 5, "Booking Code");
//        $pdf->Ln(5);
//        $pdf->Cell(244, 10, $booking_code, 0, 0, 'C');

        $pdf->Cell(95, 10, "");
        $pdf->Cell(80, 13, "Booking Code : ".$booking_code);
        $pdf->Ln(1);
//        $pdf->Cell(95, 10, "");
//        $pdf->Cell(80, 83, $booking_code);
        $pdf->write2DBarcode($booking_code, 'QRCODE,H', 110, 47, 0, 31);
        $pdf->Ln(5);

// First name
//        $pdf->Cell(35, 5, 'Booking Code');
//        $pdf->Cell(60, 5, $booking_code);
//        $pdf->Cell(35, 5, 'Booking Details');
//        $pdf->Cell(35, 5, 'Syahrial Fandrianah');
//        $pdf->Ln(6);

        $pdf->Cell(35, 5, 'First Name');
//        $pdf->Cell(60, 5, $firstname);
        $pdf->Cell(60, 5, 'Syahrial Fandrianah');
        $pdf->Ln(6);

        $pdf->Cell(35, 5, 'Last Name');
        $pdf->Cell(60, 5, $lastname);
        $pdf->Ln(6);

        $pdf->Cell(35, 5, 'Email');
        $pdf->Cell(60, 5, $email);
        $pdf->Ln(6);

        $pdf->Cell(35, 5, 'City');
        $pdf->Cell(60, 5, $city);
        $pdf->Ln(6);

        $pdf->Cell(35, 5, 'Contact');
        $pdf->Cell(60, 5, $handphone);
        $pdf->Ln(6);

        $pdf->Cell(35, 5, 'Alamat');
        $pdf->Cell(60, 5, $address);
        $pdf->Ln(6);

        $pdf->Cell(35, 5, 'Category Type');
        $pdf->Cell(60, 5, $category_type);
        $pdf->Ln(6);

        $pdf->Cell(35, 5, 'Ticket Type');
        $pdf->Cell(60, 5, $category);
        $pdf->Ln(10);

//        $pdf->SetFont('helvetica', 'B', 12);
//        $pdf->Cell(0, 5, 'Ticket Details', 0, 1, 'C');
//        $pdf->Ln(5);
// output the barcode as PNG image


        /*
          $height_brcode = 86.5;
          $pdf->SetFont('helvetica', '', 10);
          for ($n = 0; $n < $_POST['count']; $n++) {
          $no = $n + 1;
          $visitor = explode('-', $_POST['visitor' . $no]);
          $total += $visitor[1] * $visitor[2];
          if (intval($visitor[1]) != 0) {
          /*   $item1_details[] = array(
          'id' => 'a1',
          'price' => $visitor[2],
          'quantity' => $visitor[1],
          'name' => $visitor[0]
          ); */
        /*
          $height_brcode += 21;
          $pdf->Cell(50, 20.8, 'OL-TK-' . $date . '00000' . $no, 1, 0, 'C');
          $pdf->Cell(50, 20.8, 'Adult', 1, 0, 'C');
          $pdf->write2DBarcode('OL-TK-' . $date . '00000' . $no, 'PDF417', 115, $height_brcode, 0, 31, $style, 'N');
          $pdf->Ln(0);
          }
          } */

        /*
          $pdf->Cell(50, 20.8, 'OL-TK-0516000001', 1, 0, 'C');
          $pdf->Cell(50, 20.8, 'Adult', 1, 0, 'C');
          $pdf->write2DBarcode('OL-TK-0516000001', 'PDF417', 115, 86.5, 0, 31, $style, 'N');
          $pdf->Ln(0);
          $pdf->Cell(50, 20.8, 'OL-TK-0516000002', 1, 0, 'C');
          $pdf->Cell(50, 20.8, 'Adult', 1, 0, 'C');
          $pdf->write2DBarcode('OL-TK-0516000002', 'PDF417', 115, 107.5, 0, 31, $style, 'N');
          $pdf->Ln(0);
          $pdf->Cell(50, 20.8, 'OL-TK-0516000003', 1, 0, 'C');
          $pdf->Cell(50, 20.8, 'Adult', 1, 0, 'C');
          $pdf->write2DBarcode('OL-TK-0516000003', 'PDF417', 115, 128.5, 0, 31, $style, 'N');
          $pdf->Ln(0);
         */

        $pdf->Ln(5);
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 5, 'Payment Details', 0, 1, 'C');
        $pdf->Ln(5);
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->SetFillColor(217, 237, 247);
        $pdf->Cell(50, 5, 'Visitor', 1, 0, 'C', 1);
        $pdf->Cell(30, 5, 'Quantity', 1, 0, 'C', 1);
        $pdf->Cell(50, 5, 'Price', 1, 0, 'C', 1);
        $pdf->Cell(50, 5, 'Amount', 1, 0, 'C', 1);
        $pdf->Ln(5);
        $total = 0;
        for ($n = 0; $n < $_POST['count']; $n++) {
            $no = $n + 1;

            $visitor = explode('-', $_POST['visitor' . $no]);
            if (intval($visitor[1]) != 0) {
                $subtotal = $visitor[1] * $visitor[2];
                $total += $visitor[1] * $visitor[2];
                $pdf->SetFont('helvetica', '', 10);
                $pdf->Cell(50, 5, $visitor[0], 1, 0, 'C');
                $pdf->Cell(30, 5, $visitor[1], 1, 0, 'C');
                $pdf->Cell(50, 5, amountToStr($visitor[2]), 1, 0, 'R');
                $pdf->Cell(50, 5, amountToStr($subtotal), 1, 0, 'R');
                $pdf->Ln(5);
            }
        }
        /*
          $pdf->Cell(50, 5, 'Child', 1, 0, 'C');
          $pdf->Cell(30, 5, '3', 1, 0, 'C');
          $pdf->Cell(50, 5, amountToStr(20000), 1, 0, 'R');
          $pdf->Cell(50, 5, amountToStr(40000), 1, 0, 'R');
          $pdf->Ln(5);
         * 
         */
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(130, 5, 'Total', 1, 0, 'C');
        $pdf->Cell(50, 5, amountToStr($total), 1, 0, 'R');
        $pdf->Ln(5);

        $pdf->Ln(10);
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(35, 5, 'Created Date');
        $pdf->Cell(60, 5, subMonth('2016-10-10'));
        $pdf->Cell(35, 5, 'Payment Method');
        $pdf->Cell(35, 5, 'Transfer Bank BCA');
        $pdf->Ln(6);
        $pdf->Cell(35, 5, 'Expired Date');
        $pdf->Cell(60, 5, subMonth('2016-11-10'));
        $pdf->Cell(35, 5, 'Payment Amount');
        $pdf->Cell(35, 5, amountToStr($total));
        $pdf->Ln(6);
        $pdf->Cell(35, 5, 'Transaction Date');
        $pdf->Cell(60, 5, $r_mt->transaction_time);
        $pdf->Cell(35, 5, 'Payment Status');
        if ($_POST['type'] == 'success') {
            $pdf->SetTextColor(103, 255, 83);
            $pdf->Cell(35, 5, 'Lunas');
        } else {
            $pdf->SetTextColor(255, 152, 0);
            $pdf->Cell(35, 5, 'On Process');
        }
        $pdf->Ln(6);


        $pdf->Ln(50);
        $pdf->SetFont('helvetica', '', 8);
        $pdf->SetTextColor(255, 0, 0);
        $pdf->Cell(60, 5, '*Tiket Yang Sudah dibayarkan tidak bisa dikembalikan');
        $pdf->Ln(6);

// ---------------------------------------------------------
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
        $output_pdf = FILE_PATH('uploads/OL-TWC-BRD-' . $years_month . createRandomBooking() . '.pdf');
        $pdf->Output($output_pdf, 'F');
//        $pdf->Output($output_pdf, 'I');
        return $this->sendMail($output_pdf);
    }

    public function sendMail($path) {
        $date = date('Ymd');
        $years_month = date('ym');
        $transaction_code= 'OL-TWC-BRD-' . $years_month . createRandomBooking();
        $booking_code = createRandomBooking();
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $handphone = $_POST['handphone'];
        $city = $_POST['city'];
        $address = $_POST['address'];
        $category_type = $_POST['category_type'];
        $category = $_POST['category'];
        $bucket_id = $_POST['bucket_id'];
        $r_mt = json_decode($_POST['result']);

//Tell PHPMailer to use SMTP
        $mail = new PHPMailer;

        $mail->isSMTP();

        $mail->Debugoutput = 'html';
//$mail->SMTPDebug = 2;
        $mail->Host = 'smtp.gmail.com';

        $mail->Port = 465;
        $mail->SMTPSecure = 'ssl';
        $mail->SMTPAuth = true;

        $mail->Username = "ariumticketing@gmail.com";
        $mail->Password = "sigma2016.";

//Set who the message is to be sent from
        $mail->setFrom('ariumticketing@gmail.com', 'Arium Ticketing');

//Set an alternative reply-to address
        $mail->addReplyTo($email, $firstname . ' ' . $lastname);

//Set who the message is to be sent to
        $mail->addAddress($email, $firstname . ' ' . $lastname);

//Set the subject line
        $mail->Subject = 'Arium E-Commerce - Reservation Ticket ' . $date . '-' . $booking_code;

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//        $mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
        $mail->Body = 'Dear Mr ' . $firstname . ' ' . $lastname;
//Replace the plain text body with one created manually
        $mail->AltBody = '';

//Attach an image file
        $mail->addAttachment($path);

//send the message, check for errors
        if ($mail->smtpConnect()) {
            $mail->smtpClose();
            //echo "Connected";
            if (!$mail->send()) {
                // echo "1" . $mail->ErrorInfo;
//                echo json_encode($statusgagal);
                return 'GAGAL';
            } else {
//                echo json_encode($status);
                return 'SUKSES';
            }
        } else {
//            echo json_encode($statusgagal);
//            echo "Connection Failed";
            return 'GAGAL';
        }
    }

}
