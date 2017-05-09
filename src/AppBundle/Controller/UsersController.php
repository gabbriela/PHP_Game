<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Building;
use AppBundle\Entity\Map;
use AppBundle\Entity\ProgressResourcesRenew;
use AppBundle\Entity\Resources;
use AppBundle\Entity\User;
use AppBundle\Entity\UserBuilding;
use AppBundle\Entity\UserResource;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UsersController extends Controller
{
    /**
     * @Route("/register", name="user_register")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(Request $request)
    {
        $error = '';

        // 1) build the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            // 5) initial buildings: 1 castle, 2 houses, 1 farm
            $castle = $this->getDoctrine()->getRepository(Building::class)->findOneBy(['name' => 'Castle']);
            $house1 = $this->getDoctrine()->getRepository(Building::class)->findOneBy(['name' => 'House']);
            $house2 = $this->getDoctrine()->getRepository(Building::class)->findOneBy(['name' => 'House']);
            $farm = $this->getDoctrine()->getRepository(Building::class)->findOneBy(['name' => 'Farm']);

            $startBuildings =[$castle, $house1, $house2, $farm];

            foreach($startBuildings as $building){

                $userBuilding = new UserBuilding();
                $userBuilding->setUser($user);
                $userBuilding->setBuilding($building);
                $userBuilding->setBuildingLevel(1);

                $em = $this->getDoctrine()->getManager();
                $em->persist($userBuilding);
                $em->flush();

                if($building->getName() == 'Farm'){
                    $now = new \DateTime('now');
                    $resourceBuilding = new ProgressResourcesRenew();
                    $resourceBuilding->setUserBuilding($userBuilding);
                    $resourceBuilding->setLastUpdateOn($now);
                    $resourceBuilding->setUser($user);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($resourceBuilding);
                    $em->flush();
                }
            }


            $initialResources = $this->getDoctrine()->getRepository(Resources::class)->findAll();

            foreach ($initialResources as $res){
                $userRes = new UserResource();

                $userRes->setUser($user);
                $userRes->addResource($res);
                $userRes->setAmount(10000);

                $em = $this->getDoctrine()->getManager();
                $em->persist($userRes);
                $em->flush();
            }


            //Map coordinates
            $map = new Map();
            $max = 200;
            $min = 0;

            $rndX = random_int($min, $max);
            $rndY = random_int($min, $max);

            do {
                $positionExists = $this->getDoctrine()->getRepository(Map::class)->findOneBy([
                    'positionX' => $rndX,
                    'positionY' => $rndY]);
            } while($positionExists !== null);

            $map->setPositionX($rndX);
            $map->setPositionY($rndY);
            $map->setUser($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($map);
            $em->flush();


            return $this->redirectToRoute('security_login');
        }

        return $this->render(
            'user/register.html.twig',
            array('form' => $form->createView())
        );
    }


    /**
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @Route("/profile", name="user_profile")
     */
    public function profileAction()
    {
        $user = $this->getUser();

        return $this->render("user/profile.html.twig", ['user' => $user]);
    }

    /**
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @Route("/profile/edit", name="edit_profile")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function profileEditAction($id, Request $request)
    {
        // 1) build the form
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('user_profile');
        }

        return $this->render('user/edit_profile.html.twig',
            array('form' => $form->createView(), 'user'=>$user));
    }


}

