<?php

namespace Enigmatic\CRMBundle\Services;

use Enigmatic\CRMBundle\Entity\Account;
use Enigmatic\CRMBundle\Manager\AccountManager;
use Enigmatic\CRMBundle\Manager\UserManager;

class AccountService
{
    protected $accountManager;
    protected $userManager;

    /**
     * Constructor
     */
    public function __construct(AccountManager $accountManager, UserManager $userManager)
    {
        $this->accountManager = $accountManager;
        $this->userManager = $userManager;
    }

    public function generateLinkDuplicate($form) {
        $data = $form->getData();

        if ($this->userManager->getCurrent()) {
            $_agency = $this->userManager->getCurrent()->getAgency();
            $account = $this->accountManager->getByNameAndCity($data->getName(), $data->getCity());

            if ($account instanceof Account) {
                foreach ($account->getAgencies() as $agency) {
                    if ($agency == $_agency)
                        return false;
                }
                return array(
                    'account' => $account->getId(),
                    'md5' => md5($data->getName() . $data->getCity()->getId())
                );
            }
            else
                return false;
        }
        return false;
    }

    public function checkLinkDuplicate(Account $account, $md5) {
        if ($md5 == md5($account->getName().$account->getCity()->getId()))
            return true;
        else
            return false;
    }
}
