<?php

namespace App\Controller\Api\Servicios;

use App\Repository\ServicesRepository;
use App\Service\Servicios\ServiciosService;
use DateTime;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Sasedev\MpdfBundle\Factory\MpdfFactory;

use function PHPUnit\Framework\isEmpty;

class ServiciosController extends AbstractController
{
    /**
     * @Rest\Get(path="/services")
     * @Rest\View(serializerGroups={"service"}, serializerEnableMaxDepthChecks=true)
     */
    public function getServices(ServicesRepository $servicesRepository, Request $request): array
    {
        return $servicesRepository->findAll();
    }
    /**
     * @Rest\Get(path="/services_search/{search}")
     * @Rest\View(serializerGroups={"service"}, serializerEnableMaxDepthChecks=true)
     */
    public function getSearchServices(ServiciosService $serviceManagement)
    {
        return $serviceManagement->searchService();
    }



    /**
     * @Rest\Post(path="/services")
     * @Rest\View(serializerGroups={"service"}, serializerEnableMaxDepthChecks=true)
     */
    public function postServices(ServiciosService $serviceManagement): \App\Entity\Services
    {
        return $serviceManagement->newService();
    }

    /**
     * @Rest\Get(path="/service_specific/{id}")
     * @Rest\View(serializerGroups={"service"}, serializerEnableMaxDepthChecks=true)
     */
    public function getService(ServicesRepository $servicesRepository, Request $request): array
    {
        return $servicesRepository->findBy(['id' => $request->get('id')]);
    }

    /**
     * @Rest\Put(path="/services/{id}")
     * @Rest\View(serializerGroups={"service"}, serializerEnableMaxDepthChecks=true)
     */
    public function putServices(ServiciosService $serviceManagement)
    {
        return $serviceManagement->editService();
    }

    /**
     * @Rest\Put(path="/activar_servicios")
     * @Rest\View(serializerGroups={"service"}, serializerEnableMaxDepthChecks=true)
     */
    public function putActivarServicios(ServiciosService $serviceManagement)
    {
        return $serviceManagement->activarServicio();
    }

    /**
     * @Rest\Put(path="/desactivar_servicios")
     * @Rest\View(serializerGroups={"service"}, serializerEnableMaxDepthChecks=true)
     */
    public function putDesactivarServicios(ServiciosService $serviceManagement)
    {
        return $serviceManagement->desactivarServicio();
    }

    /**
     * @Rest\Delete(path="/services/{id}")
     */
    public function deleteServices(ServiciosService $serviceManagement): \FOS\RestBundle\View\View
    {
        return $serviceManagement->deleteService();
    }

    /**
     * @Rest\Post(path="/pay_service")
     * @Rest\View(serializerGroups={"service"}, serializerEnableMaxDepthChecks=true)
     */
    public function getPayServices(ServicesRepository $servicesRepository, Request $request): array
    {
        return $servicesRepository->findPayServices($request);
    }


    /**
     * @Rest\Get(path="/pay_service_by_user")
     * @Rest\View(serializerGroups={"service"}, serializerEnableMaxDepthChecks=true)
     */
    public function getPayServicesByUser(ServicesRepository $servicesRepository): array
    {
        return $servicesRepository->findPayServicesByUser($this->getUser()->getId());
    }


