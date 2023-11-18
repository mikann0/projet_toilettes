<?php

namespace App\Security;

use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\HttpFoundation\Session\FlashBagAwareSessionInterface;

class CustomAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    public function __construct(private UrlGeneratorInterface $urlGenerator,
        private EntityManagerInterface $entityManager,
        private TokenStorageInterface $tokenStorage)
    {
    }

    public function authenticate(Request $request): Passport
    {
        $email = $request->request->get('email', '');

        $request->getSession()->set(Security::LAST_USERNAME, $email);

        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($request->request->get('password', '')),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        if ($token !== null) {
            $utilisateur = $token->getUser();
            if ($utilisateur instanceof Utilisateur) {
                // User is verified, so he can login.
                if($utilisateur->isVerified()) {
                    // Save he's last login date.
                    $utilisateur->setLastLogin(new \DateTime());
                    $this->entityManager->flush();
                    return new RedirectResponse($this->urlGenerator->generate('app_utilisateur_accueil'));
                } else {
                    $session = $request->getSession();
                    $session->invalidate();
                    $this->tokenStorage->setToken(null);
                    if($session instanceof FlashBagAwareSessionInterface) {
                        $session->getFlashBag()->add(
                            "error",
                            "Cliquez sur le lien de vérification ou bien créez un nouveau mot de passe !"
                        );
                    }
                    return new RedirectResponse($this->urlGenerator->generate('app_accueil'));
                }
            }
        }
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
