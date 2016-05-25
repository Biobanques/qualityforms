<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use AppBundle\Form\ContactType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sokil\Mongo\Client;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class SiteController extends Controller
{

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request) {
        return $this->render('default/accueil.html.twig', [
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contactAction(Request $request) {
        $contact = new Contact();
        $form = $this->createFormBuilder($contact)
                ->add('name', TextType::class)
                ->add('email', EmailType::class)
                ->add('subject', TextType::class)
                ->add('body', TextareaType::class, ['attr' => ['rows' => '8']])
                ->add('submit', SubmitType::class, ['label' => 'Send', 'attr' => [
                        'class' => 'btn btn-success'
            ]])
                ->getForm();


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $name = $form->getData()->getName();
            $email = $form->getData()->getEmail();
            $subject = $form->getData()->getSubject();
            $body = $form->getData()->getBody();


            $result = $this->sendMail($name, $email, $subject, $body);
            if ($result >= 1)
                $this->addFlash('success', 'Your message was sent, be sure we will reply in best delay');
            else {
                $this->addFlash('warning', 'An error occured with your message, please try later.');
                $logger = $this->get('logger');
                $logger->log('error', 'error on mail contact system');
            }
            return $this->redirectToRoute('homepage');
        }

        return $this->render('Mail/contact.html.twig', [
                    'form' => $form->createView()
        ]);
    }

    private function sendMail($name, $email, $subject, $body) {
        $mail = Swift_Message::newInstance()
                ->setSubject("QualityForms contact form : $subject")
                ->setFrom('matthieu.penicaud@orange.fr')
                ->setReplyTo([$email => $name])
//                ->setTo('contact@ebiobanques.fr')
                ->setTo('matthieu.penicaud@inserm.fr')
                ->setBody($body)
        ;

        $mailer = $this->get('mailer');

        return $mailer->send($mail);
    }

}