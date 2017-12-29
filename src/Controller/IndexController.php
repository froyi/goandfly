<?php
declare (strict_types=1);

namespace Project\Controller;

use Project\Module\GenericValueObject\Email;
use Project\Module\GenericValueObject\Id;
use Project\Module\GenericValueObject\Password;
use Project\Module\Reise\ReiseService;
use Project\Utilities\Tools;

/**
 * Class IndexController
 * @package Project\Controller
 */
class IndexController extends DefaultController
{
    public function indexAction(): void
    {
        // News for template
        $this->getNews();

        // TagListe
        $this->getTagListe();

        // Reisen
        $reiseContainer = $this->getReisenContainer();

        $this->generateTeaserBildByReiseContainer($reiseContainer);

        $this->viewRenderer->addViewConfig('page', 'home');
        $this->viewRenderer->renderTemplate();
    }

    public function reiseAction(): void
    {
        $reiseId = Tools::getValue('reiseId');

        if ($reiseId === false) {
            $this->notFoundAction();
        }
        
        $reiseService = new ReiseService($this->database);
        $reise = $reiseService->getCompleteReiseByReiseId(Id::fromString($reiseId));

        if ($reise === null) {
            $this->notFoundAction();
        }

        $this->setTeaserBild($reise);

        $this->viewRenderer->addViewConfig('reise', $reise);


        if ($reise->getRegion() !== null) {
            $reiseRecommenderAmount = $this->configuration->getEntryByName('reise-recommender-offer');
            $reiseRecommender = $reiseService->getReiseRecommenderByReise($reise, $reiseRecommenderAmount);

            if ($reiseRecommender !== null) {
                $this->viewRenderer->addViewConfig('reiseRecommender', $reiseRecommender);
            }
        }

        $this->viewRenderer->addViewConfig('page', 'reise');
        $this->viewRenderer->renderTemplate();
    }

    public function ueberUnsAction(): void
    {
        $this->showStandardPage('ueberUns');
    }

    public function partnerAction(): void
    {
        $this->showStandardPage('partner');
    }

    public function kontaktAction(): void
    {
        $this->showStandardPage('kontakt');
    }

    public function impressumAction(): void
    {
        $this->showStandardPage('impressum');
    }

    public function diamirAction(): void
    {
        $this->showStandardPage('diamir');
    }

    public function loginRedirectAction(): void
    {
        if ($this->loggedInUser === null) {
            $password = Password::fromString(Tools::getValue('password'));
            $email = Email::fromString(Tools::getValue('email'));
            $this->loggedInUser = $this->userService->getLogedInUserByEmailAndPassword($email, $password);
        }

        if ($this->loggedInUser !== null) {
            $this->redirectToLoggedInPage();
        } else {
            $parameter = ['notificationCode' => 'loginError', 'notificationStatus' => 'error'];
            header('Location: ' . Tools::getRouteUrl('login', $parameter));
        }
    }

    public function loginAction(): void
    {
        if ($this->loggedInUser !== null) {
            $this->redirectToLoggedInPage();
        } else {
            $this->showStandardPage('login');
        }
    }

    protected function redirectToLoggedInPage(): void
    {
        header('Location: ' . Tools::getRouteUrl('loggedin'));
    }
}