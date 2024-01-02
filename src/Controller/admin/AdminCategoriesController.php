<?php

namespace App\Controller\admin;

use App\Entity\Categorie;
use App\Entity\Playlist;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use App\Repository\FormationRepository;
use App\Repository\PlaylistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of AdminCategoriesController
 *
 * @author theom
 */
class AdminCategoriesController extends AbstractController {
    
    /**
     * 
     * @var CategorieRepository
     */
    private $categorieRepository;    
    
    function __construct(CategorieRepository $categorieRepository) {
        $this->categorieRepository = $categorieRepository;
    }
    
    /**
     * @Route("/admin/categories", name="admin.categories")
     * @return Response
     */
    public function index(Request $request): Response{
        $categories = $this->categorieRepository->findAll();        
        $categorie = new Categorie();
        $formCategorie = $this->createForm(CategorieType::class, $categorie);
        $formCategorie->handleRequest($request);
        
        if($formCategorie->isSubmitted() && $formCategorie->isValid()){
            $nomCategorie = $formCategorie->get('name')->getData();
            $CategorieExistante = $this->getDoctrine()
                ->getRepository(Categorie::class)
                ->findOneBy(['name' => $nomCategorie]);
            if ($CategorieExistante !== null) {
                $this->addFlash('error', 'Ce nom de catégorie existe déjà.');
                return $this->redirectToRoute('admin.categories');
            }
           
            $this->categorieRepository->add($categorie, true);
            return $this->redirectToRoute('admin.categories');
        } 
        
        return $this->render("admin/admin.categories.html.twig", [
            'categories' => $categories,
            'categorie' => $categorie,
            'formCategorie' =>$formCategorie->createView()
        ]);
    }  
    /**
     * @Route("/admin/categories/suppr/{id}", name="admin.categories.suppr")
     * @param categorie $categorie
     * @return Response
     */
    public function suppr(Categorie $categorie): Response{
        $formations = $categorie->getFormations();
        
        if($formations->isEmpty()){
            $this->categorieRepository->remove($categorie, true);
            return $this->redirectToRoute('admin.categories');
        }
        else{
            $this->addFlash('warning', 'impossible');
            return $this->redirectToRoute('admin.categories');
        }

    }
    
} 
