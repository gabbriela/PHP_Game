<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Attack;
use AppBundle\Entity\AttackUnits;
use AppBundle\Entity\BattleReport;
use AppBundle\Entity\UserResource;
use AppBundle\Entity\UserUnits;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\Container;


/**
 * @property  Container container
 */
class BattlesController extends Controller
{
    /**
     * @Route("/report", name="battle_report")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function reportAction()
    {

        $battleService = $this->container->get('battle_report');

        $user = $this->getUser();
        $battleService->updateAttacks($user);

        $userAttacksUpdated = $this->getDoctrine()->getRepository(Attack::class)->findBy(['attacker' => $user, 'status' => 'progress']);

        $userWinner = $this->getDoctrine()->getRepository(BattleReport::class)->findBy(['winner' => $user]);
        $userLooser = $this->getDoctrine()->getRepository(BattleReport::class)->findBy(['looser' => $user]);

        return $this->render('Attacks/attackInformation.html.twig',[
            'currentAttack' => $userAttacksUpdated,
            'userWinner' => $userWinner,
            'userLooser' => $userLooser]);
    }
}
