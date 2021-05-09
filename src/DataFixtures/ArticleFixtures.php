<?php

/*
 * This file is part of the COURAT application.
 *
 * (c) NEOTIC and contributors
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->getData() as [$createdAt, $titleAr, $title, $url, $imgPath]) {
            $article = (new Article())
                ->setCreatedAt(\DateTime::createFromFormat('d/m/Y H:i', $createdAt))
                ->setTitle($title)
                ->setTitleAr($titleAr)
                ->setLink($url)
                ->setFilename($imgPath);

            $manager->persist($article);
        }
        $manager->flush();
    }

    public function getData(): array
    {
        return [
            // Datetime         Title AR      Title           Article url         Image url
            ['02/04/2020 07:45', 'سنة بيضاء ستكون كارثة مالية للدولة وخسارة للجيل الشاب (وزير)', 'Une année blanche sera une catastrophe financière pour l’Etat et une perte pour la jeune génération (Ministre)', 'http://cridem.org/C_Info.php?article=734479', 'sidisalim.jpg'],
            ['02/04/2020 09:30', 'تمديد تعليق الدروس المدرسية', 'Prolongation de la suspension des cours scolaires', 'http://fr.ami.mr/Depeche-53106.html', 'sidisalim.jpg'],
            ['01/04/2020 22:30', 'تعويض عن نهاية الدروس بعطل طويلة بترتيب "ممكن" (سيدي ولد سالم)', 'Compenser l\'arrêt des cours par les grandes vacances dans l\'ordre du "possible" (Sidi Ould Salem)', 'http://cridem.org/C_Info.php?article=734478', 'sidisalim.jpg'],
            ['27/03/2020 14:10', 'المدرسة العليا للفنون التطبيقية: استمرار الدورات بالرغم من الحبس (نشرة صحفية)', 'Ecole Supérieure Polytechnique : Poursuite des cours malgré le confinement (communiqué)', 'http://cridem.org/C_Info.php?article=734313', '24414hr_-592x296.jpg'],
            ['22/03/2020 00:30', 'موريتانيا: دورات علاجية في التلفزيون الرسمي ابتداءً من 23 مارس', 'Mauritanie : des cours de rattrapage dispensés sur la télévision officielle dès le 23 mars', 'http://cridem.org/C_Info.php?article=733998', 'arton7-51838.jpg'],
            ['20/03/2020 09:54', 'موريتانيا: تمديد إغلاق المدارس', 'Mauritanie: prolongation de la fermeture des écoles', 'http://cridem.org/C_Info.php?article=733981', 'theodore-monod-nouakchott-facade.jpg'],
            ['15/03/2020 08:00', 'تغلق موريتانيا المدارس لمدة أسبوع على الأقل', 'La Mauritanie ferme les écoles pour au moins une semaine', 'http://cridem.org/C_Info.php?article=733815', 'theodore-monod-nouakchott-facade.jpg'],
        ];
    }
}
