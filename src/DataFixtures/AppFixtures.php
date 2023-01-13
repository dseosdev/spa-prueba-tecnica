<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Schedule;
use App\Entity\SpaService;
use Doctrine\Persistence\ObjectManager;
use Gedmo\Translatable\Entity\Translation;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function __construct()
    {
        
    }

    public function load(ObjectManager $manager): void
    {
        $translator = $manager->getRepository(Translation::class);
        $spaServices= $this->getData();
        
        foreach ($spaServices as $spaServiceData){
            $spaService = new SpaService();
            $spaService->setName($spaServiceData['name']);
            $spaService->setPrice($spaServiceData['price']) ;
            $manager->persist ($spaService);

            foreach ($spaServiceData['lang'] as $spaServiceLang=>$spaServiceName){
                $translator->translate($spaService, 'name', $spaServiceLang, $spaServiceName);
            }

            foreach ($spaServiceData['schedule'] as $spaServiceSchedule){
                $schedule = new Schedule();
                $schedule->setDay($spaServiceSchedule['day']);
                $schedule->setStartHour($spaServiceSchedule['startHour']);
                $schedule->setEndHour($spaServiceSchedule['endHour']);
                $schedule->setSpaService($spaService);
                $manager->persist ($schedule);
            }
        }
        $manager->flush();
    }

    private function getData(){
        $spaServices = [];
        $spaServices[1]['name'] = 'Masaje de espalda';
        $spaServices[1]['price'] = '30.00';
        $spaServices[1]['lang']['en'] = 'Back massage';
        $spaServices[1]['lang']['de'] = 'Antwort';
        $spaServices[1]['lang']['fr'] = 'Massage du dos';
        $spaServices[1]['schedule'][1]['day'] = new DateTime('2023/01/01');
        $spaServices[1]['schedule'][1]['startHour'] = new DateTime('10:00');
        $spaServices[1]['schedule'][1]['endHour'] = new DateTime('13:00');
        $spaServices[1]['schedule'][2]['day'] = new DateTime('2023/01/02');
        $spaServices[1]['schedule'][2]['startHour'] = new DateTime('11:00');
        $spaServices[1]['schedule'][2]['endHour'] = new DateTime('14:00');

        $spaServices[2]['name'] = 'Circuito Spa';
        $spaServices[2]['price'] = '100.00';
        $spaServices[2]['lang']['en'] = 'Spa circuit';
        $spaServices[2]['lang']['de'] = 'Spa-Zirkel';
        $spaServices[2]['lang']['fr'] = 'Circuit thermal';
        $spaServices[2]['schedule'][1]['day'] = new DateTime('2023/01/01');
        $spaServices[2]['schedule'][1]['startHour'] = new DateTime('9:00');
        $spaServices[2]['schedule'][1]['endHour'] = new DateTime('14:00');
        $spaServices[2]['schedule'][2]['day'] = new DateTime('2023/01/02');
        $spaServices[2]['schedule'][2]['startHour'] = new DateTime('14:00');
        $spaServices[2]['schedule'][2]['endHour'] = new DateTime('20:00');

        $spaServices[3]['name'] = 'Ritual spa tailandés';
        $spaServices[3]['price'] = '120.00';
        $spaServices[3]['lang']['en'] = 'Ritual Thai Massage';
        $spaServices[3]['lang']['de'] = 'Ritual Spa Thail';
        $spaServices[3]['lang']['fr'] = 'rituel spa thaï';
        $spaServices[3]['schedule'][1]['day'] = new DateTime('2023/01/01');
        $spaServices[3]['schedule'][1]['startHour'] = new DateTime('15:00');
        $spaServices[3]['schedule'][1]['endHour'] = new DateTime('21:00');
        $spaServices[3]['schedule'][2]['day'] = new DateTime('2023/01/02');
        $spaServices[3]['schedule'][2]['startHour'] = new DateTime('15:00');
        $spaServices[3]['schedule'][2]['endHour'] = new DateTime('22:00');

        return $spaServices;
    }
}
