<?php
namespace App\Controller;
use App\Entity\Animal;
use App\Form\AnimalType;
use App\Repository\AnimalRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use http\Client\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\Clock\now;

#[Route('/animal', name: 'animal_')]
class AnimalController extends AbstractController
{
    private $animals = [
        1 => ["Elephant", "Inde"],
        2 => ["Tigre", "Inde"],
        3 => ["Lion", "Ethiopie"],
        4 => ["Flamant rose", "Egypte"]
    ];
    #[Route('/', name: 'list')]
    public function list(AnimalRepository $animalRepository): Response
    {
        $animals = $animalRepository->findAll();
        $animalsCount = $animalRepository->count([]);
            dump($animals);
        return $this->render('animal/index.html.twig', [
            'animals' => $animals,
            'animalsCount' => $animalsCount
        ]);
    }

    /**
     * @param $id
     * @return Response
     */
    #[Route(
        '/{id}',
        name: 'details',
        requirements: ["id" => "\d+"],
        methods: ["GET"]
    )]
    public function details($id, AnimalRepository $animalRepository): Response
    {
        $animal = $animalRepository->find($id);

        return $this->render('animal/details.html.twig', [
            "animal" => $animal
        ]);
    }
    #[route('/create', name: 'create')]
    public function create(EntityManagerInterface $entityManager, \Symfony\Component\HttpFoundation\Request $request): Response
    {
        /*formulaire*/
        $animal = new Animal();
        $animalForm = $this->createForm(AnimalType::class, $animal);

        $animalForm->handleRequest($request);
        if($animalForm->isSubmitted() && $animalForm->isValid()) {
            try {
                $entityManager->persist($animal);
                $entityManager->flush();
                $this->addFlash('success', "L'animal a bien été inséré en BDD");
            } catch (Exception $exception) {
                $this->addFlash('echec', 'Fuck erreur');
            }

        }




/*        $animal = new Animal();
        $animal->setName("Quezac");
        $animal->setSpecie("eau");
        $animal->setPlaceOfBirth('France');
        $date = new \DateTime("1978-10-10");
        $animal->setBirthDate($date);
        dump($animal);
        $entityManager->persist($animal);

        $entityManager->flush();
*/
//        foreach ($this->animals as  $animal) {
//            $animalEntity = new Animal();
//            $animalEntity->setName("Sylvain");
//            $animalEntity->setSpecie($animal[0]);
//            $animalEntity->setPlaceOfBirth($animal[1]);
//            $animalEntity->setBirthDate(new  \DateTime());
//
//            $entityManager->persist($animalEntity);
//        }
//        $entityManager->flush();

//        return $this->render('animal/create.html.twig', [
//            'animal' => $animal
//        ]);
        return $this->render('animal/createform.html.twig', [
            'animalForm' => $animalForm->createView()
        ]);
    }

    #[route('/custom', name: 'custom')]
    public function custom(AnimalRepository $animalRepository):Response
    {
        $animal = $animalRepository->findOneBy(['name' => 'Sylvain']);
        return $this->render('animal/custom.html.twig', [
            'animal' => $animal
        ]);
    }
    #[route('/roadToDQL', name: 'road_to_dql')]
    public function roadToDQL(AnimalRepository $animalRepository)
    {
        $animals = $animalRepository->findBySpecie("licorne", "Joyeux");
        dump($animals);
        return $this->render('animal/roadToDQL.html.twig', [
            'animals' => $animals
        ]);
    }

}