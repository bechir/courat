<?php

/*
 * This file is part of the COURAT application.
 *
 * (c) Bechir Ba and contributors
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\DataFixtures;

use App\Entity\Info;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class InfoFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->getData() as [$createdAt, $titleAr, $title, $url, $imgPath]) {
            $info = (new Info())
                ->setCreatedAt(\DateTime::createFromFormat('d/m/Y H:i', $createdAt))
                ->setTitle($title)
                ->setTitleAr($titleAr)
                ->setLink($url)
                ->setFilename($imgPath);

            $manager->persist($info);
        }
        $manager->flush();
    }

    public function getData(): array
    {
        return [
            // Datetime         Title AR      Title           Article url         Image url
            ['01/04/2020 22:30', 'تعويض عن نهاية الدروس بعطل طويلة بترتيب "ممكن" (سيدي ولد سالم)', 'Compenser l\'arrêt des cours par les grandes vacances dans l\'ordre du "possible" (Sidi Ould Salem)', 'http://cridem.org/C_Info.php?article=734478', 'sidi_uld_salem_635_0.jpg'],
            ['27/03/2020 14:10', 'المدرسة العليا للفنون التطبيقية: استمرار الدورات بالرغم من الحبس (نشرة صحفية)', 'Ecole Supérieure Polytechnique : Poursuite des cours malgré le confinement (communiqué)', 'http://cridem.org/C_Info.php?article=734313', 'ipgei1.jpg'],
            ['22/03/2020 00:30', 'موريتانيا: دورات علاجية في التلفزيون الرسمي ابتداءً من 23 مارس', 'Mauritanie : des cours de rattrapage dispensés sur la télévision officielle dès le 23 mars', 'http://cridem.org/C_Info.php?article=733998', 'education_decide_650.jpg'],
            ['20/03/2020 23:30', 'نواذيبو: فتح الحدود للسماح بمرور 134 طالب موريتاني من جامعات مغربية (صور)', 'Nouadhibou: Ouverture des frontières pour laisser passer 134 étudiants mauritaniens venant des universités marocaines (photos)', 'http://cridem.org/C_Info.php?article=734016', 'laisser_passer_etudiants_450.jpg'],
            ['20/03/2020 16:16', 'هل الكتب المدرسية الابتدائية في موريتانيا محررة بشكل جيد؟', 'Les manuels des écoles primaires, en Mauritanie, sont-ils bien édités ?', 'http://cridem.org/C_Info.php?article=733963', 'ecoles_primaires_309WA0002.jpg'],
            ['20/03/2020 09:54', 'موريتانيا: تمديد إغلاق المدارس', 'Mauritanie: prolongation de la fermeture des écoles', 'http://cridem.org/C_Info.php?article=733981', 'ecoles_galets_au_port_1304958.jpg'],
            ['15/03/2020 08:00', 'تغلق موريتانيا المدارس لمدة أسبوع على الأقل', 'La Mauritanie ferme les écoles pour au moins une semaine', 'http://cridem.org/C_Info.php?article=733815', 'ecoles_galets_au_port_1304958.jpg'],
        ];
    }
}
