<?php

namespace Vecinos\JuntaBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Vecinos\UsuarioBundle\Entity\Usuario;
use Vecinos\JuntaBundle\Entity\Junta;
use Doctrine\Common\Persistence\ObjectManager;


/**
 * Fixtures de la entidad Junta.
 * Crea juntas para poder probar la aplicación.
 */
class Juntas extends AbstractFixture implements OrderedFixtureInterface
{
    
    public function getOrder()
    {
	return 6;
    }



    public function load(ObjectManager $manager)
    {
        

	$usuarios = $manager->getRepository('UsuarioBundle:Usuario')->findAll();



	$juntas = array(
	  array('titulo' => 'Inicio de la Comunidad', 'descripcion' => 'Bienvenida a todos los nuevos inquilinos', 'lugar' => 'Vestíbulo', 'fecha' => '2011-10-12', 'hora1' => new \DateTime('9:45:00'), 'hora2' => new \DateTime('10:45:00'),
            'usuarios' => $usuarios),
          array('titulo' => 'Nuevo Inquilino', 'descripcion' => 'Bienvenida al nuevo inquilino del 4ºb', 'lugar' => 'Vestíbulo', 'fecha' => '2012-1-15', 'hora1' => new \DateTime('9:45:00'),  'hora2' => new \DateTime('10:45:00'),
            'usuarios' => $usuarios),
          array('titulo' => 'Normativa del segundo trimestre', 'descripcion' => 'Reglas y normas a cumplir por todos los vecinos', 'lugar' => 'Vestíbulo', 'fecha' => '2012-5-20', 'hora1' => new \DateTime('14:15:00'), 'hora2' => new \DateTime('14:15:00'),
            'usuarios' => $usuarios),
          array('titulo' => 'Contratación jardinero', 'descripcion' => 'Debate sobre la contratación o no de un trabajador para cuidar las zonas comunes de la comunidad', 'lugar' => 'Vestíbulo', 'fecha' => '2012-11-24', 'hora1' => new \DateTime('16:30:00'), 'hora2' => new \DateTime('17:30:00'),
            'usuarios' => $usuarios),
          array('titulo' => 'Servicios de Limpieza', 'descripcion' => 'Servicio de limpieza, tanto de las calles interiores como de los bloques', 'lugar' => 'Vestíbulo', 'fecha' => '2012-5-7', 'hora1' => new \DateTime('12:20:00'), 'hora2' => new \DateTime('13:20:00'),
            'usuarios' => $usuarios),

            );

        foreach ($juntas as $junta) {
	    $entidad = new Junta();
            $entidad->setTitulo($junta['titulo']);
            $entidad->setDescripcion($junta['descripcion']);
            $entidad->setLugar($junta['lugar']);
            $entidad->setFecha($junta['fecha']);
            $entidad->setHora1($junta['hora1']);
            $entidad->setHora2($junta['hora2']);
            $entidad->setUsuarios($junta['usuarios']);
            $entidad->setPath('Ruta de ejemplo');
            
            $manager->persist($entidad);
        }
        
        $manager->flush();
    }
}