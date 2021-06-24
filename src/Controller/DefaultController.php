<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\User;
use App\Form\BookType;
use App\Repository\BookRepository;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(BookType $bookType): Response
    {
        $form = $this->createFormSearch('search');

        return $this->render('default/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/search", name="search")
     */
    public function search(Request $request, BookRepository $bookRepo): Response
    {
        $form = $this->createFormSearch('search');

        $books = [];

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $data['search'] = strtolower($data['search']);

            if ($data['findby'] === 'all') {
                $books = $bookRepo->findByAllFields($data['search']);
            } else {
                $books = $bookRepo->findBySomeField($data['findby'], $data['search']);
            }
        }

        return $this->render('default/search.html.twig', [
            'form' => $form->createView(),
            'books' => $books,
        ]);
    }


    /**
     * @Route("/adv-search", name="advanced_search")
     */
    public function advancedSearch(Request $request, BookRepository $bookRepo): Response
    {
        $choices = [
            'title' => 'title',
            'author' => 'author',
            'subject' => 'subject',
            'publisher' => 'publisher',
            'ISBN' => 'isbn',
        ];

        $logic = [
            'and' => 'LIKE',
            'or' => 'OR',
            'not' => 'NOT LIKE',
        ];

        $form = $this->createFormBuilder()
            ->setMethod('GET')
            ->add('search1', TextType::class, [
                'label' => ' ',
                'attr' => ['minlength' => 3, 'id' => 'search-input', 'class' => 'tinymce'],
                'row_attr' => ['class' => 'set-grid'],
            ])
            ->add('findby1', ChoiceType::class, [
                'label' => 'Find By',
                'choices' => $choices,
                'row_attr' => ['class' => 'none'],
            ])
            ->add('logic1', ChoiceType::class, [
                'label' => ' ',
                'choices' => $logic,
                'row_attr' => ['class' => 'set-grid'],
            ])
            ->add('search2', TextType::class, [
                'required' => false,
                'label' => ' ',
                'attr' => ['minlength' => 3],
                'row_attr' => ['class' => 'set-grid'],
            ])
            ->add('findby2', ChoiceType::class, [
                'label' => 'Find By',
                'choices' => $choices,
                'row_attr' => ['class' => 'none'],
            ])
            ->add('logic2', ChoiceType::class, [
                'label' => ' ',
                'choices' => $logic,
                'row_attr' => ['class' => 'set-grid'],
            ])
            ->add('search3', TextType::class, [
                'required' => false,
                'label' => ' ',
                'attr' => ['minlength' => 3],
                'row_attr' => ['class' => 'set-grid'],
            ])
            ->add('findby3', ChoiceType::class, [
                'label' => 'Find By',
                'choices' => $choices,
                'row_attr' => ['class' => 'none'],
            ])
            ->add('logic3', ChoiceType::class, [
                'label' => ' ',
                'choices' => $logic,
                'row_attr' => ['class' => 'set-grid'],
            ])
            ->add('search4', TextType::class, [
                'required' => false,
                'label' => ' ',
                'attr' => ['minlength' => 3],
                'row_attr' => ['class' => 'set-grid'],
            ])
            ->add('findby4', ChoiceType::class, [
                'label' => 'Find By',
                'choices' => $choices,
                'row_attr' => ['class' => 'none'],
            ])
            ->add('submit', SubmitType::class, ['label' => 'Search'])
            ->getForm();

        $books = [];

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $data['search1'] = strtolower($data['search1']);
            $data['search2'] = strtolower($data['search2']);
            $data['search3'] = strtolower($data['search3']);
            $data['search4'] = strtolower($data['search4']);

            $books = $bookRepo->advancedFieldsSearch($data);
        }

        return $this->render('default/advanced_search.html.twig', [
            'form' => $form->createView(),
            'books' => $books,
        ]);
    }
    
    /**
     * @Route("/resend-email", name="resendEmail")
     */
    public function resendEmail(EmailVerifier $emailVerifier): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if ($this->getUser()->isVerified()) {
            $this->redirectToRoute('profile');
        }
        $emailVerifier->sendEmailConfirmation(
            'app_verify_email',
            $this->getUser(),
            (new TemplatedEmail())
                ->from(new Address('grimi02@gmail.com', '"Biblioteczka Mail Confirmation"'))
                ->to($this->getUser()->getEmail())
                ->subject('Please Confirm your Email')
                ->htmlTemplate('registration/confirmation_email.html.twig')
        );

        $this->addFlash('success', 'Email was sending.');
        return $this->redirectToRoute('profile');
    }

    /**
     * @Route("/book/{slug}", name="show_book")
     */
    public function showBook($slug, BookRepository $bookRepo, Request $request): Response
    {
        $book = $bookRepo->find($slug);

        $referer = $request->server->get('HTTP_REFERER');

        if ($this->getUser() && str_contains($referer, 'search?form%')) {
            $session = $request->getSession();
            $session->set('form_url', $referer);
        } elseif ($this->getUser() && str_contains($referer, '/loan/'.$slug)) {
            $session = $request->getSession();
            $referer = $session->get('form_url');
        } elseif ($this->getUser()) {
            $session = $request->getSession();
            $referer = $this->generateUrl('search');
            $session->set('form_url', $referer);
        } elseif (!$this->getUser() && !str_contains($referer, 'search?form%')) {
            $referer = $this->generateUrl('search');
        }

        return $this->render('book/show.html.twig', [
            'book' => $book,
            'referer' => $referer,
        ]);
    }

    /**
     * @Route("/loan/{slug}", name="loan")
     */
    public function loan(int $slug, BookRepository $bookRepo, Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');
        if (!$this->getUser()->isVerified()) {
            throw $this->createAccessDeniedException();
        }

        $book = $bookRepo->find($slug);
        if ($book->getLoan() == 1 || $book->getLoan() == 2) {
            throw $this->createAccessDeniedException('Access Denied. This book was loaned.');
        }

        $form = $this->createFormBuilder()
                    ->add('submit', SubmitType::class, ['label' => 'yes'])
                    ->getForm();
                    
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $book->setLoan(Book::HOLD);
            $book->setLoanedBy($user);

            $nextMonth = date(
                'd-m-Y',
                mktime(0, 0, 0, date('m')+1, date('d'), date('Y'))
            );
            $book->setReturnDate(new \DateTime($nextMonth));

            $em = $this->getDoctrine()->getManager();
            $em->persist($book);
            $em->flush();
            $em->clear(Book::class);

            return $this->redirectToRoute('profile');
        }

        return $this->render('book/loan.html.twig', [
            'book' => $book,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/profile", name="profile")
     */
    public function profile(Request $request, UserRepository $userRepo): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

        return $this->render('default/profile.html.twig');
    }
    
    /**
     * @Route("/profile/edit", name="edit_user")
     */
    public function editUser(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();

        $form = $this->createFormBuilder($user)
                    ->add('Forename', TextType::class)
                    ->add('Surname', TextType::class)
                    ->add('Email', EmailType::class)
                    ->add('PlaceOfBirth', TextType::class)
                    ->add('DateOfBirth', DateType::class, ['widget' => 'single_text',])
                    ->add('PESEL', TextType::class, [
                        'attr' => ['maxlength' => 11,]
                    ])
                    ->add('Submit', SubmitType::class)
                    ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($form->getData());
            $em->flush();

            $this->addFlash('success', 'Your settings was updated');
            return $this->redirectToRoute('profile');
        }

        return $this->render('default/edit_user.html.twig', ['form' => $form->createView(),]);
    }

    /**
     * @Route("/profile/password", name="change_password")
     */
    public function changePassword(Request $request, UserPasswordHasherInterface $hasher): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $form = $this->createFormBuilder()
                    ->add('Password', RepeatedType::class, [
                        'type' => PasswordType::class,
                        'invalid_message' => 'The password fields must match.',
                        'options' => ['attr' => ['minlength' => 6, 'maxlength' => 250]],
                        'required' => true,
                        'first_options'  => ['label' => 'Password'],
                        'second_options' => ['label' => 'Repeat'],
                        'error_bubbling' => true,
                    ])
                    ->add('Submit', SubmitType::class)
                    ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $validator = Validation::createValidator();

            $data = $form->getData();
            $constraint = new Assert\Collection([
                'Password' => [
                    new Assert\Regex(['pattern' => "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,}$/"], 'Password should be a minimum of 6 characters, contains at least one number, one lowercase character, one uppercase character', $normalizer = 'trim')
                ],
            ]);
            $violations = $validator->validate($data, $constraint);

            if ($violations->count() === 0) {
                $user = $this->getUser();
                $user->setPassword($hasher->hashPassword($user, $data['Password']));

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                $em->clear(User::class);

                $this->addFlash('success', 'Your password was changed.');

                return $this->redirectToRoute('profile');
            }

            $this->addFlash('error', $violations->get(0)->getMessage());
        }

        return $this->render('/default/change_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function createFormSearch($actionUrl): Form
    {
        $form = $this->createFormBuilder()
            ->setMethod('GET')
            ->setAction($this->generateUrl($actionUrl))
            ->add('search', TextType::class, [
                'label' => ' ',
                'attr' => ['minlength' => 3],
            ])
            ->add('findby', ChoiceType::class, [
                'label' => 'Find By',
                'choices' => [
                    'all fields' => 'all',
                    'title' => 'title',
                    'author' => 'author',
                    'subject' => 'subject',
                    'publisher' => 'publisher',
                    'ISBN' => 'isbn',
                ]
            ])
            ->add('submit', SubmitType::class, ['label' => 'Search'])
            ->getForm();

        return $form;
    }
}
