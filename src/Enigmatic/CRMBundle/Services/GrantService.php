<?php

namespace Enigmatic\CRMBundle\Services;


use Enigmatic\CRMBundle\Entity\Account;
use Enigmatic\CRMBundle\Entity\AccountOwner;
use Enigmatic\CRMBundle\Entity\Activity;
use Enigmatic\CRMBundle\Entity\AgencyAccount;
use Enigmatic\CRMBundle\Entity\CampaignFaxing;
use Enigmatic\CRMBundle\Entity\CampaignMailing;
use Enigmatic\CRMBundle\Entity\Contact;
use Enigmatic\CRMBundle\Manager\UserManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class GrantService
{
    protected $userManager;
    protected $authorizationChecker;

    /**
     * Constructor
     */
    public function __construct(UserManager $userManager, AuthorizationChecker $authorizationChecker)
    {
        $this->userManager = $userManager;
        $this->authorizationChecker = $authorizationChecker;
    }

    public function grantAccount(Account $account) {

        $grant = false;

        if ($this->authorizationChecker->isGranted('ROLE_RS')) {
            $grant = true;
        }
        elseif ($this->authorizationChecker->isGranted('ROLE_RCA')) {
            $agency = $this->userManager->getCurrent()->getAgency();
            foreach ($account->getAgencies() as $account_agency) {
                if ($account_agency->getAgency() == $agency) {
                    $grant = true;
                    break;
                }
            }
        }
        elseif ($this->authorizationChecker->isGranted('ROLE_CA')) {
            foreach ($account->getOwners() as $account_owner) {
                if ($account_owner->getUser() == $this->userManager->getCurrent() && !$account_owner->getEnd()) {
                    $grant = true;
                    break;
                }
            }
        }

        return $grant;
    }

    public function grantContact(Contact $contact) {
        $grant = false;

        if ($this->authorizationChecker->isGranted('ROLE_RS')) {
            $grant = true;
        }
        elseif ($this->authorizationChecker->isGranted('ROLE_RCA')) {
            if (in_array($this->userManager->getCurrent()->getAgency(), $contact->getAgencies()->toArray()))
                $grant = true;
        }

        elseif ($this->authorizationChecker->isGranted('ROLE_CA')) {
            foreach ($contact->getAccount()->getOwners() as $account_owner) {
                if ($account_owner->getUser() == $this->userManager->getCurrent() && !$account_owner->getEnd()) {
                    if (in_array($this->userManager->getCurrent()->getAgency(), $contact->getAgencies()->toArray())) {
                        $grant = true;
                        break;
                    }
                }
            }
        }

        return $grant;
    }

    public function grantActivity(Activity $activity, $action = 'view') {

        $grant = false;

        if ($this->authorizationChecker->isGranted('ROLE_RS')) {
            $grant = true;
        }
        elseif ($this->authorizationChecker->isGranted('ROLE_RCA') || $this->authorizationChecker->isGranted('ROLE_CA')) {
            $agency = $this->userManager->getCurrent()->getAgency();
            foreach($activity->getUser()->getAgencies() as $histoAgence) {
                if ($agency == $histoAgence->getAgency()) {
                    if ($histoAgence->getDateCreated() <= $activity->getDateCreated()) {
                        if ($histoAgence->getEnd()) {
                            if ($histoAgence->getEnd()->getDateEnd() > $activity->getDateCreated()) {
                                $grant = true;
                            }
                        } else
                            $grant = true;
                    }
                }
            }
        }
        if ($this->authorizationChecker->isGranted('ROLE_CA') && !$this->authorizationChecker->isGranted('ROLE_RCA')) {
            if ($grant) {
                $grant = false;
                if ($action == 'view') {
                    foreach ($activity->getAccount()->getOwners() as $account_owner) {
                        if ($account_owner->getUser() == $this->userManager->getCurrent() && !$account_owner->getEnd()) {
                            $grant = true;
                            break;
                        }
                    }
                }
                else {
                    if ($activity->getUser() == $this->userManager->getCurrent())
                        $grant = true;
                }
            }
        }

        return $grant;
    }

//  @rp_todo : grant
    public function grantAgencyAccount(AgencyAccount $agencyAccount) {

        $grant = false;
        if ($this->authorizationChecker->isGranted('ROLE_RS')) {
            $grant = true;
        }
        elseif ($this->authorizationChecker->isGranted('ROLE_RCA')) {
            $grant = true;
        }
        elseif ($this->authorizationChecker->isGranted('ROLE_CA')) {
            $grant = true;
        }

        return $grant;
    }

    public function grantAccountOwner(AccountOwner $accountOwner) {

        $grant = false;
        if ($this->authorizationChecker->isGranted('ROLE_RS')) {
            $grant = true;
        }
        elseif ($this->authorizationChecker->isGranted('ROLE_RCA')) {
            $grant = true;
        }
        elseif ($this->authorizationChecker->isGranted('ROLE_CA')) {
            $grant = true;
        }

        return $grant;
    }

    public function grantCampaignMailing(CampaignMailing $campaignMailing) {

        $grant = false;
        if ($this->authorizationChecker->isGranted('ROLE_RS')) {
            $grant = true;
        }
        elseif ($this->authorizationChecker->isGranted('ROLE_RCA')) {
            $agency = $this->userManager->getCurrent()->getAgency();
            foreach($campaignMailing->getOwner()->getAgencies() as $histoAgence) {
                if ($agency == $histoAgence->getAgency()) {
                    if ($histoAgence->getDateCreated() <= $campaignMailing->getDateCreated()) {
                        if ($histoAgence->getEnd()) {
                            if ($histoAgence->getEnd()->getDateEnd() > $campaignMailing->getDateCreated()) {
                                $grant = true;
                            }
                        } else
                            $grant = true;
                    }
                }
            }
        }
        elseif ($this->authorizationChecker->isGranted('ROLE_CA')) {
            $agency = $this->userManager->getCurrent()->getAgency();
            foreach($campaignMailing->getOwner()->getAgencies() as $histoAgence) {
                if ($agency == $histoAgence->getAgency()) {
                    if ($histoAgence->getDateCreated() <= $campaignMailing->getDateCreated()) {
                        if ($histoAgence->getEnd() == null)
                            $grant = true;
                    }
                }
            }
            if ($grant) {
                $grant = false;
                if ($campaignMailing->getOwner() == $this->userManager->getCurrent())
                    $grant = true;
            }
        }

        return $grant;
    }

    public function grantCampaignFaxing(CampaignFaxing $campaignFaxing) {

        $grant = false;
        if ($this->authorizationChecker->isGranted('ROLE_RS')) {
            $grant = true;
        }
        elseif ($this->authorizationChecker->isGranted('ROLE_RCA')) {
            $agency = $this->userManager->getCurrent()->getAgency();
            foreach($campaignFaxing->getOwner()->getAgencies() as $histoAgence) {
                if ($agency == $histoAgence->getAgency()) {
                    if ($histoAgence->getDateCreated() <= $campaignFaxing->getDateCreated()) {
                        if ($histoAgence->getEnd()) {
                            if ($histoAgence->getEnd()->getDateEnd() > $campaignFaxing->getDateCreated()) {
                                $grant = true;
                            }
                        } else
                            $grant = true;
                    }
                }
            }
        }
        elseif ($this->authorizationChecker->isGranted('ROLE_CA')) {
            $agency = $this->userManager->getCurrent()->getAgency();
            foreach($campaignFaxing->getOwner()->getAgencies() as $histoAgence) {
                if ($agency == $histoAgence->getAgency()) {
                    if ($histoAgence->getDateCreated() <= $campaignFaxing->getDateCreated()) {
                        if ($histoAgence->getEnd() == null)
                            $grant = true;
                    }
                }
            }
            if ($grant) {
                $grant = false;
                if ($campaignFaxing->getOwner() == $this->userManager->getCurrent())
                    $grant = true;
            }
        }

        return $grant;
    }

}
