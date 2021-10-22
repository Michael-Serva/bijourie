<?php

namespace App\Service;

class DateBart
{





    public function langues($choix)
    {

        $langues = [


            "de" => [
                "pays" => "de",
                "mois" => ["januar","februar","märz","april","mai","juni","juli","august","september","oktober","november","dezember"],
                "heures" => ["stunde","stunde"],
                "midi" => "mittag",
                "minuit" => "mitternacht",
                "at" => "um",
                "firstDay" => "1",
                "cadran" => ["morgen", "nachmittag"]
            ],


            "en" => [
                "pays" => "en",
                "mois" => ["january","february","march","april","may","june","july","august","september","october","november","december"],
                "heures" => ["hour", "hours"],
                "midi" => "midday",
                "minuit" => "midnight",
                "at" => "at",
                "firstDay" => "1<sup>st</sup>",
                "cadran" => ["morning", "afternoon"]
            ],

            "es" => [
                "pays" => "es",
                "mois" => ["enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre"],
                "heures" => ["hora", "hora"],
                "midi" => "mediodía",
                "minuit" => "media noche",
                "at" => "a",
                "firstDay" => "1º",
                "cadran" => ["de la mañana", "de la tarde"],
                "terme" => "de"
            ],

            "fr" => [
                "pays" => "fr",
                "mois" => ["janvier","février","mars","avril","mai","juin","juillet","août","septembre","octobre","novembre","décembre"],
                "heures" => ["heure", "heures"],
                "midi" => "midi",
                "minuit" => "minuit",
                "at" => "à",
                "firstDay" => "1<sup>er</sup>",
                "cadran" => ["du matin", "de l'après-midi"]
            ],


            "it" => [
                "pays" => "it",
                "mois" => ["gennaio","febbraio","marzo","aprile","maggio","giugno","luglio","agosto","settembre","ottobre","novembre","dicembre"],
                "heures" => ["ora","ora"],
                "midi" => "mezzogiorno",
                "minuit" => "mezzanotte",
                "at" => "alle",
                "firstDay" => "1º",
                "cadran" => ["di mattina", "del pomeriggio"]
            ],


            "pl" => [
                "pays" => "pl",
                "mois" => ["styczeń","luty","marzec","kwiecień","maj","czerwiec","lipiec","sierpień","wrzesień","październik","listopad","grudzień"],
                "heures" => ["godzina","godzina"],
                "midi" => "południe",
                "minuit" => "północ",
                "at" => "o",
                "firstDay" => "1",
                "cadran" => ["ranek", "popołudnie"]
            ],


            "pt" => [
                "pays" => "pt",
                "mois" => ["janeiro","fevereiro","março","abril","maio","junho","julho","agosto","setembro","outubro","novembro","dezembro"],
                "heures" => ["hora", "hora"],
                "midi" => "meio dia",
                "minuit" => "meia-noite",
                "at" => "às",
                "firstDay" => "1",
                "cadran" => ["da manhã", "da tarde"]
            ],


            "tr" => [
                "pays" => "tr",
                "mois" => ["ocak","şubat","mart","nisan","mayıs","haziran","temmuz","ağustos","eylül","ekim","kasım","aralık"],
                "heures" => ["saat","saat"],
                "midi" => "öğlen",
                "minuit" => "gece yarısı",
                "at" => "de",
                "firstDay" => "1",
                "cadran" => ["sabah", "öğleden sonra"]
            ],




        ];


        foreach($langues as $pays => $langue)
        {
            if($pays == $choix)
            {
                return $langue;
            }

        }
    

    }




    public function configuration($produitObject, $langue, $time = null)
    {

        $timeValue = "";
        $termeValue = "";


        $dateObject = $produitObject->getDateAt();

        
        $dayInteger = $dateObject->format("d");
        $monthInteger = $dateObject->format("m");
        $yearInteger = $dateObject->format("Y");

        $hourInteger24 = $dateObject->format("H");
        $hourMinuteInteger24 = $dateObject->format("H:i");
        $hourMinuteSecondeInteger24 = $dateObject->format("H:i:s");

        $hourInteger12 = $dateObject->format("h");
        $hourMinuteInteger12 = $dateObject->format("h:i");
        $hourMinuteSecondeInteger12 = $dateObject->format("h:i:s");

        $meridiem = $dateObject->format("A");



        $languageArray = $this->langues($langue);

        //dd($languageArray);

        $languagePays = $languageArray['pays'];
        $languageMois = $languageArray['mois'];
        $languageHeures = $languageArray['heures'];
        $languageMidi = $languageArray['midi'];
        $languageMinuit = $languageArray['minuit'];
        $languageAt = $languageArray['at'];
        $languageFirstDay = $languageArray['firstDay'];
        $languageCadran = $languageArray['cadran'];

        if(isset($languageArray['terme']))
        {
            $termeValue = $languageArray['terme'];
        }


        

        foreach($languageMois as $key => $value)
        {
            if($key + 1 == $monthInteger)
            {
                if($languagePays == "en")
                {
                    $monthLanguage = ucfirst($value);
                }
                else
                {
                    $monthLanguage = $value;
                }
                
            }
        }

        /*
            a la una de la manana
            a las dos 

            de la tarde

            am / pm


        */


        /* 
            Time = "H" 
            time sur 24 heures
        */
        if($time == "H")
        {
            if($hourInteger24 == 0 )
            {
                $timeValue = $languageAt . " " . $languageMinuit;
            }
            elseif($hourInteger24 == 12 )
            {
                $timeValue = $languageAt . " " . $languageMidi;
            }
            elseif($hourInteger24 == 1 )
            {
                $timeValue = $languageAt . " 1 " . $languageHeures[0];
            }
            else
            {
                $timeValue = $languageAt . " " . $hourInteger24 . " " . $languageHeures[1];
            }
            
        }

        /*
            Time = "h" 
            time sur 12 heures
            AM / PM
        */
        elseif($time == "h")
        { 
            $timeValue = "$languageAt $hourInteger12 $meridiem";
        }





        elseif($time == "Hi")
        {
            $timeValue = "$languageAt $hourMinuteInteger24";
        }
        elseif($time == "hi")
        {
            $timeValue = "$languageAt $hourMinuteInteger12 $meridiem";
        }




        elseif($time == "His")
        {
            $timeValue = "$languageAt $hourMinuteSecondeInteger24";
        }
        elseif($time == "his")
        {
            $timeValue = "$languageAt $hourMinuteSecondeInteger12 $meridiem";
        }
        

        if($dayInteger == 1)
        {
            $dayInteger = $languageFirstDay;
        }
  

        $produitObject->newDate = "$dayInteger $termeValue $monthLanguage  $yearInteger  $timeValue";
        return $produitObject;


        
    }


    public function mois($produitsArray, $langue, $time = null)
    {
        
        //dd(is_array($produitsArray));


        if(is_array($produitsArray))
        {

            foreach($produitsArray as $produitObject)
            {
                $this->configuration($produitObject, $langue, $time);
            }

        }
        else
        {
            $this->configuration($produitsArray, $langue, $time);
        }



        return $produitsArray;

    }



}