<?php

namespace App\Controller\Api\Servicios;


use App\Service\Contracted\ContractedService;
use App\Repository\ContratedServicesRepository;
use DateTime;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Sasedev\MpdfBundle\Factory\MpdfFactory;


class ServiciosContratadosController extends AbstractController
{
    /**
     * @Rest\Get(path="/contrated_services")
     * @Rest\View(serializerGroups={"contrated"}, serializerEnableMaxDepthChecks=true)
     */
    public function getServices(ContratedServicesRepository $contratedServicesRepository): array
    {
        return $contratedServicesRepository->findAll();
    }


    /**
     * @Rest\Get(path="/services_by_user")
     * @Rest\View(serializerGroups={"contrated"}, serializerEnableMaxDepthChecks=true)
     */
    public function getServicesByUser(ContratedServicesRepository $contratedServicesRepository): array
    {
        return $contratedServicesRepository->findBy(['user' => $this->getUser()]);
    }

    /**
     * @Rest\Get(path="/servicios_contratados_usuario_especifico/{username}")
     * @Rest\View(serializerGroups={"contrated"}, serializerEnableMaxDepthChecks=true)
     */
    public function getServiciosContratadosUsuarioEspeficio(ContratedServicesRepository $contratedServicesRepository, Request $request)
    {
        $data = json_decode($request->getContent());

        return $contratedServicesRepository->findBy(['user' => $request->get('username')]);
    }



    /**
     * @Rest\Post(path="/new_contrated")
     * @Rest\View(serializerGroups={"contrated"}, serializerEnableMaxDepthChecks=true)
     */
    public function nuevaContratacionServicios(ContractedService $ContractedServiceManagement)
    {
        return $ContractedServiceManagement->nuevaContratacionServicios();
    }

    /**
     * @Rest\Post(path="/new_contrated_optional")
     * @Rest\View(serializerGroups={"contrated"}, serializerEnableMaxDepthChecks=true)
     */
    public function nuevaContratacionServiciosOpcional(ContractedService $ContractedServiceManagement)
    {
        return $ContractedServiceManagement->nuevaContratacionServiciosOpcional();
    }

    /**
     * @Rest\Post(path="/count_documents_services_contracted")
     * @Rest\View(serializerGroups={"contrated"}, serializerEnableMaxDepthChecks=true)
     */
    public function CountDocumemntsServicesContracted(ContratedServicesRepository $contratedServicesRepository, Request $request)
    {
        return $contratedServicesRepository->countDocumentsServiceContracted($request);
    }



    /**
     * @Rest\Put(path="/activar_servicio_contratado")
     * @Rest\View(serializerGroups={"contrated"}, serializerEnableMaxDepthChecks=true)
     */
    public function activarServicioContratado(ContractedService $ContractedServiceManagement)
    {
        return $ContractedServiceManagement->activarServicioContratado();
    }

    /**
     * @Rest\Put(path="/desactivar_servicio_contratado")
     * @Rest\View(serializerGroups={"contrated"}, serializerEnableMaxDepthChecks=true)
     */
    public function desactivarServicioContratado(ContractedService $ContractedServiceManagement)
    {
        return $ContractedServiceManagement->desactivarServicioContratado();
    }

    /**
     * @Rest\Get(path="/clientes_de_servicio/{servicio}")
     * @Rest\View(serializerGroups={"contrated"}, serializerEnableMaxDepthChecks=true)
     */
    public function getClientesDeServicio(ContratedServicesRepository $contratedServicesRepository, Request $request)
    {
        return $contratedServicesRepository->findBy(['servicio' => $request->get('servicio')]);
    }

    /**
     * @Rest\Put(path="/periodo_pago")
     * @Rest\View(serializerGroups={"contrated"}, serializerEnableMaxDepthChecks=true)
     */
    public function cambiarPeriodoPago(ContractedService $ContractedServiceManagement)
    {
        return $ContractedServiceManagement->cambiarPeriodoPagoServicioContratado();
    }

    /**
     * @Rest\Get(path="/pay_service_all")
     * @Rest\View(serializerGroups={"contrated"}, serializerEnableMaxDepthChecks=true)
     */
    public function getPayServicesall(ContratedServicesRepository $contratedServicesRepository): array
    {
        return $contratedServicesRepository->findPayServicesAll();
    }

    /**
     * @Rest\Get(path="/sin_aprobar")
     * @Rest\View(serializerGroups={"contrated"}, serializerEnableMaxDepthChecks=true)
     */
    public function sinAprobar(ContratedServicesRepository $contratedServicesRepository): array
    {
        return $contratedServicesRepository->serviciosContratadosSinAprobar();
    }

    /**
     * @Rest\Get(path="/pendientes_aprobacion")
     * @Rest\View(serializerGroups={"contrated"}, serializerEnableMaxDepthChecks=true)
     */
    public function pendientesDeAprobacion(ContratedServicesRepository $contratedServicesRepository): array
    {
        return $contratedServicesRepository->serviciosContratadosPendientesDeAprobar();
    }

    /**
     * @Rest\Get(path="/aprobados")
     * @Rest\View(serializerGroups={"contrated"}, serializerEnableMaxDepthChecks=true)
     */
    public function aprobados(ContratedServicesRepository $contratedServicesRepository): array
    {
        return $contratedServicesRepository->serviciosContratadosAprobados();
    }

    // by User

