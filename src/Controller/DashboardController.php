<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    #[IsGranted('ROLE_USER')]
    public function dashboard(): Response
    {
        $user = $this->getUser();
        
        $userRole = 'user'; 
        
        if ($this->isGranted('ROLE_ADMIN')) {
            $userRole = 'admin';
        } elseif ($this->isGranted('ROLE_MANAGER')) {
            $userRole = 'manager';
        }
        
        return $this->render('home/dashboard/index.html.twig', [
            'user' => $user,
            'userRole' => $userRole,
        ]);
    }
}