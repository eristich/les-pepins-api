<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Theme;
use App\Entity\Question;
use App\Entity\Answer;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Création des thèmes
        $themesData = [
            'Alimentation',
            'Transport',
            'Habitation'
        ];
        
        $themes = [];
        foreach ($themesData as $themeName) {
            $theme = new Theme();
            $theme->setName($themeName);
            $manager->persist($theme);
            $themes[] = $theme;
        }

        // Création des questions
        $questionsData = [
            ['Combien de repas contenant de la viande ou du poisson consommez-vous par semaine en moyenne ?', 0],
            ['Quel pourcentage de vos aliments provient de circuits courts ou locaux ?', 0],
            ['Quelle quantité de produits transformés consommez-vous ?', 0],
            ['Achetez-vous des aliments bio ou issus de l’agriculture durable ?', 0],
            ['Quelle est votre quantité annuelle de gaspillage alimentaire estimée ?', 0],
            ['Quelle est la distance annuelle totale parcourue en voiture individuelle ?', 1],
            ['Utilisez-vous régulièrement les transports en commun (bus, métro, train) ?', 1],
            ['Combien de fois prenez-vous l’avion par an pour des trajets courts (< 1 500 km) ?', 1],
            ['Combien de fois prenez-vous l’avion par an pour des trajets longs (> 1 500 km) ?', 1],
            ['Possédez-vous un véhicule électrique ou hybride ?', 1],
            ['Quelle est la surface habitable de votre logement ?', 2],
            ['Quel est le principal mode de chauffage de votre logement ?', 2],
            ['Quelle est votre consommation annuelle d’électricité ?', 2],
            ['Avez-vous pris des mesures pour améliorer l’isolation de votre logement ?', 2],
            ['Quel pourcentage de vos déchets est recyclé ou composté ?', 2],
        ];
        
        $questions = [];
        foreach ($questionsData as [$questionText, $themeIndex]) {
            $question = new Question();
            $question->setName($questionText);
            $question->setTheme($themes[$themeIndex]);
            $manager->persist($question);
            $questions[] = $question;
        }
        
        // Création des réponses avec les valeurs spécifiques du fichier SQL
        $answersData = [
            // Alimentation
            ['0 repas', 0, 0], ['1-3 repas', 200, 0], ['4-7 repas', 500, 0], ['Plus de 7 repas', 800, 0],
            ['Plus de 75 %', 50, 1], ['Entre 50 % et 75 %', 100, 1], ['Entre 25 % et 50 %', 200, 1], ['Moins de 25 %', 400, 1],
            ['Aucune', 50, 2], ['Faible', 150, 2], ['Moyenne', 300, 2], ['Élevée', 500, 2],
            ['Oui, exclusivement', 50, 3], ['Oui, en majorité', 150, 3], ['Peu', 300, 3], ['Pas du tout', 500, 3],
            ['Moins de 10 kg', 50, 4], ['10-30 kg', 150, 4], ['30-50 kg', 300, 4], ['Plus de 50 kg', 500, 4],
            // Transport
            ['Moins de 5 000 km', 50, 5], ['5 000-10 000 km', 150, 5], ['10 000-20 000 km', 300, 5], ['Plus de 20 000 km', 500, 5],
            ['Jamais', 50, 6], ['Rarement', 150, 6], ['Souvent', 300, 6], ['Tous les jours', 500, 6],
            ['Jamais', 50, 7], ['1-2 fois', 150, 7], ['3-5 fois', 300, 7], ['Plus de 5 fois', 500, 7],
            ['Jamais', 50, 8], ['1-2 fois', 150, 8], ['3-5 fois', 300, 8], ['Plus de 5 fois', 500, 8],
            ['Non', 500, 9], ['Oui, hybride', 300, 9], ['Oui, électrique', 150, 9], ['Oui, 100% renouvelable', 50, 9],
            // Habitation
            ['Moins de 50 m²', 50, 10], ['50-100 m²', 150, 10], ['100-150 m²', 300, 10], ['Plus de 150 m²', 500, 10],
            ['Électricité', 500, 11], ['Gaz', 300, 11], ['Bois/Pellets', 150, 11], ['Énergies renouvelables', 50, 11],
            ['Moins de 1 000 kWh', 50, 12], ['1 000-5 000 kWh', 150, 12], ['5 000-10 000 kWh', 300, 12], ['Plus de 10 000 kWh', 500, 12],
            ['Aucune mesure', 500, 13], ['Quelques améliorations', 300, 13], ['Bonne isolation', 150, 13], ['Isolation optimale', 50, 13],
            ['Moins de 25 %', 500, 14], ['25-50 %', 300, 14], ['50-75 %', 150, 14], ['Plus de 75 %', 50, 14],
        ];
        
        foreach ($answersData as [$answerText, $weight, $questionIndex]) {
            $answer = new Answer();
            $answer->setName($answerText);
            $answer->setWeight($weight);
            $answer->setQuestion($questions[$questionIndex]);
            $manager->persist($answer);
        }
        
        $manager->flush();
    }
}