    /**
     * @Rest\Post(path="/sin_aprobar_by_user")
     * @Rest\View(serializerGroups={"contrated"}, serializerEnableMaxDepthChecks=true)
     */
    public function sinAprobarByUser(ContratedServicesRepository $contratedServicesRepository, Request $request): array
    {
        return $contratedServicesRepository->serviciosContratadosSinAprobarByUser($request);
    }

    /**
     * @Rest\Post(path="/pendientes_aprobacion_by_user")
     * @Rest\View(serializerGroups={"contrated"}, serializerEnableMaxDepthChecks=true)
     */
    public function pendientesDeAprobacionByUser(ContratedServicesRepository $contratedServicesRepository, Request $request): array
    {
        return $contratedServicesRepository->serviciosContratadosPendientesDeAprobarByUser($request);
    }

    /**
     * @Rest\Post(path="/aprobados_by_user")
     * @Rest\View(serializerGroups={"contrated"}, serializerEnableMaxDepthChecks=true)
     */
    public function aprobadosByUser(ContratedServicesRepository $contratedServicesRepository, Request $request): array
    {
        return $contratedServicesRepository->serviciosContratadosAprobadosByUser($request);
    }


    /**
     * @Rest\Get(path="/servicios_contratados_fechas/{fecha1}/{fecha2}")
     * @Rest\View(serializerGroups={"service"}, serializerEnableMaxDepthChecks=true)
     */
    public function topServicioEntreFechas(MpdfFactory $MpdfFactory, Request $request, ContratedServicesRepository $contratedServicesRepository)
    {   
        $fechaInicial = new DateTime($request->get('fecha1'));
        $fechaFinal = new DateTime($request->get('fecha2'));
        $servicios = $contratedServicesRepository->serviciosContratadoEntreFechas($fechaInicial, $fechaFinal);
        $fecha = date("d") . " del " . date("m") . " de " . date("Y");
        
        if (sizeof($servicios) == 0) {
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
            <div style="text-align: center">REPORTE DE SERVICIOS CONTRATADOS ENTRE FECHAS <br/>  <br /></div>
            <div style="color:red;text-align: center">No ha solicitado servicios entre estas fechas<br/> <br/></div>

            <div <br /> style="text-align: left ">Fecha de creación de reporte: ' . $fecha . '</div>
            <br/>
            
            <table width="100%" style="font-family: serif;" cellpadding="10"><tr>
            <td width="45%" style="border: 0.1mm solid #888888;text-align: center "><span style="font-size: 7pt; color: #555555; font-family: sans;">Fecha Inicial: </span><br /><br />'.$request->get('fecha1').' <br /></td>
            <td width="10%">&nbsp;</td>
            <td width="45%" style="border: 0.1mm solid #888888;text-align: center"><span style="font-size: 7pt; color: #555555; font-family: sans;">Fecha Final: </span><br /><br />'.$request->get('fecha2').'</td>
            </tr></table>



            <br />
            <table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8">
            <thead>
            <tr>
            <td width="25%">Id Servicio.</td>
            <td width="25%">Nombre Servicio </td>
            <td width="25%">Precio Servicio</td>
            <td width="25%">Fecha de contratación de servicio</td>
         
            </tr>
            </thead>
            <tbody>
            <!-- ITEMS HERE -->
            <!-- ITEMS HERE -->
            <!-- END ITEMS HERE -->
            <!-- END ITEMS HERE -->
            <tr>
            <td class="blanktotal" colspan="3" rowspan="6"></td>
            <td align="center" class="totals">Total servicios:'.sizeof($servicios).'</td>
            <td align="center" class="totals cost"></td>
            </tr>
            
          
        
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
            <div  style="text-align: center;">REPORTE DE SERVICIOS CONTRATADOS ENTRE FECHAS <br /><br /></div>
            <div style="text-align: left ">Fecha de creación de reporte: ' . $fecha . '</div>
            <br/>
            
            <table width="100%" style="font-family: serif;" cellpadding="10"><tr>
            <td width="45%" style="border: 0.1mm solid #888888;text-align: center "><span style="font-size: 7pt; color: #555555; font-family: sans;">Fecha Inicial: </span><br /><br />'.$request->get('fecha1').' <br /></td>
            <td width="10%">&nbsp;</td>
            <td width="45%" style="border: 0.1mm solid #888888;text-align: center"><span style="font-size: 7pt; color: #555555; font-family: sans;">Fecha Final: </span><br /><br />'.$request->get('fecha2').'</td>
            </tr></table>



            <br />
            <table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8">
            <thead>
            <tr>
            <td width="25%">Id Servicio.</td>
            <td width="25%">Nombre Servicio </td>
            <td width="25%">Precio Servicio</td>
            <td width="25%">Fecha de contratación de servicio</td>
         
            </tr>
            </thead>
            <tbody>
            <!-- ITEMS HERE -->
            ';
        foreach ($servicios as $servicio) :
            
            $html .= '<tr>
                           
                           
                            <td align="center">'.$servicio->getServicio()->getId().'</td>
                            <td align="center">'.$servicio->getServicio()->getName().'</td>
                            <td align="center">&euro;.'.$servicio->getServicio()->getPrice().'</td>
                            <td align="center" class="cost">'.$servicio->getCreateAt()->format('d-m-Y').'</td>
                     
                        </tr>';
        endforeach;
        $html .= ' 
            <!-- END ITEMS HERE -->
            <tr>
            <td class="blanktotal" colspan="3" rowspan="6"></td>
            <td align="center" class="totals">Total servicios:'.sizeof($servicios).'</td>
            <td align="center" class="totals cost"></td>
            </tr>
            
          
        
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