    /**
     * @Rest\Get(path="/reporte/{id}")
     * @Rest\View(serializerGroups={"service"}, serializerEnableMaxDepthChecks=true)
     */
    public function pdfServiciosTotales(Request $request, ServicesRepository $servicesRepository, MpdfFactory $MpdfFactory)
    {

        // $servicios= $servicesRepository->reporteServiciosTotales($request->get('id'));
        $usuario = $servicesRepository->usuario($request->get('id'));
        $fecha = date("d") . " del " . date("m") . " de " . date("Y");
        $serviciosCliente = $servicesRepository->reporteServiciosTotales($request->get('id'));
        // dump($serviciosCliente);
        // exit();
        if (sizeof($serviciosCliente) == 0) {
            $html = '
            <html>
            <head>
            <style>
            body {font-family: sans-serif;
                font-size: 10pt;
            }
            p {	margin: 0pt; }
            table.items {
                border: 0.1mm solid #000000;
            }
            td { vertical-align: top; }
            .items td {
                border-left: 0.1mm solid #000000;
                border-right: 0.1mm solid #000000;
            }
            table thead td { background-color: #EEEEEE;
                text-align: center;
                border: 0.1mm solid #000000;
                font-variant: small-caps;
            }
            .items td.blanktotal {
                background-color: #EEEEEE;
                border: 0.1mm solid #000000;
                background-color: #FFFFFF;
                border: 0mm none #000000;
                border-top: 0.1mm solid #000000;
                border-right: 0.1mm solid #000000;
                border-bottom: 0.1mm solid #000;
            }
            .items td.totals {
                text-align: right;
                border: 0.1mm solid #000000;
            }
            .items td.cost {
                text-align: "." center; 
            }
            </style>
            </head>
            <body>
            <!--mpdf
            <htmlpageheader name="myheader">
            <table width="100%"><tr>
            <td width="50%" style="color:#0000BB; "><span style="font-weight: bold; font-size: 14pt;">Tasarauto Global Services SL.</span><br />

            Software de gestión de flotas y servicios de peritaje con Tasarauto.
            <br />Madrid, España.<br /><br /><span style="font-family:dejavusanscondensed;">&#9742;</span> +34 918 41 12 57</td>
            <td width="50%" style="text-align: right;"><br /><span style="font-weight: bold; font-size: 12pt;"></span></td>
            </tr></table>
            </htmlpageheader>
            <htmlpagefooter name="myfooter">
            <div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
            Page {PAGENO} of {nb}
            </div>
            </htmlpagefooter>
            <sethtmlpageheader name="myheader" value="on" show-this-page="1" />
            <sethtmlpagefooter name="myfooter" value="on" />
            mpdf-->
            <div style="text-align: center">REPORTE DE TOTAL DE SERVICIOS CONTRATADOS<br/></div>
            <div style="text-align: left">Fecha: ' . $fecha . ' <br/></div>
            <div style="color:red;text-align: center">El ' . $usuario['email'] . ' no ha solicitado ningun servicio<br/></div>
                     
            <br/>
            <table width="100%" style="font-family: serif;" cellpadding="10"><tr>
            <td width="40%" style="border: 0.1mm solid #888888; "><span style="font-size: 7pt; color: #555555; font-family: sans;">Cliente:</span><br /><br />' . $usuario['email'] . ' <br /></td>
            <td width="10%">&nbsp;</td>
            </tr></table>
            <br />
            <table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8">
            
            <thead>
            <tr>
            <td width="20%">Id Servicio.</td>
            <td width="20%">Nombre Servicio </td>
            <td width="20%">Precio Servicio</td>
            <td width="20%">Estado servicio</td>
            <td width="20%">Tarea del servicio</td>
            </tr>
            </thead>
            <tbody>
            <!-- ITEMS HERE -->
            <!-- END ITEMS HERE -->
            <tr>
            <td class="blanktotal" colspan="3" rowspan="6"></td>
            <td align="center" class="totals">Total servicios sin pagar:</td>
            <td align="center" class="totals cost">0</td>
            </tr>
            
            <tr>
            <td align="center" class="totals">Total servicios pagados</td>
            <td align="center" class="totals cost">0</td>
            </tr>
            <tr>
            <td align="center" class="totals"><b>Total servicios:</b></td>
            <td align="center" class="totals cost"><b>0</b></td>
        
            </tbody>
            </table>
            </body>
            </html>
            ';
            $mpdf = new \Mpdf\Mpdf([
                'margin_left' => 20,
                'margin_right' => 15,
                'margin_top' => 48,
                'margin_bottom' => 25,
                'margin_header' => 10,
                'margin_footer' => 10
            ]);

            $mpdf->SetProtection(['print']);
            $mpdf->SetTitle("Tasarauto Global Services SL. ");
            $mpdf->SetAuthor("Tasarauto Global Services SL.");
            $mpdf->SetWatermarkText("TASARAUTO");
            $mpdf->showWatermarkText = true;
            $mpdf->watermark_font = 'DejaVuSansCondensed';
            $mpdf->watermarkTextAlpha = 0.1;
            $mpdf->SetDisplayMode('fullpage');

            $mpdf->WriteHTML($html);
            return $MpdfFactory->createDownloadResponse($mpdf, "file.pdf");
        }
        $serviciosSinPagar = $servicesRepository->reporteServiciosTotalesSinPagar($request->get('id'));

        $serviciosPagados = $servicesRepository->reporteServiciosTotalesPagados($request->get('id'));

        $totalServicios = $servicesRepository->reporteTotalServicios($request->get('id'));


        $html = '
            <html>
            <head>
            <style>
            body {font-family: sans-serif;
                font-size: 10pt;
            }
            p {	margin: 0pt; }
            table.items {
                border: 0.1mm solid #000000;
            }
            td { vertical-align: top; }
            .items td {
                border-left: 0.1mm solid #000000;
                border-right: 0.1mm solid #000000;
            }
            table thead td { background-color: #EEEEEE;
                text-align: center;
                border: 0.1mm solid #000000;
                font-variant: small-caps;
            }
            .items td.blanktotal {
                background-color: #EEEEEE;
                border: 0.1mm solid #000000;
                background-color: #FFFFFF;
                border: 0mm none #000000;
                border-top: 0.1mm solid #000000;
                border-right: 0.1mm solid #000000;
                border-bottom: 0.1mm solid #000;
            }
            .items td.totals {
                text-align: right;
                border: 0.1mm solid #000000;
            }
            .items td.cost {
                text-align: "." center; 
            }
            </style>
            </head>
            <body>
            <!--mpdf
            <htmlpageheader name="myheader">
            <table width="100%"><tr>
            <td width="50%" style="color:#0000BB; "><span style="font-weight: bold; font-size: 14pt;">Tasarauto Global Services SL.</span><br />

            Software de gestión de flotas y servicios de peritaje con Tasarauto.
            <br />Madrid, España.<br /><br /><span style="font-family:dejavusanscondensed;">&#9742;</span> +34 918 41 12 57</td>
            <td width="50%" style="text-align: right;"><br /><span style="font-weight: bold; font-size: 12pt;"></span></td>
            </tr></table>
            </htmlpageheader>
            <htmlpagefooter name="myfooter">
            <div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
            Page {PAGENO} of {nb}
            </div>
            </htmlpagefooter>
            <sethtmlpageheader name="myheader" value="on" show-this-page="1" />
            <sethtmlpagefooter name="myfooter" value="on" />
            mpdf-->
            <div style="text-align: center">REPORTE DE TOTAL DE SERVICIOS CONTRATADOS</div>
            <div style="text-align: left">Fecha: ' . $fecha . '</div>
            <br/>
            <table width="100%" style="font-family: serif;" cellpadding="10"><tr>
            <td width="40%" style="border: 0.1mm solid #888888; "><span style="font-size: 7pt; color: #555555; font-family: sans;">Cliente:</span><br /><br />' . $usuario['email'] . ' <br /></td>
            <td width="10%">&nbsp;</td>
            </tr></table>
            <br />
            <table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8">
            <thead>
            <tr>
            <td width="20%">Id Servicio.</td>
            <td width="20%">Nombre Servicio </td>
            <td width="20%">Precio Servicio</td>
            <td width="20%">Estado servicio</td>
            <td width="20%">Tarea del servicio</td>
            </tr>
            </thead>
            <tbody>
            <!-- ITEMS HERE -->
            ';
        foreach ($serviciosCliente as $servicio) :
            $html .= '<tr>
                           
                           
                            <td align="center">' . $servicio['id'] . '</td>
                            <td align="center">' . $servicio['name'] . '</td>
                            <td align="center">&euro;.' . $servicio['price'] . '</td>
                            <td align="center" class="cost">' . $servicio['pago'] . '</td>
                            <td class="cost" align="center">' . $servicio['periodo_pago'] . '</td>
                        </tr>';
        endforeach;
        $html .= ' 
            <!-- END ITEMS HERE -->
            <tr>
            <td class="blanktotal" colspan="3" rowspan="6"></td>
            <td align="center" class="totals">Total servicios sin pagar:</td>
            <td align="center" class="totals cost">' . $serviciosSinPagar['sin_pagar'] . '</td>
            </tr>
            
            <tr>
            <td align="center" class="totals">Total servicios pagados</td>
            <td align="center" class="totals cost">' . $serviciosPagados['pagados'] . '</td>
            </tr>
            <tr>
            <td align="center" class="totals"><b>Total servicios:</b></td>
            <td align="center" class="totals cost"><b>' . $totalServicios['totales'] . '</b></td>
        
            </tbody>
            </table>
            </body>
            </html>
            ';
        $mpdf = new \Mpdf\Mpdf([
            'margin_left' => 20,
            'margin_right' => 15,
            'margin_top' => 48,
            'margin_bottom' => 25,
            'margin_header' => 10,
            'margin_footer' => 10
        ]);

        $mpdf->SetProtection(['print']);
        $mpdf->SetTitle("Tasarauto Global Services SL. ");
        $mpdf->SetAuthor("Tasarauto Global Services SL.");
        $mpdf->SetWatermarkText("TASARAUTO");
        $mpdf->showWatermarkText = true;
        $mpdf->watermark_font = 'DejaVuSansCondensed';
        $mpdf->watermarkTextAlpha = 0.1;
        $mpdf->SetDisplayMode('fullpage');

        $mpdf->WriteHTML($html);
        return $MpdfFactory->createDownloadResponse($mpdf, "file.pdf");
    }
    /**
     * @Rest\Get(path="/servicios_constratados_fechas/{fecha1}/{fecha2}")
     * @Rest\View(serializerGroups={"service"}, serializerEnableMaxDepthChecks=true)
     */
    
    
    /**
     * @Rest\Get(path="/servicios_max")
     * @Rest\View(serializerGroups={"service"}, serializerEnableMaxDepthChecks=true)
     */
    public function serviciosMaxi(Request $request, ServicesRepository $servicesRepository, MpdfFactory $MpdfFactory)
    {
        $date = date("d") . " del " . date("m") . " de " . date("Y");

        $servicio_maximo= $servicesRepository->servicioMax();
        
        // dump($servicio_maximo);
        // exit();
         $html = '
            <html>
            <head>
            <style>
            body {font-family: sans-serif;
                font-size: 10pt;
            }
            p {	margin: 0pt; }
            table.items {
                border: 0.1mm solid #000000;
            }
            td { vertical-align: top; }
            .items td {
                border-left: 0.1mm solid #000000;
                border-right: 0.1mm solid #000000;
            }
            table thead td { background-color: #EEEEEE;
                text-align: center;
                border: 0.1mm solid #000000;
                font-variant: small-caps;
            }
            .items td.blanktotal {
                background-color: #EEEEEE;
                border: 0.1mm solid #000000;
                background-color: #FFFFFF;
                border: 0mm none #000000;
                border-top: 0.1mm solid #000000;
                border-right: 0.1mm solid #000000;
                border-bottom: 0.1mm solid #000;
            }
            .items td.totals {
                text-align: right;
                border: 0.1mm solid #000000;
            }
            .items td.cost {
                text-align: "." center; 
            }
            </style>
            </head>
            <body>
            <!--mpdf
            <htmlpageheader name="myheader">
            <table width="100%"><tr>
            <td width="50%" style="color:#0000BB; "><span style="font-weight: bold; font-size: 14pt;">Tasarauto Global Services SL.</span><br />

            Software de gestión de flotas y servicios de peritaje con Tasarauto.
            <br />Madrid, España.<br /><br /><span style="font-family:dejavusanscondensed;">&#9742;</span> +34 918 41 12 57</td>
            <td width="50%" style="text-align: right;"><br /><span style="font-weight: bold; font-size: 12pt;"></span></td>
            </tr></table>
            </htmlpageheader>
            <htmlpagefooter name="myfooter">
            <div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
            Page {PAGENO} of {nb}
            </div>
            </htmlpagefooter>
            <sethtmlpageheader name="myheader" value="on" show-this-page="1" />
            <sethtmlpagefooter name="myfooter" value="on" />
            mpdf-->
            <div style="text-align: center">REPORTE DE SERVICIOS MAS CONTRATADOS <br /><br /></div>

            <div style="text-align: left">Fecha de reporte: '.$date.'</div>
            <br/>
          
            <br />
            <table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8">
            
            <thead>
            <tr>
            <td width="25%">Id Servicio.</td>
            <td width="25%">Nombre Servicio </td>
            <td width="25%">Precio Servicio</td>
            <td width="25%">Cantidad de contrataciones</td>
            </tr>
            </thead>
            <tbody>
            <!-- ITEMS HERE -->
            ';
            foreach ($servicio_maximo as $servicio) :
                $html .= '<tr>
                               
                               
                                <td align="center">' . $servicio['servicio_id'] . '</td>
                                <td align="center">' . $servicio['name'] . '</td>
                                <td align="center">&euro;.' . $servicio['price'] . '</td>
                                <td align="center" class="cost">' . $servicio['maximo'] . '</td>
                            </tr>';
            endforeach;
            $html .= ' 
            <!-- END ITEMS HERE -->
        
        
            </tbody>
            </table>
            </body>
            </html>
            ';
        $mpdf = new \Mpdf\Mpdf([
            'margin_left' => 20,
            'margin_right' => 15,
            'margin_top' => 48,
            'margin_bottom' => 25,
            'margin_header' => 10,
            'margin_footer' => 10
        ]);

        $mpdf->SetProtection(['print']);
        $mpdf->SetTitle("Tasarauto Global Services SL. ");
        $mpdf->SetAuthor("Tasarauto Global Services SL.");
        $mpdf->SetWatermarkText("TASARAUTO");
        $mpdf->showWatermarkText = true;
        $mpdf->watermark_font = 'DejaVuSansCondensed';
        $mpdf->watermarkTextAlpha = 0.1;
        $mpdf->SetDisplayMode('fullpage');

        $mpdf->WriteHTML($html);
        return $MpdfFactory->createDownloadResponse($mpdf, "file.pdf");


    }
    
