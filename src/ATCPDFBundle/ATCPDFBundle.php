<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace ATCPDFBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Used to override WhiteOctoberTCPDFBundle config and take care of 'pdf_' parameters in app config
 * @codeCoverageIgnore
 * @author matthieu
 */
class ATCPDFBundle extends Bundle
{

    public function getParent() {
        return 'WhiteOctoberTCPDFBundle';
    }

    public function boot() {
        if (!$this->container->hasParameter('white_october_tcpdf.tcpdf')) {
            return;
        }

        // Define our TCPDF variables
        $config = $this->container->getParameter('white_october_tcpdf.tcpdf');

        // TCPDF needs some constants defining if our configuration
        // determines we should do so (default true)
        // Set tcpdf.k_tcpdf_external_config to false to use the TCPDF
        // core defaults
        if ($config['k_tcpdf_external_config']) {
            foreach ($config as $k => $v) {
                $constKey = strtoupper($k);

                // All K_ constants are required
                if (preg_match("/^k_/i", $k)) {
                    if (!defined($constKey)) {
                        $value = $this->container->getParameterBag()->resolveValue($v);

                        if (($k === 'k_path_cache' || $k === 'k_path_url_cache') && !is_dir($value)) {
                            $this->createDir($value);
                        }

                        define($constKey, $value);
                    }
                }
                if (preg_match("/^pdf_/i", $k)) {
                    if (!defined($constKey)) {
                        $value = $this->container->getParameterBag()->resolveValue($v);
                        define($constKey, $value);
                    }
                }
                // and one special value which TCPDF will use if present
                if (strtolower($k) == "pdf_font_name_main" && !defined($constKey)) {
                    define($constKey, $v);
                }
            }
        }
    }

}