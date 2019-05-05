<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 19/02/2019
 * Time: 20:28
 */

namespace FixitBundle\Service;

class HTML2PDF
{
    private $pdf;
    public function create($orientation = null,$format = null ,$lang = null,$unicode = null,$encoding = null,$margin = null)
    {
        $this->pdf = new \HTML2PDF(
            $orientation ? $orientation : $this->orientation,
            $format ? $format : $this->format,
            $lang ? $lang : $this->lang,
            $unicode ? $unicode : $this->unicode,
            $encoding ? $encoding : $this->encoding,
            $margin ? $margin : $this->margin
        );

    }
    public function generatePdf($template, $name)
    {
        $this->pdf->writeHTML($template);
        return $this->pdf->Output($name.'.pdf');
    }

}