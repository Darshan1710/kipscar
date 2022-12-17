<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/dompdf/autoload.inc.php');

class Pdf
{
    function createPDF($html, $filename='', $download=TRUE, $paper='A4', $orientation='portrait'){
        $dompdf = new Dompdf\DOMPDF(['isRemoteEnabled' => true,'isPhpEnabled'=>true]);
        $dompdf->load_html($html);
        $dompdf->set_paper($paper, $orientation);
        $dompdf->render();
        $dompdf->set_base_path('https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css');

        $canvas = $dompdf->getCanvas(); 
 
        // Get height and width of page 
        $w = $canvas->get_width(); 
        $h = $canvas->get_height(); 

        // Specify watermark image 
        $imageURL = base_url().'images/watermark.png'; 
        $imgWidth = 536; 
        $imgHeight = 164; 
         
        // Set image opacity 
        $canvas->set_opacity(.5); 
         
        // Specify horizontal and vertical position 
        $x = (($w-$imgWidth)/2); 
        $y = (($h-$imgHeight)/2); 

        $canvas->image($imageURL, $x, $y, $imgWidth, $imgHeight);

        $output = $dompdf->output();
       file_put_contents(getcwd().'/uploads/order/'.$filename.".pdf", $output);
        // if($download)
        //     $dompdf->stream($filename.'.pdf', array('Attachment' => 1));
        // else
        //     $dompdf->stream($filename.'.pdf', array('Attachment' => 0));
    }
}
?>