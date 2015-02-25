<?php

namespace Enigmatic\CRMBundle\Services;

use Enigmatic\CRMBundle\Entity\Activity;
use Enigmatic\CRMBundle\Entity\ActivityType;
use Enigmatic\CRMBundle\Entity\User;
use Enigmatic\CRMBundle\Manager\UserManager;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Translation\Translator;

class CalendarService
{
    protected $authorizationChecker;
    protected $userManager;
    protected $translator;

    /**
     * Constructor
     */
    public function __construct(UserManager $userManager, AuthorizationChecker $authorizationChecker, Translator $translator)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->userManager = $userManager;
        $this->translator = $translator;
    }

    /**
     * ActivityToEvent
     *
     * @param Activity $activity
     * @return array
     */
    public function ActivityToEvent(Activity $activity) {

        $event = array(
            'id' => $activity->getId(),
            'title' => $activity->getAccount()->getName(),
            'activity_author' => ($activity->getUser() == $this->userManager->getCurrent())?0:($activity->getUser()->getFirstname().' '.$activity->getUser()->getName()),
            'activity_agency' => $activity->getUser()->getAgency()->getName(),
            'activity_replanned' => $activity->getReplanned()?$activity->getReplanned()->getDateStart()->format('d-m-Y à H:i'):0,
            'activity_type' => $this->translator->trans('enigmatic.crm.activity_type.field.type.'.$activity->getType()->getType()),
            'activity_type_name' => $activity->getType()->getTitle(),
            'description' => $activity->getComment(),
            'start' => $activity->getDateStart()->format('c'),
            'end' => $activity->getDateEnd()->format('c'),
            'editable' => ($activity->getReplanned()?false:($this->authorizationChecker->isGranted('ROLE_RCA')?true:(($activity->getUser() == $this->userManager->getCurrent())?true:false))),
            'color' => $this->getColor($activity, $activity->getReplanned(), $activity->getType()->getType())
        );

        return $event;
    }

    protected function getColor(Activity $activity = null, $replanned = false, $type = ActivityType::CALL) {

        if ($activity->getUser() == $this->userManager->getCurrent()) {
            if ($replanned)
                if ($type == ActivityType::CALL)
                    return '#A9B7C0';
                else
                    return '#BBCBA3';
            else
                if ($type == ActivityType::CALL)
                    return '#3B90AC';
                else
                    return '#2E8B57';
        }
        else {
            if ($this->authorizationChecker->isGranted('ROLE_RS')) {
                if ($replanned)
                    return '#CCCCCC';
                else
                    return $this->parseIdColor($activity->getAccount()->getId());
            } elseif ($this->authorizationChecker->isGranted('ROLE_RCA')) {
                if ($replanned)
                    return '#CCCCCC';
                else
                    return $this->parseIdColor($activity->getUser()->getId());
            } elseif ($this->authorizationChecker->isGranted('ROLE_CA')) {
                if ($replanned)
                    if ($type == ActivityType::CALL)
                        return '#C0B997';
                    else
                        return '#C0B997';
                else
                    if ($type == ActivityType::CALL)
                        return '#C0B35D';
                    else
                        return '#C0B35D';
            }
        }
        return '#C0B35D';
    }

    public function parseIdColor($id) {
        while($id >= 20)
            $id = floor($id / 2);

        $color = array('#00C015', '#5076C0', '#C00303','#C00EB7', '#512FC0', '#8BC000', '#638FC0', '#45207E', '#7E1455', '#1B7E67', '#6B7E2D', '#7E5A2D',
        '#203D7E', '#7E2A5B', '#597E76', '#3A0D13', "#203A24", "#3A3607", "#BB70E5", "#964842");

        return $color[$id];
    }
}