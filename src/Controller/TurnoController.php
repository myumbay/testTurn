<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Persona;
use App\Entity\Turno;
use App\Form\PersonaType;

class TurnoController extends AbstractController
{
    /**
     * @Route("/", name="turno")
     */
    public function index(request $request): Response
    {
		$persona=new Persona();
		$form=$this->createForm(PersonaType::class,$persona);
		$form->handleRequest($request);
		/* 2 minutos, 3 minutos */
			$ids = [2, 3];
			$turnoRepo = $this->getDoctrine()->getRepository(Turno::class);
			$results = $turnoRepo->createQueryBuilder("turno")
			->where('turno.tipoTurno IN (:ids)')
			->andwhere('turno.estado = :estado')
			->setParameter('ids', $ids)
			->setParameter('estado', '1')
			->getQuery()
			->getResult();
		
		 if ($form->isSubmitted() && $form->isValid()) {
			$em=$this->getDoctrine()->getManager();
			$em->persist($persona);
			$em->flush();
			$lastid= $persona->getId();
			
			$repository = $this->getDoctrine()->getRepository('App:Turno');
			
			
			
			$sumturno2=0;
			$sumturno3=0;
			foreach($results as $r)
			{
				if($r->getTipoTurno()=='2'){
					$sumturno2=$sumturno2+$r->getTipoTurno();
				}
				if($r->getTipoTurno()=='3'){
					$sumturno3=$sumturno3+$r->getTipoTurno();
				}
			
			}
			$tipoturno='2';$cola='Cola 1';
			if ($sumturno3==0)$sumturno3=3;
			if($sumturno2>$sumturno3  ){	
				$tipoturno='3'; $cola='Cola 2';
				
			}
			
			$hoy = new \DateTime('now');
			$p = $em->getRepository('App:Persona')->find($lastid);
			$turno = new Turno();
			$turno->setPersona($p);
			$turno->setCreated($hoy);
			$turno->setTipoTurno($tipoturno);
			$turno->setEstado('1');
			$em->persist($turno);
			$em->flush();
			

			$this->addFlash('exito','Turno Guardado asignado a: '.$cola);
			return $this->redirectToRoute('turno');
		}
        return $this->render('turno/index.html.twig', [
            'controller_name' => 'TurnoController',
			'formulario'=>$form->createView(),'result'=>$results
        ]);
    }
	 /**
     * @Route("/cambioestado", name="cambioestado")
     */
    public function cambioEstado(request $request): Response
	{
		$id=$request->query->get('id');
		$em=$this->getDoctrine()->getManager();
		$turno = $em->getRepository('App:Turno')->find($id);
		$turno->setEstado(0);
		$em->persist($turno);
		$em->flush();
		
		return $this->redirectToRoute('turno');
	}
}
