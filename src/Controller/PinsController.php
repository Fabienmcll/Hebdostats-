<?php

namespace App\Controller;

use App\Entity\Pin;
use App\Form\PinType;
use App\Repository\PinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PinsController extends AbstractController
{

    public function index(PinRepository $pinRepository): Response
    {
        $pins = $pinRepository->findBy([],['createdAt'=> 'DESC']);

        return $this->render('pins/index.html.twig', compact('pins'));

    }

    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $pin = new Pin;

        $form = $this->createForm(PinType::class, $pin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $em->persist($pin);
            $em->flush();

            $this->addFlash('success','Pin successfully created !');


            return $this->redirectToRoute('app_home');
        }
        return $this->render('pins/create.html.twig',[
            'form' => $form->createView()
        ]);
    }

    public function show(Pin $pin): Response
    {
        return $this->render('pins/show.html.twig', compact('pin'));
    }

    public function edit(Request $request, Pin $pin, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(PinType::class, $pin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $em->flush();

            $this->addFlash('success','Pin successfully updated !');

            return $this->redirectToRoute('app_home');
        }
        return $this->render('pins/edit.html.twig', [
            'pin'=> $pin,
            'form'=> $form->createView()
        ]);
    }

    public function delete(Request $request, Pin $pin, EntityManagerInterface $em): Response
    {
        if($this->isCsrfTokenValid('pin_deletion'.$pin->getId(), $request->request->get('csrf_token'))){
        $em->remove($pin);
        $em->flush();
            $this->addFlash('info','Pin successfully deleted !');

        }
        return $this->redirectToRoute('app_home');
    }
}
