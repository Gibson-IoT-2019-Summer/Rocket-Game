<?php
namespace App\Controller;
use Slim\Container;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use PHPMailer\PHPMailer\PHPMailer;

/**
 *  UserController handles user related procedures
 *  - Sign-Up
 *  - Sign-In
 *  - Sign-Out
 *  - Password change
 *  - Forgotten password update
 *  - ID cancellation
 *
 *  Dependency
 *  - NonceController (Sign-Up, Forgotten password update)
 */
final class UserController extends BaseController
{
    protected $userModel;

    function __construct(Container $c)
    {
        parent::__construct($c);
        $this->userModel = $c->get('UserModel');
    }

    // ********** Sign-Up **********

    /**
     * Sign-Up procedure entry callback
     * See ./app/src/routers.php
     */
    public function routeSignUp(Request $request, Response $response, $args)
    {
        // Passed by HTML form
        $parsed = $request->getParsedBody();
        $email = $parsed['email'];
        $password = $parsed['password'];
        $firstName = $parsed['first-name'];
        $lastName = $parsed['last-name'];
        // ~

        // Passed by redirect
        $params = $request->getParams();
        $modalMsg = $params['modal_msg'];
        // ~

        $this->view->render($response, 'sign-up.twig', [
            'modal_msg' => $modalMsg
        ]);

        return $response;
    }

    /**
     * Sign-Up procedure handle callback
     * See ./app/src/routers.php
     */
    public function handleSignUp(Request $request, Response $response, $args)
    {
        $parsed = $request->getParsedBody();
        
        // Sign-Up user infomation passed by html post(form)
        $email = $parsed['email'];
        $password = $parsed['password'];
        $firstName = $parsed['first-name'];
        $lastName = $parsed['last-name'];
        // ~
        
        // Email, Passeord check using Regex 
        $emailPattern = "/(?=^.{5,64}$)[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+/";
        $passPattern = "/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[`~!@#$%^&*()\-_=+;:,.<>?]).{8,32}$/";
        $isEmailMatch = preg_match($emailPattern, $email);
        $isPassMatch = preg_match($passPattern, $password);
        // ~
        
        if(!($isEmailMatch && $isPassMatch))
        {
            // [ErrCode 1] SAP:SGU-ADU (Incorrect email/password format)
            return $response->withRedirect($this->router->pathFor('signup_route', [], [
                'modal_msg' => 'Incorrect email/password format.'
            ]));
        }

        $outUser = null;
        if($this->userModel->tryGetUserRecordByEmail($email, $outUser))
        {
            // [ErrCode 2] SAP:SGU-ADU (Already exist email)
            return $response->withRedirect($this->router->pathFor('signup_route', [], [
                'modal_msg' => 'Email already exist.'
            ]));
        }

        $hashedPass = password_hash($password, PASSWORD_DEFAULT);
        $authNonce = $this->createNonce(32);

        $this->userModel->addUser($email, $hashedPass, $authNonce, $firstName, $lastName);
        $this->sendSignUpAuthEMail($email, $authNonce);

        // SAP:SGU-ADU Success 
        $this->view->render($response, 'sign-up-email-notify.twig', [
            'email' => $email
        ]);
        return $response;
    }


    public function routeSignUpAuth(Request $request, Response $response, $args)
    {
        echo $args['nonce'];
        return $response;
    }

    // ********** Sign-In **********

    /**
     * Sign-In procedure entry callback
     * See ./app/src/routers.php
     */
    public function routeSignIn(Request $request, Response $response, $args)
    {
        $this->view->render($response, 'sign-in.twig');
        return $response;
    }

    /**
     * Sign-In procedure handle callback
     * See ./app/src/routers.php
     */
    public function handleSignIn(Request $request, Response $response, $args)
    {
        echo "Sign-In handle";
        return $response;
    }

    // ********** Sign-In **********

    /**
     * Sign-Out procedure entry callback
     * See ./app/src/routers.php
     */
    public function routeSignOut(Request $request, Response $response, $args)
    {
        echo "Sign-Out";
        return $response;
    }

    /**
     * Sign-Out procedure handle callback
     * See ./app/src/routers.php
     */
    public function handleSignOut(Request $request, Response $response, $args)
    {
        echo "Sign-Out handle";
        return $response;
    }

    // ********** Password change **********

    /**
     * Password change procedure entry callback
     * See ./app/src/routers.php
     */
    public function routePasswordChange(Request $request, Response $response, $args)
    {
        $this->view->render($response, 'password-change.twig');
        return $response;
    }

    /**
     * Password change procedure handle callback
     * See ./app/src/routers.php
     */
    public function handlePasswordChange(Request $request, Response $response, $args)
    {
        echo "Password change handle";
        return $response;
    }

    // ********** Forgotten password update **********

    /**
     * Forgotten password update procedure entry callback
     * See ./app/src/routers.php
     */
    public function routeForgottenPasswordUpdate(Request $request, Response $response, $args)
    {
        $this->view->render($response, 'password-forgot.twig');
        return $response;
    }

    /**
     * Forgotten password update procedure handle callback
     * See ./app/src/routers.php
     */
    public function handleForgottenPasswordUpdate(Request $request, Response $response, $args)
    {
        echo "Forgotten password update handle";
        return $response;
    }

    // ********** ID cancellation **********

    /**
     * Id cancellation procedure entry callback
     * See ./app/src/routers.php
     */
    public function routeIdCancellation(Request $request, Response $response, $args)
    {
        echo "Id cancellation";
        $this->view->render($response, 'id-cancelation.twig');
        return $response;
    }

    /**
     * Id cancellation procedure handle callback
     * See ./app/src/routers.php
     */
    public function handleIdCancellation(Request $request, Response $response, $args)
    {
        echo "Id cancellation handle";
        return $response;
    }

    public function sendSignUpAuthEMail($sendTo, $nonce)
    {
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        $mail->Username = "qi2019groupb@gmail.com";
        $mail->Password = "qi2019groupbpw";

        $mail->setFrom("salusfrom@dontreply.com");
        $mail->addReplyTo("salusreply@dontreply.com");
        $mail->addAddress($sendTo);
        $mail->isHTML(true);
        
        $mail->Subject = "SALUS sign-up email";
        $mail->Body = $this->view->fetch('sign-up-email.twig', ['nonce' => $nonce]);

        if(!$mail->send())
            echo $mail->ErrorInfo;
    }

    private function createNonce($len)
    {
        $candidates = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
        $candidateCount = strlen($candidates);
        $genStr = "";

        for ($i = 0; $i < $len; $i++) 
        {
            $rand = rand(0, $candidateCount - 1);
            $genStr .= $candidates[$rand];
        }

        return $genStr;
    }

    public function home(Request $request, Response $response, $args)
    {
        $this->view->render($response, 'index.twig');
        return $response;
    }
}
