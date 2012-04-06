<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * This file is part of the Cupon sample application.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Este archivo pertenece a la aplicación de prueba Cupon.
 * El código fuente de la aplicación incluye un archivo llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace Vecinos\EspacioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SitioController extends Controller
{
    /**
     * Muestra las páginas estáticas del sitio web
     *
     * @param string $pagina El slug de la página a mostrar
     */
    public function estaticaAction($pagina)
    {
        $respuesta = $this->render('EspacioBundle:Sitio:'.$pagina.'.html.twig');
        $respuesta->setSharedMaxAge(3600 * 24);
        $respuesta->setPublic();
        
        return $respuesta;
        
        /* Código necesario para lanzar un error 404 en las páginas que no existen
        
        $plantilla = realpath(__DIR__.'/../Resources/views/Sitio/'.$pagina.'.html.twig');
        
        if (file_exists($plantilla)) {
            $respuesta = $this->render('OfertaBundle:Sitio:'.$pagina.'.html.twig');
            $respuesta->setSharedMaxAge(3600 * 24);
            $respuesta->setPublic();

            return $respuesta;
        }
        else {
            throw $this->createNotFoundException('No se ha encontrado la página solicitada');
        }
        */
    }
    
    /**
     * Muestra el formulario de contacto y también procesa el envío de emails
     *
     */
    public function contactoAction()
    {
        $peticion = $this->getRequest();
        
        // Se crea un formulario "in situ", sin clase asociada
        $formulario = $this->createFormBuilder()
            ->add('remitente', 'email')
            ->add('mensaje', 'textarea')
            ->getForm()
        ;
        
        if ($peticion->getMethod() == 'POST') {
            $formulario->bindRequest($peticion);
            
            if ($formulario->isValid()) {
                $datos = $formulario->getData();
                
                $contenido = sprintf(" Remitente: %s \n\n Mensaje: %s \n\n Navegador: %s \n Dirección IP: %s \n",
                    $datos['remitente'],
                    htmlspecialchars($datos['mensaje']),
                    $peticion->server->get('HTTP_USER_AGENT'),
                    $peticion->server->get('REMOTE_ADDR')
                );
                
                $mensaje = \Swift_Message::newInstance()
                    ->setSubject('Contacto')
                    ->setFrom($datos['remitente'])
                    ->setTo('contacto@cupon')
                    ->setBody($contenido)
                ;
                
                $this->container->get('mailer')->send($mensaje);
                
                $this->get('session')->setFlash('info',
                    'Tu mensaje se ha enviado correctamente.'
                );
                
                return $this->redirect($this->generateUrl('portada'));
            }
        }
        
        return $this->render('EspacioBundle:Sitio:contacto.html.twig', array(
            'formulario' => $formulario->createView(),
        ));
    }
}
