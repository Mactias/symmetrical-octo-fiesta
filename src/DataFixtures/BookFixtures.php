<?php

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BookFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        /* $book = new Book(); */
        /* $book->setTitle(""); */
        /* $book->setAuthor(""); */
        /* $book->setPublisher(''); */
        /* $book->setPublicationYear(''); */
        /* $book->setSubject([]); */
        /* $book->setISBN(''); */

        /* $manager->persist($book); */

        $book = new Book();
        $book->setTitle("Kongres futurologiczny ; Opowiadania Ijona Tichego / Stanisław Lem.");
        $book->setAuthor("Lem, Stanisław (1921-2006)");
        $book->setPublisher('Warszawa : Agora');
        $book->setPublicationYear('2008');
        $book->setGenre(['Opowiadania i nowele',]);
        $book->setISBN('9788375525048');
        $book->setLoan(0);

        $manager->persist($book);

        $book = new Book();
        $book->setTitle("Solaris / Stanisław Lem.");
        $book->setAuthor("Lem, Stanisław (1921-2006)");
        $book->setPublisher('Warszawa : Agora');
        $book->setPublicationYear('2009');
        $book->setGenre(['Powieść polska',]);
        $book->setISBN('9788375525046');
        $book->setLoan(0);

        $manager->persist($book);

        $book = new Book();
        $book->setTitle("Regionalny Kongres Kultury : raport / [red. Bogdan Sobieszek ; fot. Piotr Miśkiewicz].");
        $book->setAuthor("Sobieszek, Bogdan. Red");
        $book->setPublisher('Łódź : Łódzki Dom Kultury');
        $book->setPublicationYear('2011');
        $book->setSubject(['Kultura Łódź konferencje', 'Instytucje kultury Łódź konferencje',]);
        $book->setLoan(0);

        $manager->persist($book);

        $book = new Book();
        $book->setTitle("Wprowadzenie do ekonomii / Jerzy Woś.");
        $book->setAuthor("Woś, Jerzy");
        $book->setPublisher('Poznań : Wydaw. Wyższej Szkoły Bankowej');
        $book->setPublicationYear('1998');
        $book->setSubject(['Ekonomia',]);
        $book->setGenre(['Podręczniki',]);
        $book->setISBN('8372060327');
        $book->setLoan(0);

        $manager->persist($book);

        $book = new Book();
        $book->setTitle("Ekonomia : zarys problematyki / Grzegorz Sroślak.");
        $book->setAuthor("Sroślak, Grzegorz.");
        $book->setPublisher('Katowice : "AMR"');
        $book->setPublicationYear('2003');
        $book->setSubject(['Ekonomia',]);
        $book->setGenre(['Podręczniki',]);
        $book->setISBN('8390976142');
        $book->setLoan(0);

        $manager->persist($book);

        $book = new Book();
        $book->setTitle("Podręcznik samodzielnej nauki księgowania / Barbara Gierusz.");
        $book->setAuthor("Gierusz, Barbara (1952- )");
        $book->setPublisher('Gdańsk : Ośr. Doradztwa i Doskonalenia Kadr');
        $book->setPublicationYear('2005');
        $book->setSubject(['Rachunkowość',]);
        $book->setGenre(['Podręczniki',]);
        $book->setISBN('8374261957');
        $book->setLoan(0);

        $manager->persist($book);

        $book = new Book();
        $book->setTitle("Business intelligence : systemy wspomagania decyzji biznesowych / Jerzy Surma.");
        $book->setAuthor("Surma, Jerzy.");
        $book->setPublisher('Warszawa : Wydawnictwo Naukowe PWN.');
        $book->setPublicationYear('2009');
        $book->setSubject(['Business Intelligence', 'Decyzje gospodarka', 'Inteligencja sztuczna stosowanie', 'Systemy informatyczne zarządzania']);
        $book->setLoan(0);

        $manager->persist($book);

        $manager->flush();
        $manager->clear(Book::class);
    }
}
