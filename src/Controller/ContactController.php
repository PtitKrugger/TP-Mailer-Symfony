<?php

namespace App\Controller;

use App\DTO\ContactDTO;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $data = new ContactDTO();

        $data->email = 'test@test.fr';
        $data->nom = 'John Doe';
        $data->message = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s';

        $form = $this->createForm(ContactType::class, $data);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mail = $data->email;
            $nom = $data->nom;
            $message = $data->message;

            $email = (new TemplatedEmail())
                        ->to($data->service)
                        ->from(new Address($mail))
                        ->subject('Demande de contact')
                        ->htmlTemplate('emails/contact.html.twig')
                        ->context(['data' => $data]);


            try {
                $mailer->send($email);
            }
            catch (\Exception $exception) {
                $this->addFlash('Fail', "Impossible d'envoyer un email");
            }
            $this->addFlash('Success', 'Message envoyé');
            $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form
        ]);
    }
}