     /**
     * @Rest\Get(path="/servicios_min")
     * @Rest\View(serializerGroups={"service"}, serializerEnableMaxDepthChecks=true)
     */
    public function serviciosMi(Request $request, ServicesRepository $servicesRepository,  MpdfFactory $MpdfFactory)
    {
        $servicio_min= $servicesRepository->servicioMin();

        $date = date("d") . " del " . date("m") . " de " . date("Y");

        // dump($servicio_maximo);
        // exit();
         $html = '
            <html>
            <head>
            <style>
            body {font-family: sans-serif;
                font-size: 10pt;
            }
            p {	margin: 0pt; }
            table.items {
                border: 0.1mm solid #000000;
            }
            td { vertical-align: top; }
            .items td {
                border-left: 0.1mm solid #000000;
                border-right: 0.1mm solid #000000;
            }
            table thead td { background-color: #EEEEEE;
                text-align: center;
                border: 0.1mm solid #000000;
                font-variant: small-caps;
            }
            .items td.blanktotal {
                background-color: #EEEEEE;
                border: 0.1mm solid #000000;
                background-color: #FFFFFF;
                border: 0mm none #000000;
                border-top: 0.1mm solid #000000;
                border-right: 0.1mm solid #000000;
                border-bottom: 0.1mm solid #000;
            }
            .items td.totals {
                text-align: right;
                border: 0.1mm solid #000000;
            }
            .items td.cost {
                text-align: "." center; 
            }
            </style>
            </head>
            <body>
            <!--mpdf
            <htmlpageheader name="myheader">
            <table width="100%"><tr>
            <td width="50%" style="color:#0000BB; "><span style="font-weight: bold; font-size: 14pt;">Tasarauto Global Services SL.</span><br />

            Software de gestión de flotas y servicios de peritaje con Tasarauto.
            <br />Madrid, España.<br /><br /><span style="font-family:dejavusanscondensed;">&#9742;</span> +34 918 41 12 57</td>
            <td width="50%" style="text-align: right;"><br /><span style="font-weight: bold; font-size: 12pt;"></span></td>
            </tr></table>
            </htmlpageheader>
            <htmlpagefooter name="myfooter">
            <div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
            Page {PAGENO} of {nb}
            </div>
            </htmlpagefooter>
            <sethtmlpageheader name="myheader" value="on" show-this-page="1" />
            <sethtmlpagefooter name="myfooter" value="on" />
            mpdf-->
            <div style="text-align: center">REPORTE DE SERVICIOS MENOS CONTRATADOS <br /><br /></div>

            <div style="text-align: left">Fecha de reporte: '.$date.'</div>
            <br/>
          
            <br />
            <table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8">
            
            <thead>
            <tr>
            <td width="25%">Id Servicio.</td>
            <td width="25%">Nombre Servicio </td>
            <td width="25%">Precio Servicio</td>
            <td width="25%">Cantidad de contrataciones</td>
            </tr>
            </thead>
            <tbody>
            <!-- ITEMS HERE -->
            ';
            foreach ($servicio_min as $servicio) :
                $html .= '<tr>
                               
                               
                                <td align="center">' . $servicio['servicio_id'] . '</td>
                                <td align="center">' . $servicio['name'] . '</td>
                                <td align="center">&euro;.' . $servicio['price'] . '</td>
                                <td align="center" class="cost">' . $servicio['minimo'] . '</td>
                            </tr>';
            endforeach;
            $html .= ' 
            <!-- END ITEMS HERE -->
        
        
            </tbody>
            </table>
            </body>
            </html>
            ';
        $mpdf = new \Mpdf\Mpdf([
            'margin_left' => 20,
            'margin_right' => 15,
            'margin_top' => 48,
            'margin_bottom' => 25,
            'margin_header' => 10,
            'margin_footer' => 10
        ]);

        $mpdf->SetProtection(['print']);
        $mpdf->SetTitle("Tasarauto Global Services SL. ");
        $mpdf->SetAuthor("Tasarauto Global Services SL.");
        $mpdf->SetWatermarkText("TASARAUTO");
        $mpdf->showWatermarkText = true;
        $mpdf->watermark_font = 'DejaVuSansCondensed';
        $mpdf->watermarkTextAlpha = 0.1;
        $mpdf->SetDisplayMode('fullpage');

        $mpdf->WriteHTML($html);
        return $MpdfFactory->createDownloadResponse($mpdf, "file.pdf");


    }
    
}
