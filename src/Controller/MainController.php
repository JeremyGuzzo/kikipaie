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

    

        $positif = array();
        $negatif = array();
        
        $total = 0;

        foreach($users as $user) {
            $total += $user->getSpending();
        }

        $mediumAmount = $total / sizeof($users);

        foreach($users as $user) {
            if($user->getSpending() > $mediumAmount) {
                $user->setSpending($user->getSpending()- $mediumAmount);
                array_push($positif, $user);
            }
            elseif($user->getSpending() < $mediumAmount) {
                $user->setSpending($user->getSpending()- $mediumAmount);
                array_push($negatif, $user);
            }
        }

        $results = array();

        for ($i = 0; $i < sizeof($negatif); $i++){
            for ($j = 0; $j < sizeof($positif); $j++){
                if($positif[$j]->getSpending() == 0){
                    $j++;
                } elseif ( ($positif[$j]->getSpending() > $negatif[$i]->getSpending() && $negatif[$i]->getSpending() < 0) ) {
                    $reste = $positif[$j]->getSpending() - ($negatif[$i]->getSpending() * -1);
                    $paiement = $positif[$j]->getSpending() - $reste;
                    $positif[$j]->setSpending($positif[$j]->getSpending() - $paiement);
                    $negatif[$i]->setSpending($negatif[$i]->getSpending() + $paiement);
                    array_push($results, ($negatif[$i]->getName() . " doit donner " . $paiement . " € à " . $positif[$j]->getName()));
                } elseif ( ($positif[$j]->getSpending() < $negatif[$i]->getSpending() && $negatif[$i]->getSpending() < 0)) {
                    $paiement = $positif[$j]->getSpending();
                    $positif[$j]->setSpending($positif[$j]->getSpending() - $paiement);
                    $negatif[$i]->setSpending($negatif[$i]->getSpending() + $paiement);
                    array_push($results, ($negatif[$i]->getName() . " doit donner " . $paiement . " € à " . $positif[$j]->getName()));
                } elseif ( ($positif[$j]->getSpending() == $negatif[$i]->getSpending() && $negatif[$i]->getSpending() < 0)) {
                    $paiement = $positif[$j]->getSpending();
                    $positif[$j]->setSpending(0);
                    $negatif[$i]->setSpending(0);
                    array_push($results, ($negatif[$i]->getName() . " doit donner " . $paiement . " € à " . $positif[$j]->getName()));
                } else {
                    $j++;
                }
            }
        }

        return $this->render('main/recap.html.twig', [
            'controller_name' => 'MainController',
            'group' => $group,
            'results' => $results,
            'users' => $users
        ]);
    }
}
