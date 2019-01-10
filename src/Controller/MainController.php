<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Group;
use App\Entity\User;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;


class MainController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        $group = $this->getDoctrine()
            ->getRepository(Group::class)
            ->findAll();
        
        return $this->render('main/home.html.twig', [
            'groups' => $group,
        ]);
    }

    /**
     * @Route("/admin/{id}", name="admin")
     */
    public function admin($id, Request $request)
    {
        $group = $this->getDoctrine()
            ->getRepository(Group::class)
            ->find($id);
        //creer le formulaire d'ajout de participants
        $user = new User();
        $user->setGroupUsed($group);
        
        $form = $this->createFormBuilder($user)
            ->add('name', TextType::class)
            ->add('spending', IntegerType::class)
            ->add('ajouter', SubmitType::class, array('label' => 'Ajouter un participant'))
            ->getForm();
        
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('admin', array('id' => $id));
        }

        $group = $this->getDoctrine()
            ->getRepository(Group::class)
            ->find($id);

        $totalAmount = 0;
        foreach($group->getUsers() as $user) {
            $totalAmount += $user->getSpending();
        }

        return $this->render('main/admin.html.twig', [
            'group' => $group,
            'total' => $totalAmount,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/recap{id}", name="recap")
     */
    public function recap($id)
    {
        $group = $this->getDoctrine()
            ->getRepository(Group::class)
            ->find($id);
        $users = $group->getUsers();

        

        return $this->render('main/recap.html.twig', [
            'controller_name' => 'MainController',
            'group' => $group,
            'users' => $users
        ]);
    }
}
